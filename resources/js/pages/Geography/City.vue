<template>
    <div>
        <v-toolbar dark
                   color="blue darken-3"
                   class="mb-1">
            <v-toolbar-title>Міста</v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    label="Пошук"
                    append-icon="mdi-magnify"
                ></v-text-field>
                <v-btn color="red" dark class="mb-2" @click="showFilter=!showFilter">Фільтр</v-btn>
            </v-card-title>

            <v-spacer></v-spacer>
            <v-select v-model="headers"
                      :items="selectedHeaders.filter(x=>x.hidden==null)"
                      label="Вибрані колонки" multiple outlined return-object>
                <template v-slot:selection="{ item, index }">
                    <v-chip v-if="index < 2">
                        <span>{{ item.text }}</span>
                    </v-chip>
                    <span v-if="index === 2" class="grey--text caption">(+{{ selectedHeaders.length - 2 }} інші)</span>
                </template>
            </v-select>
            <v-dialog max-width="700px" v-model="dialog">
                <v-btn slot="activator" color="red" dark class="mb-2">Добавити</v-btn>
                <v-card>

                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.name" label="Назва"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-autocomplete
                                        v-model="editedItem.type"
                                        :items="data.type"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Тип"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs4>
                                    <v-autocomplete
                                        v-model="editedItem.countryID"
                                        :items="data.country"
                                        :loading="isLoading.country"
                                        :search-input.sync="searchCountry"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Країна"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs4>
                                    <v-autocomplete
                                        v-model="editedItem.regionID"
                                        :items="data.region"
                                        :loading="isLoading.region"
                                        :search-input.sync="searchRegion"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Область"
                                    ></v-autocomplete>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="close">Скасувати</v-btn>
                        <v-btn color="blue darken-1" flat @click="save">Зберегти</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-data-table
            :headers="selectedHeaders.filter(x=>x.show)"
            :items="tableData"
            :total-items="total"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination"
            :loading="loading"
            class="elevation-1"
        >
            <template
                slot="items"
                slot-scope="props"
                v-if="readyData"
            >
                <td
                    v-if="'id' in props.item"
                >{{ props.item.id }}</td>
                <td
                    v-if="'type' in props.item"
                >{{ data.type.find(x=>x.id==props.item.type).name }}</td>
                <td
                    v-if="'name' in props.item"
                >{{props.item.name }}</td>
                <td
                    v-if="'region' in props.item"
                >{{props.item.region.name}}</td>
                <td
                    v-if="'country' in props.item"
                >{{props.item.country.name}}</td>

                <td class="justify-center layout px-0">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(props.item)"
                    >
                        edit
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(props.item)"
                    >
                        delete
                    </v-icon>
                </td>
            </template>
            <template slot="no-data">
                <v-btn color="primary" @click="initialize">Оновити</v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    export default {
        data: () => ({
            search: '',
            searchCountry: '',
            searchRegion: '',
            dialog: false,
            loading: true,
            dataFilter:{},
            showFilter: false,
            isLoading:{
                region: false,
                country: false
            },
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            imgDataUrl: '',
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 25},
            headers: [
                {text: 'ID', value: 'id', show:true, hidden:true},
                {text: 'Тип', value: 'type', show:true},
                {text: 'Назва', value: 'name', show:true},
                {text: 'Область', value: 'region', show:true},
                {text: 'Країна', value: 'country', show:true},
                {text: 'Дія', value: 'action', show:true, hidden:true, sortable: false},
            ],
            selectedHeaders: [],
            check:1,
            sel:[],
            readyData: 0,
            tableData: [],
            editedIndex: -1,
            data: {
                country:[],
                type:[]
            },
            editedItem: {},
            defaultItem: {
                name: ''
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити місто' : 'Редагувати місто';
            },
        },
        watch: {
            dataFilter:
            {
              handler()
              {
                this.getData();
              },
              deep: true
            },
            searchRegion(value)
            {
                if(!value && value!='')
            {
                return;
            }
            this.isLoading.region = true;
            axios.post('/api/region/search',{
                 'word':this.searchRegion
            }).then(response=>{
                switch (response.data.status) {
                    case 200:
                        this.data.region=response.data.value
                        break;
                    }
            })
            .finally(()=>{
                this.isLoading.region = false
            });
            },
            searchCountry(value)
            {
                if(!value && value!='')
            {
                return;
            }
            this.isLoading.country = true;
            axios.post('/api/country/search',{
                 'word':this.searchCountry
            }).then(response=>{
                switch (response.data.status) {
                    case 200:
                        this.data.country=response.data.value
                        break;
                    }
            })
            .finally(()=>{
                this.isLoading.country = false
            });
            },
            dialog(val) {
                val || this.close();
            },
            pagination() {
                this.getData();
            },
            search() {
                this.getData();
            },
            headers()
            {
                this.selectedHeaders.map(x=>x.show=this.headers.includes(x));
                this.getData();
            }
        },
        created() {
            this.selectedHeaders = this.headers;
            this.editedItem = this.defaultItem;
            this.initialize();
        },
        methods: {
            initialize() {
                axios.post('/api/city/data').then((response)=> {
                    this.data = response.data.value
                    this.readyData=1
                });
            },
            getData()
            {
                const direction = this.pagination.descending ? 'desc' : 'asc';
                this.loading=true;
                axios.post('/api/city/search',{
                    'word':this.search,
                    'page':this.pagination.page,
                    'numberPage':this.pagination.rowsPerPage,
                    'filter':this.dataFilter,
                    'direction':direction,
                    'sortBy':this.pagination.sortBy,
                    'select':this.headers.map(x=>x.value)
                }).then((response) => {
                    switch(response.data.status)
                    {
                        case 200:
                            this.tableData = response.data.value;
                            this.total=response.data.all;
                            break;
                        default: alert("Error: "+response.data.value);    
                    }
                }).finally(this.loading=false);
            },
            editItem(item) {
                this.editedIndex = this.tableData.indexOf(item);
                axios.post('/api/city/'+this.tableData[this.editedIndex].id).then(response=>{
                    this.editedItem=response.data.value;
                    this.data.region.indexOf(this.editedItem.region) === -1? this.data.region.push(this.editedItem.region) : 1;
                })
                this.dialog=true;
            },
            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити це місто?') && axios
                    .delete('/api/city/'+item.id+'/delete').then((response)=> {
                        console.log(response.data)
                        switch (response.data.status) {
                            case 200:
                                this.getData();
                                break;
                            default: alert("Error: "+response.data.value)
                        }
                    })
            },
            close() {
                this.dialog=false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                }, 300);
            },
            save() {
                if (this.editedIndex > -1) {
                    axios.put('/api/city/'+this.editedItem.id+"/edit",this.editedItem).then((response)=> {
                        console.log(response.data)
                        switch (response.data.status) {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default:alert("Error:"+response.data.value)
                        }
                        console.log(response.data);
                    });
                } else {
                    axios.post('/api/city/add',this.editedItem).then((response)=>
                    {
                        switch(response.data.status) {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert("Error: "+response.data.value);
                        }
                        console.log(response.data);
                    });

                }
            }
        },
    };
</script>
