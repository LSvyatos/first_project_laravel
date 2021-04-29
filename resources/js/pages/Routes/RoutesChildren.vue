<template>
    <div>
        <v-toolbar dark
                   color="blue darken-3"
                   class="mb-1">
            <v-toolbar-title>Маршрути</v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    label="Пошук"
                    clearable
                    append-icon="mdi-magnify"
                ></v-text-field>
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
                                    <v-autocomplete
                                        v-model="editedItem.routeID"
                                        :items="data.routes"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Маршрути"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs6>
                                    <v-autocomplete
                                        v-model="editedItem.fromID"
                                        :items="data.cityFrom"
                                        :loading="isLoading.cityFrom"
                                        :search-input.sync="searchCityFrom"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Звідки"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs6>
                                    <v-autocomplete
                                        v-model="editedItem.toID"
                                        :items="data.cityTo"
                                        :loading="isLoading.cityTo"
                                        :search-input.sync="searchCityTo"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Куди"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field v-model="editedItem.priceUAN" label="Ціна в UAN" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field v-model="editedItem.pricePLN" label="Ціна в PLN" type="number"></v-text-field>
                                </v-flex>
                                <v-flex>
                                    <h3>Старт</h3>
                                    <v-time-picker
                                        v-model="editedItem.timeFrom"
                                        color="blue darken-3"
                                        class="mt-4"
                                        format="24hr"
                                        scrollable
                                        min="00:00"
                                        max="23:59"
                                    ></v-time-picker>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea
                                        v-model="editedItem.text"
                                        label="Додаток"
                                    ></v-textarea>
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
            <template slot="items" slot-scope="props" v-if="readyData">
                <td>{{ props.item.id }}</td>
                <td
                   v-if="'route' in props.item"
                >{{ props.item.route.name+', '+props.item.route.toName+' - '+props.item.route.fromName }}</td>
                <td
                   v-if="'from' in props.item"
                >{{ props.item.from.name }}</td>
                <td
                   v-if="'to' in props.item"
                >{{ props.item.to.name }}</td>

                <td 
                   class="justify-center"
                   v-if="'timeFrom' in props.item"
                >{{ props.item.timeFrom }}</td>

                <td
                   v-if="'priceUAN' in props.item"
                >{{ props.item.priceUAN }}</td>
                <td
                   v-if="'pricePLN' in props.item"
                >{{ props.item.pricePLN }}</td>
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
            searchCityFrom: '',
            searchCityTo: '',
            isLoading: {
                cityFrom: false,
                cityTo: false
            },
            dialog: false,
            loading: false,
            dataFilter:{},
            showFilter: false,
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            phone: '',
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
            headers: [
                {text: 'ID', value: 'id', show:true, hidden:true},
                {text: 'Маршрут', value: 'routeID', show:true},
                {text: 'Звідки', value: 'fromID', show:true},
                {text: 'Куди', value: 'toID', show:true},
                {text: 'Час виїзду', value: 'timeFrom', show:true},
                {text: 'Ціна в UAN', value: 'priceUAN', show:true},
                {text: 'Ціна в PLN', value: 'pricePLN', show:true},
                {text: 'Дія', value: 'action', show:true, hidden:true, sortable: false},
            ],
            selectedHeaders: [],
            check:1,
            sel:[],
            readyData: 0,
            tableData: [],
            editedIndex: -1,
            data: {
                city:[],
                routes:[]
            },
            editedItem: {},
            defaultItem: {
                name: '',
                route: 1,
                from:1,
                to:1,
                timeFrom:'00:00',
                priceUAN:0,
                pricePLN:0
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити підмаршрут' : 'Редагувати підмаршрут';
            },
        },
        watch: {
            dialog(val) {
                val || this.close();
            },
            dataFilter:{
                handler()
                {
                    this.getUsers();
                },
                deep: true
            },
            pagination() {
                this.getData();
            },
            search() {
                this.getData();
            },
            searchCityFrom(value)
            {
            if(!value && value!='')
            {
                return;
            }
            this.isLoading.cityFrom = true;
            axios.post('/api/city/search',{
                 'word':this.searchCityFrom
            }).then(response=>{
                switch (response.data.status) {
                    case 200:
                        this.data.cityFrom=response.data.value
                        break;
                    }
            })
            .finally(()=>{
                this.isLoading.cityFrom = false
            });
        },
        searchCityTo(value)
        {
            if(!value && value!='')
            {
                return;
            }
            this.isLoading.cityTo = true;
            axios.post('/api/city/search',{
                 'word':this.searchCityTo
            }).then(response=>{
                switch (response.data.status) {
                    case 200:
                        this.data.cityTo=response.data.value
                        break;
                    }
            })
            .finally(()=>{
                this.isLoading.cityTo = false
            });
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
                axios.post('/api/routes/route/data').then((response)=> {
                    this.data = response.data.value;
                    this.data.cityTo=this.data.city;
                    this.data.cityFrom=this.data.city;
                    this.readyData=1;
                });
            },
            getData()
            {
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/routes/route/search',{
                    'word':this.search,
                    'page':this.pagination.page,
                    'numberPage':this.pagination.rowsPerPage,
                    'filter':this.dataFilter,
                    'direction':direction,
                    'sortBy':this.pagination.sortBy,
                    'select':this.headers.map(x=>x.value)
                }).then((response) => {
                    switch (response.data.status) {
                        case 200:
                            this.tableData = response.data.value;
                            this.total=response.data.all;
                            break;
                    }

                }).finally(this.loading=false);
            },
            editItem(item) {
                this.editedIndex = this.tableData.indexOf(item);
                this.editedItem = Object.assign({}, item);
                axios.post('/api/routes/route/'+this.tableData[this.editedIndex].id).then(response=>{
                    this.editedItem=response.data.value;
                })
                this.dialog=true;
            },
            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити цей маршрут?') && this.tableData.splice(index, 1);

                axios.delete('/api/routes/route/'+item.id+'/delete').then(response=>console.log(response.data))

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
                    axios.put('/api/routes/route/'+this.editedItem.id+"/edit",this.editedItem).then((response)=> {
                        switch (response.data.status) {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert(response.data.value);
                        }
                        console.log(response.data);
                    });
                } else {
                    axios.post('/api/routes/route/add',this.editedItem).then((response)=>
                    {
                        switch(response.data.status) {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert(response.data.value);
                        }
                    });
                }
            }
        },
    };
</script>
