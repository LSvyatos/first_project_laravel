<template>
    <div>
        <template>
        <v-layout 
           v-if="showFilter"
           row 
           wrap
        >
        
        </v-layout>
        </template>
        <v-toolbar color="blue darken-3">
            <v-toolbar-title>Клієнти</v-toolbar-title>
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
                                    <v-text-field v-model="editedItem.lastname" label="Прізвище"></v-text-field>
                                </v-flex>
                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.name" label="Ім'я"></v-text-field>
                                </v-flex>

                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.surname" label="По-батькові"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <h5>Адреса</h5>
                                    <v-autocomplete
                                        v-model="editedItem.address"
                                        :items="data.city"
                                        :loading="isLoading.city"
                                        :search-input.sync="searchCity"
                                        label="Міста"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                        hide-no-data 
                                        hide-selected
                                        deletable-chips
                                        multiple
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex>

                                    <v-card-actions v-for="phone in editedItem.phones" :key="phone.id">
                                        <vue-tel-input
                                            v-model="phone.phone"
                                            mode="international"
                                            :inputOptions="{placeholder:'Введіть номер'}"
                                            @validate="updateNumberInput($event,phone)"
                                            :preferredCountries="['UA','PL','RU']"
                                        >
                                        </vue-tel-input>
                                     <v-btn color="blue darken-1" flat @click="deleteNumberInput(phone)">Видалити поле</v-btn>
                                    </v-card-actions>
                                </v-flex>
                                <v-flex xs12>
                                    <v-btn color="blue darken-1" flat @click="addNumberInput">Добавити поле для телефона</v-btn>
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
            :headers="selectedHeaders.filter(x=>x.show)"
            :items="tableData"
            :total-items="total"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination"
            :loading="loading"
            class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td class="justify-center"
                    v-if="'id' in props.item"
                >{{ props.item.id }}</td>
                <td class="justify-center"
                    v-if="'lastname' in props.item"
                >{{ props.item.lastname }}</td>
                <td class="justify-center"
                    v-if="'name' in props.item"
                >{{ props.item.name }}</td>
                <td class="justify-center"
                    v-if="'surname' in props.item"
                >{{ props.item.surname }}</td>
                <td class="justify-center"
                    v-if="'phones' in props.item"
                >
                    <div v-for="phone in props.item.phones">{{phone.phone}}</div>
                </td>
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

    import VuePhoneNumberInput from 'vue-phone-number-input';
    import 'vue-phone-number-input/dist/vue-phone-number-input.css';
    import 'vue-tel-input/dist/vue-tel-input.css';


    export default {
        components: {
            VuePhoneNumberInput,
        },
        data: () => ({
            search:'',
            searchCity: '',
            dialog: false,
            loading: false,
            isLoading:{

            },
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            phone: '',
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
            headers:[
                {text: 'ID', value: 'id', show: true, hidden:true},
                {text: 'Прізвище', value: 'lastname', show: true},
                {text: 'Ім\'я', value: 'name', show: true},
                {text: 'По-батькові', value: 'surname', show: true},
                {text: 'Телефони', value: 'phones', show: true},
                {text: 'Дії', value: 'action', show: true, hidden:true, sortable: false},
            ],
            selectedHeaders: [],
            dataFilter:{},
            showFilter: false,
            data:{
                city:[]
            },
            phoneItem: 0,
            tableData: [],
            editedIndex: -1,
            deletePhones:[],
            editedItem: {},
            defaultItem: {
                lastname: '',
                name: '',
                surname: '',
                phones:[]
            },

        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити клієнта' : 'Редагувати клієнта';
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
            searchCity(value)
            {
            if(!value && value!='')
            {
                return;
            }
            this.isLoading.city = true;
            axios.post('/api/city/search',{
                 'word':this.searchCity
            }).then(response=>{
                switch (response.data.status) {
                    case 200:
                        this.data.city=response.data.value
                        break;
                    }
            })
            .finally(()=>{
                this.isLoading.city = false
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
                axios.post('/api/users/data').then((response) => {
                    this.data = response.data.value;
                    this.readyData = 1
                    });
            },
            updateNumberInput(data,phone){
                phone["code"] = data.countryCallingCode;
                phone["phoneFormat"] = data.number;
                phone["country"] = data.countryCode;
            },
            addNumberInput()
            {
                this.editedItem.phones.push({phone:''});
            },
            deleteNumberInput(item)
            {
                this.deletePhones.push(item.id);
                const index = this.editedItem.phones.indexOf(item);
                this.editedItem.phones.splice(index, 1);
            },
            getData() {
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/client/search',{
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
                axios.post('/api/client/'+this.tableData[this.editedIndex].id).then(response=>{
                    switch (response.data.status) {
                        case 200:
                            var $this=this;

                            this.editedItem=response.data.value;

                            $this.editedItem.address=[];
                            $this.editedItem.a_address.forEach(function(item)
                            {
                              $this.data.city.indexOf(item) === -1? $this.data.city.push(item) : 1;
                              $this.editedItem.address.push(item.id);
                            })
                            this.dialog=true;
                            break;
                        default:
                            alert(response.data.value);
                    }
                    console.log(response.data.value);
                })
            },
            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити цього клієнта?') && this.tableData.splice(index, 1);
                axios.delete('/api/client/'+item.id+'/delete').then(response=>console.log(response.data))
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
                    this.editedItem["deletePhones"]=this.deletePhones;
                    axios.put('/api/client/'+this.editedItem.id+'/edit',this.editedItem).then((response)=> {
                        switch (response.data.status) {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert(response.data.value)
                        }
                        console.log(response.data)
                    });
                } else {
                    axios.post('/api/client/add',this.editedItem).then((response)=>
                    {
                        switch(response.data.status)
                        {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert(response.data.value)
                        }
                        console.log(response.data);
                    });
                }
            },
        },
    };
</script>
