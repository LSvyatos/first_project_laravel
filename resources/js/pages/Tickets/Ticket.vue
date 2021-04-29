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
                    :items="data.transports"
                    label="Транспорт"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.currencyID"
                    :items="data.currency"
                    label="Валюта"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.typePaymentID"
                    :items="data.typePayment"
                    label="Тип оплати"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs6>
            <v-autocomplete
                    v-model="dataFilter.clientID"
                    :items="data.clients"
                    :loading="isLoading.cityFilter"
                    :search-input.sync="searchClientFilter"
                    label="Клієнт"
                    item-value="id"
                    :item-text="textClientsSelect"
                    clearable
            ></v-autocomplete>
        </v-flex>
        <v-flex xs6>
            <v-autocomplete
                    v-model="dataFilter.tripID"
                    :items="data.trip"
                    label="Рейс"
                    item-value="id"
                    :item-text="item=>item.route.name"
                    clearable
            ></v-autocomplete>
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
        <v-flex xs6>
            <h5>Дата створення</h5>
            <v-date-picker
                    v-model="dataFilter.created_at"
                    locale="UA"
                    first-day-of-week="1"
                    clearable
            ></v-date-picker>
        </v-flex>
        </v-layout>
        </template>
        <v-toolbar dark flat color="blue darken-3">
            <v-toolbar-title>Квитки</v-toolbar-title>
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
                                <v-flex xs12>
                                    <h3>Рейс</h3>
                                    <v-autocomplete
                                        v-model="editedItem.tripID"
                                        :items="data.trip"
                                        :loading="isLoading.trip"
                                        
                                        item-value="id"
                                        :item-text="item=>item.from.name+' - '+item.timeFrom"
                                        label="Рейс"
                                        clearable
                                        hide-details
                                        hide-selected
                                        chips
                                        
                                    ></v-autocomplete>
                                </v-flex>
                                <!--<v-flex xs12>
                                    <v-autocomplete
                                        v-if="data.trip && data.trip.length>0"
                                        v-model="editedItem.trip"
                                        :items="data.trip"
                                        item-value="id"
                                        item-text="timeFrom"
                                        dense
                                        filled
                                        small-chips
                                        label="Дата"
                                    ></v-autocomplete>
                                </v-flex>-->
                                <v-flex xs4>
                                    <div v-if="data.route">
                                        <h6>Відправка:</h6>
                                        <h2 v-if="data.route">{{data.route.timeFrom}}</h2>
                                    </div>
                                </v-flex>
                                <v-flex xs4>
                                    <div v-if="data.route">
                                        <h6>Вартість UAN:</h6>
                                        <h2 v-if="data.route">{{data.route.priceUAN}}</h2>
                                    </div>
                                </v-flex>
                                <v-flex xs4>
                                    <div v-if="data.route">
                                        <h6>Вартість PLN:</h6>
                                        <h2>{{data.route.pricePLN}}</h2>
                                    </div>
                                </v-flex>
                                <v-flex xs6>
                                    <v-autocomplete
                                        v-model="editedItem.fromID"
                                        :items="data.cityFrom"
                                        label="Звідки"
                                        item-value="id"
                                        item-text="name"
                                        :loading="isLoading.CityFrom"
                                        :search-input.sync="searchCityFrom"
                                        clearable
                                        hide-details
                                        hide-selected
                                        chips
                                    >
                                    </v-autocomplete>
                                </v-flex>
                                <v-flex xs6>
                                    <v-autocomplete
                                        v-model="editedItem.toID"
                                        :items="data.cityTo"
                                        label="Куди"
                                        :search-input.sync="searchCityTo"
                                        :loading="isLoading.CityTo"
                                        item-value="id"
                                        item-text="name"
                                        clearable
                                        hide-details
                                        hide-selected
                                        chips
                                    >
                                    </v-autocomplete>
                                </v-flex>
                                <v-flex xs12>
                                    <h3>Клієнт</h3>
                                </v-flex>
                                <v-flex xs9>
                                    <v-autocomplete
                                        v-model="editedItem.clientID"
                                        :items="data.clients"
                                        label="Клієнт"
                                        :loading="isLoading.client"
                                        :search-input.sync="searchClient"
                                        item-value="id"
                                        :item-text="textClientsSelect"
                                        clearable
                                        hide-details
                                        hide-selected
                                        chips
                                    >
                                    </v-autocomplete>
                                </v-flex>
                                <v-flex xs3>
                                    <v-autocomplete
                                        v-model="editedItem.perhapID"
                                        :items="data.perhaps"
                                        item-value="id"
                                        item-text="perhap"
                                        type="number"
                                        label="Місце"
                                        :loading="isLoading.perhap"
                                        :search-input.sync="searchPerhap"
                                        clearable
                                        hide-details
                                        hide-selected
                                        chips
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.lastname" label="Прізвище"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.name" label="Ім'я"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.surname" label="По-батькові"></v-text-field>
                                </v-flex>
                                <v-flex xs3>
                                    <v-text-field
                                        v-model="editedItem.price"
                                        type="number"
                                        label="Ціна"
                                    ></v-text-field>

                                </v-flex>
                                <v-flex xs3>
                                    <v-select
                                        v-model="editedItem.currencyID"
                                        :items="data.currency"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Валюта"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs3>
                                    <v-select
                                        v-model="editedItem.typePaymentID"
                                        :items="data.typePayment"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        label="Оплата"
                                    ></v-select>
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
                        <v-btn color="blue darken-1" flat @click="save">Зберегети</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        
        <v-data-table
            v-model="selected"
            :single-select="singleSelect"
            :headers="selectedHeaders.filter(x=>x.show)"
            :items="tableData"
            group-by="timeFrom"
            show-group-by
            :total-items="total"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination"
            :loading="loading"
            class="elevation-1"
            show-select
        >
            <template
                   slot="items"
                   slot-scope="props"
                   v-if="dataReady"
            >
            <tr :active="props.selected" @click="props.selected = !props.selected">
                <td>
                 <v-checkbox
                   primary
                   hide-details
                  :input-value="props.selected"
                 ></v-checkbox>
                </td> 
                <td>{{ props.item.id }}</td>
                <td
                   v-if="'perhap' in props.item"
                >{{ props.item.perhap.perhap }}</td>
                <td
                   v-if="'transport' in props.item"
                >{{ props.item.transport.name }}</td>
                <td
                   v-if="'clientText' in props.item"
                >{{ props.item.clientText }}</td>
                <td
                   v-if="'from' in props.item"
                >{{ props.item.from.name }}</td>
                <td
                   v-if="'to' in props.item"
                >{{ props.item.to.name }}</td>
                <td
                   v-if="'price' in props.item"
                >{{ props.item.price }}</td>
                <td
                   v-if="'currency' in props.item"
                >{{ props.item.currency.value }}</td>
                <td
                   v-if="'type_payment' in props.item"
                >{{ props.item.type_payment.value }}</td>
                <td
                   v-if="'timeFrom' in props.item"
                >{{ props.item.timeFrom }}</td>
                <td>{{ props.item.created_at }}</td>
                <td class="justify-center layout px-0">
                    <!--<v-icon
                        small
                        class="mr-2"
                        @click="editItem(props.item)"
                    >
                        edit
                    </v-icon>-->
                    <v-icon
                        small
                        @click="deleteItem(props.item)"
                    >
                        delete
                    </v-icon>
                </td>
                </tr>
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
            searchClient: '',
            searchClientFilter: '',
            searchCityFrom: '',
            searchCityTo: '',
            searchPerhap: '',
            searchTrip: '',
            dataFilter:{},
            showFilter: false,
            isLoading:{
                CityFrom: false,
                CityTo: false,
                client: false,
                clientFilter: false,
                perhap: false,
                trip: false,
            },
            selected: [],
            singleSelect: false,
            isLoadingCityFrom: false,
            isLoadingCityTo: false,
            singleSelect:false,
            dialog: false,
            loading: false,
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            phone: '',
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
            dataReady: 0,
            headers: [
                {text: 'Вибрати', value: 'selected', show:true, hidden:true},
                {text: 'ID', value: 'id', show:true, hidden:true},
                {text: 'Місце', value: 'perhap', show:true},
                {text: 'Транспорт', value: 'transport', show:true},
                {text: 'Клієнт', value: 'clientText', show:true},
                {text: 'Звідки', value: 'from', show:true},
                {text: 'Куди', value: 'to', show:true},
                {text: 'Ціна', value: 'price', show:true},
                {text: 'Валюта', value: 'currency', show:true},
                {text: 'Спосіб оплати', value: 'typePayment', show:true},
                {text: 'Дата', value: 'timeFrom', show:true},
                {text: 'Створено', value: 'created_at', show:true},
                {text: 'Дії', value: 'action', show:true, hidden:true, sortable: false},
            ],
            selectedHeaders: [],
            tableData: [],
            editedIndex: -1,
            allRoles:[],
            allPermissions:[],
            data: {
                cityTo:[]
            },
            editedItem: {},
            defaultItem: {
                lastname: '',
                name: '',
                surname: '',
                cityFrom: 0,
                cityTo: 0
            },

        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити квиток' : 'Редагувати квиток';
            },
        },

        watch: {
            dialog(val) {
                val || this.close();
            },
            searchTrip(value)
            {
                console.log(this.searchTrip)
                return
            },
            searchCityFrom(value)
            {
                if(!value && value!='')
                {
                    return;
                }
                this.isLoading.CityFrom = true;
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
                    this.isLoading.CityFrom = false
                });
            },
            searchCityTo(value)
            {
                if(!value && value!='')
                {
                    return;
                }
                this.isLoading.CityTo = true
                axios.post('/api/city/search',{
                    'word':this.searchCityTo
                }).then(response=>{
                    switch(response.data.status)
                    {
                        case 200:
                            this.data.cityTo=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.CityTo = false;
                });
            },
            searchClientFilter(value)
            {
                if(!value && value!='')
                {
                    return;
                }
                this.isLoading.clientFilter = true;
                axios.post('/api/client/search',{
                    'word':this.searchClientFilter,
                    'sortBy': 'id',
                    'direcrtion': 'desc'
                }).then(response=>{
                    switch(response.data.status)
                    {
                        case 200:
                            this.data.clients=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.clientFilter = false;
                });
            },
            searchClient(value)
            {
                if(!value && value!='')
                {
                    return;
                }
                this.isLoading.client = true;
                axios.post('/api/client/search',{
                    'word':this.searchClient,
                    'sortBy': 'id',
                    'direcrtion': 'desc'
                }).then(response=>{
                    switch(response.data.status)
                    {
                        case 200:
                            this.data.clients=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.client = false;
                });
            },
            searchPerhap(value)
            {
                if(!value && value!='')
                {
                    return;
                }
                this.isLoading.perhap = true;
                axios.post('/api/trip/perhap/search',{
                    'word':this.searchPerhap,
                    'filter':{
                        'tripID': this.editedItem.tripID,
                        'ticketID': 0
                    }
                }).then(response=>{
                    switch(response.data.status)
                    {
                        case 200:
                            this.data.perhaps=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.perhap = false;
                });
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
            textClientsSelect: item => item.name + ' — '+item.lastname,
            filterSearch()
            {
                console.log(this.filter);
            },
            changeRoute(val)
            {
                this.data.route=this.data.routes.find(x=>x.id===val);
                axios.post('/api/routes/perhaps',{route:this.data.routes.find(x=>x.id===val).route,ticket:0}).then((response) => {
                    this.data.perhaps=response.data.value
                });
                axios.post('/api/trip/search',{route:this.data.routes.find(x=>x.id===val).route,timeActive:1}).then((response) => {
                    this.data.trip=response.data.value
                    this.$forceUpdate()
                });
            },
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
                axios.post('/api/ticket/data').then((response) => {
                    this.data = response.data.value
                    this.dataReady = 1
                });
                /*axios.post('/api/city/search').then((response) => {
                    this.data.cityFrom = response.data.value
                    this.data.cityTo = response.data.value
                    this.dataReady = 1
                });*/
            },
            getData()
            {
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/ticket/search',{
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
                console.log(111);
                this.dialog = true;
            },

            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити цей квиток ?') && axios
                    .delete('/api/ticket/'+item.id+'/delete').then((response)=> {
                    switch (response.data.status) {
                        case 200:
                            this.tableData.splice(index, 1);
                          break;
                        default: alert(response.data.value)
                    }
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
                    axios.put('/api/ticket/'+this.editedItem.id+'/edit',this.editedItem).then((response)=>
                    {
                        console.log(response.data)
                        switch (response.data.status) {
                            case 200:
                                this.getData();
                                this.close();
                              break;
                            default:
                                alert(response.data.value)
                        }
                    });
                } else {
                    axios.post('/api/ticket/add',this.editedItem).then((response)=>
                    {
                        console.log(response.data);
                        switch(response.data.status){
                            case 200:
                                this.getData();
                                this.close();
                             break;
                            default:
                                alert(response.data.value)
                        }
                    });
                }
            },
        },
    };
</script>
