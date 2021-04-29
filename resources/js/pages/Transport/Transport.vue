<template>
    <div>
        <template>
        <v-layout 
           v-if="showFilter"
           row 
           wrap
        >
        <v-flex xs6>
            <v-select
                    v-model="dataFilter.type"
                    :items="data.type"
                    label="Тип"
                    item-value="id"
                    item-text="name"
                    clearable
                    dense
                    filled
                    small-chips
            ></v-select>
        </v-flex>
        </v-layout>
        </template>
        <v-toolbar dark flat color="blue darken-3">
            <v-toolbar-title>Транспорт</v-toolbar-title>
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
            <v-dialog v-model="dialog" max-width="700px">
                <v-btn slot="activator" color="red" dark class="mb-2">Добавити</v-btn>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.name" label="Назва"></v-text-field>
                                </v-flex>
                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.number" label="Номер"></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field v-model="editedItem.placeFrom" label="Місце З" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field v-model="editedItem.placeTo" label="Місце ДО" type="number"></v-text-field>
                                </v-flex>
                                <v-flex>
                                    <v-select
                                        v-model="editedItem.type"
                                        :items="data.type"
                                        label="Тип"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea
                                        v-model="editedItem.text"
                                        label="Додаток"
                                    ></v-textarea>
                                </v-flex>
                                <v-flex>
                                    <h3>Наступний тех-огляд</h3>
                                    <v-date-picker
                                        v-model="editedItem.dataNextTeh"
                                        color="blue darken-3"
                                        locale="uk"
                                    ></v-date-picker>
                                </v-flex>
                                <v-flex>
                                    <h3>Наступна зелена карта</h3>
                                    <v-date-picker
                                        v-model="editedItem.dataNextGreenCard"
                                        color="blue darken-3"
                                        locale="uk"
                                    ></v-date-picker>
                                </v-flex>
                                <v-flex>
                                    <h3>Наступний перетин кордону</h3>
                                    <v-date-picker
                                        v-model="editedItem.dataNextBorderCrossing"
                                        color="blue darken-3"
                                        locale="uk"
                                    ></v-date-picker>
                                </v-flex>
                                <!---<v-flex xs12 >
                                    <v-text-field v-model="editedItem.confirm_password" label="Confirm Password"></v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <h3>Roles</h3>
                                    <v-select
                                        v-model="editedItem.role"
                                        :items="allRoles"
                                        label="Roles"
                                        item-text="name"
                                        return-object
                                        chips
                                    ></v-select>
                                </v-flex>

                                <v-flex xs12>
                                    <v-select
                                        v-model="editedItem.permissions"
                                        :items="allPermissions"
                                        label="Permissions"
                                        item-text="name"
                                        return-object
                                        multiple
                                        chips
                                    ></v-select>
                                </v-flex>--->

                            </v-layout>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="close">Скасувати</v-btn>
                        <v-btn color="blue darken-1" flat @click="save">Зберегети</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-data-table
            :headers="headers"
            :items="tableData"
            :total-items="total"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination"
            :loading="loading"
            class="elevation-1"
        >
            <template slot="items"
                      slot-scope="props"
                      v-if="readyData"
            >
                <td
                    v-if="'id' in props.item"
                >{{ props.item.id }}</td>
                <td
                    v-if="'name' in props.item"
                >{{ props.item.name }}</td>
                <td
                    v-if="'number' in props.item"
                >{{ props.item.number }}</td>
                <td
                    v-if="'placeFrom' in props.item"
                >{{ props.item.placeFrom }}</td>
                <td
                    v-if="'placeTo' in props.item"
                >{{ props.item.placeTo }}</td>
                <td
                    v-if="'type' in props.item"
                >{{ data.type.find(x=>x.id==props.item.type).name }}</td>
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
            search:'',
            dialog: false,
            loading: false,
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            phone: '',
            showFilter: false,
            dataFilter:{},
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
            headers: [
                {text: 'ID', value: 'id', show:true, hidden:true},
                {text: 'Назва', value: 'name', show:true},
                {text: 'Номер', value: 'number', show:true},
                {text: 'Місце З', value: 'placeFrom', show:true},
                {text: 'Місце ДО', value: 'placeTo', show:true},
                {text: 'Тип', value:'type', show:true},
                {text: 'Дії', value: 'action', show:true, hidden:true, sortable: false},
            ],
            selectedHeaders: [],
            tableData: [],
            readyData: 0,
            editedIndex: -1,
            data: {
                type:[]
            },
            allRoles:[],
            allPermissions:[],
            editedItem: {
                name: '',
                number: '',
            },
            defaultItem: {
                name: '',
                number: '',
            },

        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити транспорт' : 'Редагувати транспорт';
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
                axios.post('/api/transport/data').then(response => {
                    this.data = response.data.value;
                    this.readyData = 1
                })
            },
            getData()
            {
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/transport/search',{
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
                this.dialog = true;
            },

            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Are you sure you want to delete this item?') && this.tableData.splice(index, 1);

                axios.delete('/api/transport/'+item.id+'/delete').then(response=>console.log(response.data))

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
                    Object.assign(this.tableData[this.editedIndex], this.editedItem);
                    axios.put('/api/transport/'+this.editedItem.id+'/edit',this.editedItem).then(response=>console.log(response.data));
                } else {
                    axios.post('/api/transport/add',this.editedItem).then((response)=>
                    {
                        if(response.data.status==200)
                        {
                            console.log(response.data);
                            this.editedItem.id=response.data.value;
                            this.tableData.push(this.editedItem);
                        }
                    });
                }
                this.close();
            },
        },
    };
</script>
