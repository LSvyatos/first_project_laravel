<template>
    <div>
        <v-toolbar dark
                   color="blue darken-3"
                   class="mb-1">
            <v-toolbar-title>Заявки</v-toolbar-title>
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
                                    <v-autocomplete
                                        v-model="editedItem.client"
                                        :items="data.clients"
                                        item-value="id"
                                        :item-text="item=>item.lastname+' '+item.name+' '+item.surname"
                                        dense
                                        filled
                                        small-chips
                                        label="Клієнт"
                                        @change="selectUser"
                                    ></v-autocomplete>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.name" label="Ім'я" type="text"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.lastname" label="Прізвище" type="text"></v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.surname" label="По батькові" type="text"></v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="editedItem.vacancy"
                                        :items="data.vacancy"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Вакансія"
                                    ></v-autocomplete>
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
            <template slot="items" slot-scope="props" v-if="dataReady">
                <td>{{ props.item.id }}</td>
                <td
                   v-if="'item' in props.item"
                >{{ data.status.find(x=>x.id===props.item.status).name }}</td>
                <td 
                   v-if="'client' in props.item"
                >{{ data.clients.find(x=>x.id===props.item.client).name }} {{data.clients.find(x=>x.id===props.item.client).lastname}}</td>

                <td
                   v-if="'vacancy' in props.item"
                   
                >{{ data.vacancy.find(x=>x.id===props.item.vacancy).name}}</td>

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
            dialog: false,
            loading: false,
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            phone: '',
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
            headers: [
                {text: 'ID', value: 'id',show:true, hidden:true},
                {text: 'Статус', value: 'status', show:true},
                {text: 'Клієнт', value: 'client', show:true},
                {text: 'Вакансія', value: 'vacancy', show:true},
                {text: 'Дія', value: 'action', show:true, hidden:true, sortable: false},
            ],
            selectedHeaders: [],
            check:1,
            sel:[],
            dataReady: 0,
            tableData: [],
            editedIndex: -1,
            data: {
                clients:[],
                vacancy:[],
                status:[]
            },
            editedItem: {},
            defaultItem: {
                client: 0,
                vacancy: 0,
                name: '',
                lastname: '',
                surname: ''
            }
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити заявку' : 'Редагувати заявку';
            },
        },

        watch: {
            dialog(val) {
                val || this.close();
            },
            dataFilter:{
                handler()
                {
                    this.getData();
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
            this.selectedHeaders = this.headers;
            this.editedItem = this.defaultItem;
            this.initialize();
        },

        methods: {
            selectUser(e)
            {
                if(e) {
                    let user = this.data.clients.find(x => x.id === e);
                    this.editedItem.name = user.name;
                    this.editedItem.lastname = user.lastname;
                    this.editedItem.surname = user.surname;
                }
            },
            initialize() {
                axios.post('/api/application/data').then((response) => {
                    switch (response.data.status) {
                        case 200:
                            this.data = response.data.value;
                            this.dataReady = 1
                            break;
                    }
                });
            },
            getData()
            {
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/application/search',{
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
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
            },

            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити цю заявку?') &&
                axios.delete('/api/application/'+item.id+'/delete').then((response)=> {
                    switch (response.data.status) {
                        case 200:
                            this.tableData.splice(index, 1);
                            break;
                        default: alert(response.data.value)
                    }
                    console.log(response.data)
                })

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
                    axios.put('/api/application/'+this.editedItem.id+"/edit",this.editedItem).then((response)=> {
                        console.log(response.data);
                        switch(response.data.status)
                        {
                            case 200:
                             Object.assign(this.tableData[this.editedIndex], this.editedItem);
                             this.close();
                             break;
                            default: alert(response.data.value);
                        }
                    });
                } else {
                    axios.post('/api/application/add',this.editedItem).then((response)=>
                    {
                        switch(response.data.status) {
                            case 200:
                                console.log(response.data);
                                this.editedItem.id = response.data.value;
                                this.tableData.push(this.editedItem);
                                this.close();
                                break;

                            default: alert(response.data.value);
                        }
                    });
                }
            },
        },
    };
</script>
