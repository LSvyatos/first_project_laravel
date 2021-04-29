<template>
    <div>
        <template>
        <v-layout 
           v-if="showFilter"
           row 
           wrap
        >
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.transportID"
                    :items="data.transport"
                    label="Транспорт"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.stewardID"
                    :items="data.drivers"
                    label="Стюард"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.routeID"
                    :items="data.routes"
                    label="Маршрут"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs6>
            <h5>Дата</h5>
            <v-date-picker
                    v-model="dataFilter.timeFrom"
                    locale="UA"
                    first-day-of-week="1"
                    clearable
            ></v-date-picker>
        </v-flex>
        </v-layout>
        </template>
        <v-toolbar dark
                   color="blue darken-3"
                   class="mb-1">
            <v-toolbar-title>Рейси</v-toolbar-title>
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
                                <!--<v-flex xs12>
                                    <v-text-field v-model="editedItem.name" label="Назва"></v-text-field>
                                </v-flex>-->
                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="editedItem.routeID"
                                        :items="data.routes"
                                        item-value="id"
                                        :item-text="item => item.name +', '+ item.from.name+' - '+item.to.name"
                                        dense
                                        filled
                                        small-chips
                                        label="Маршрут"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="editedItem.transportID"
                                        :items="data.transport"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Транспорт"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field
                                        v-model="editedItem.perhapFrom"
                                        label="Місце З"
                                        type="number"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field
                                        v-model="editedItem.perhapTo"
                                        label="Місце ДО"
                                        type="number"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="editedItem.drivers"
                                        :items="data.drivers"
                                        item-value="id"
                                        :item-text="item=>item.name+' '+item.lastname"
                                        label="Водії"
                                        chips
                                        hide-no-data 
                                        hide-selected
                                        deletable-chips
                                        multiple
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="editedItem.stewardID"
                                        :items="data.drivers"
                                        item-value="id"
                                        :item-text="item=>item.name+' '+item.lastname"
                                        dense
                                        filled
                                        small-chips
                                        label="Стюард"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs3>
                                    <v-text-field
                                        v-model="editedItem.zvitUAN"
                                        label="UAN"
                                        type="number"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs3>
                                    <v-text-field
                                        v-model="editedItem.zvitPLN"
                                        label="PLN"
                                        type="number"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs3>
                                    <v-text-field
                                        v-model="editedItem.zvitUSD"
                                        label="USD"
                                        type="number"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs3>
                                    <v-text-field
                                        v-model="editedItem.zvitEUR"
                                        label="EUR"
                                        type="number"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea
                                        v-model="editedItem.text"
                                        label="Додаток"
                                    ></v-textarea>
                                </v-flex>
                                <v-flex>
                                    <h3>Старт</h3>
                                    <v-date-picker
                                        v-model="editedItem.timeFrom"
                                        color="blue darken-3"
                                        locale="uk"
                                    ></v-date-picker>
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
            <template slot="items"
                      slot-scope="props"
                      v-if="dataReady"
            >
                <td
                    v-if="selectedHeaders.find(x=>x.value=='id').show"
                >{{ props.item.id }}</td>
                <td
                    v-if="'route' in props.item"
                >{{ props.item.route.name+', '+props.item.route.fromName+' - '+props.item.route.toName }}</td>
                <td
                    v-if="'transport' in props.item"
                >{{ props.item.transport.name }}</td>
                <td
                    v-if="'steward' in props.item"
                >{{ props.item.steward.name+' '+props.item.steward.lastname }}</td>
                <td
                    v-if="'timeFrom' in props.item"
                >{{ props.item.timeFrom }}</td>

                <td
                    v-if="'text' in props.item && props.item.text!==null"
                >{{ props.item.text }}</td>
                <td
                    v-else-if="'text' in props.item"
                ></td>

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
                {text: 'ID', value: 'id', show:true, hidden:true},
                {text: 'Маршрут', value: 'route', show:true},
                {text: 'Транспорт', value: 'transport', show:true},
                {text: 'Стюард', value: 'steward', show:true},
                {text: 'Дата', value: 'timeFrom', show:true},
                {text: 'Додаток', value: 'text', show:true},
                {text: 'Дія', value: 'action', show:true, hidden:true, sortable: false},
            ],
            showFilter:false,
            selectedHeaders: [],
            dataFilter:{},
            check:1,
            dataReady:0,
            sel:[],
            tableData: [],
            editedIndex: -1,
            data: {},
            editedItem: {},
            defaultItem: {
                name: ''
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити рейс' : 'Редагувати рейс';
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
            initialize() {
                axios.post('/api/trip/data').then((response) => {
                    switch (response.data.status) {
                        case 200:
                            this.data = response.data.value
                            this.dataReady = 1
                            break;
                        default:
                            window.location.reload()
                    }
                });
            },
            getData()
            {
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/trip/search',{
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
                axios.post('/api/trip/'+this.tableData[this.editedIndex].id).then(response=>{
                    this.editedItem=response.data.value;
                })
                this.dialog=true;
            },
            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити цей рейс?') &&
                axios.delete('/api/trip/'+item.id+'/delete').then((response)=> {
                    console.log(response.data)
                    switch (response.data.status) {
                        case 200:
                            alert("Успішно!");
                            this.tableData.splice(index, 1);
                            break;
                        default: alert(response.data.value)
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
                    axios.put('/api/trip/'+this.editedItem.id+"/edit",this.editedItem).then((response)=> {
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
                    axios.post('/api/trip/add',this.editedItem).then((response)=>
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
            }
        },
    };
</script>
