<template>
    <div>
        <v-toolbar dark
                   color="blue darken-3"
                   class="mb-1">
            <v-toolbar-title>Категорії</v-toolbar-title>
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
            <v-dialog v-model="dialog" max-width="700px">
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
                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.description" label="Опис"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="editedItem.parentID"
                                        :items="data.category"
                                        :search-input.sync="searchCategory"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Категорія">

                                    </v-autocomplete>
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
            <template slot="items" slot-scope="props">
                <td
                    v-if="'id' in props.item && props.item.id!==null"
                >{{ props.item.id }}</td>

                <td
                    v-if="'parent' in props.item && props.item.parent!==null"
                >{{ props.item.parent.name }}</td>
                <td v-else-if="'parent' in props.item"></td>

                <td
                    v-if="'name' in props.item && props.item.name!==null"
                >{{ props.item.name }}</td>

                <td
                    v-if="'description' in props.item && props.item.description!==null"
                >{{ props.item.description }}</td>

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
            searchCategory: '',
            dialog: false,
            loading: false,
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            phone: '',
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
            headers: [
                {text: 'ID', value: 'id', show:true, hidden:true},
                {text: 'Категорія', value: 'parent', show:true},
                {text: 'Назва', value: 'name', show:true},
                {text: 'Опис', value: 'description', show:true},
                {text: 'Дія', value: 'action', show:true, hidden:true, sortable: false},
            ],
            selectedHeaders: [],
            check:1,
            sel:[],
            tableData: [],
            editedIndex: -1,
            data: {},
            editedItem: {
                name: '',
                description: '',
                parentID: 0,
            },
            defaultItem: {}
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити вакансію' : 'Редагувати вакансію';
            },
        },

        watch: {
            searchCategory(value){

               this.goSearchCategory();
            },
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
            headers()
            {
                this.selectedHeaders.map(x=>x.show=this.headers.includes(x));
                this.getData();
            }
        },
        created() {
            this.selectedHeaders=this.headers;
            this.defaultItem=this.editedItem;
            this.initialize();
        },

        methods: {
            goSearchCategory()
            {
                axios.post('/api/vacancy/category/search',{
                    'word':this.searchCategory
                }).then(response=>{
                    this.data.category=response.data.value
                })
            },
            initialize() {
                //axios.post('/api/vacancy/city').then(response=>this.data.city=response.data.value);
                //axios.post('/api/vacancy/category').then(response=>this.data.category=response.data.value);
                /*axios.post('/api/vacancy/data').then((response)=>{
                    this.data.changes=response.data.value.changes;
                    this.data.sex=response.data.value.sex;
                    this.data.visa=response.data.value.visa;
                    this.data.season=response.data.value.season;
                    this.data.urgently=response.data.value.urgently;
                });*/
            },
            getData()
            {
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/vacancy/category/search',{
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
                this.loading=false;
            }).finally(this.loading=false);
            },

            editItem(item) {
                this.editedIndex = this.tableData.indexOf(item);
                axios.post('/api/vacancy/category/'+this.tableData[this.editedIndex].id).then((response)=>{
                    this.goSearchCategory();
                    this.editedItem = response.data.value;
                    setTimeout(()=>this.dialog = true,100);
                })
            },

            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити цю категорію?') && this.tableData.splice(index, 1);

                axios.delete('/api/vacancy/category/'+item.id+'/delete').then(response=>console.log(response.data))

            },

            close() {
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                }, 300);
            },

            save() {
                if (this.editedIndex > -1) {
                    axios.put('/api/vacancy/category/'+this.editedItem.id+"/edit",this.editedItem).then((response)=> {
                        switch(response.data.status)
                        {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert(response.data.value);    
                        }
                        console.log(response.data);
                    });
                } else {
                    axios.post('/api/vacancy/category/add',this.editedItem).then((response)=>
                    {
                        switch(response.data.status) {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert(response.data.value);
                        }
                        console.log(response.data);
                    });
                }
            },
        },
    };
</script>
