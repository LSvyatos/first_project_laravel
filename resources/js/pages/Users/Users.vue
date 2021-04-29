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
                    v-model="dataFilter.role"
                    :items="data.roles"
                    label="Роль"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs6>
            <v-autocomplete
                    v-model="dataFilter.city"
                    :items="data.city"
                    :search-input.sync="searchCityFilter"
                    label="Місто"
                    no-filter
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-autocomplete>
        </v-flex>
        </v-layout>
        </template>
        <v-toolbar dark flat color="blue darken-3">
            <v-toolbar-title>Користувачі</v-toolbar-title>
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
                                    <v-text-field v-model="editedItem.surname" label="По батькові"></v-text-field>
                                </v-flex>
                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                                </v-flex>

                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.password" type="password" label="Пароль"></v-text-field>
                                </v-flex>

                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.password_confirmation" type="password" label="Підтвердження пароля"></v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <v-select
                                        v-model="editedItem.role"
                                        :items="data.roles"
                                        label="Роль"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12>
                                    <h5>Адреса</h5>
                                    <v-autocomplete
                                        v-model="editedItem.address"
                                        :items="data.city"
                                        :loading="isLoading.city"
                                        :search-input.sync="searchCity"
                                        label="Місто"
                                        no-filter
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
                    v-if="'email' in props.item"
                >{{ props.item.email }}</td>
                <td
                    v-if="'name' in props.item"
                >{{ props.item.name }}</td>
                <td
                    v-if="'lastname' in props.item"
                >{{ props.item.lastname }}</td>
                <td
                    v-if="'surname' in props.item"
                >{{ props.item.surname }}</td>
                <td
                    v-if="'role' in props.item"
                >{{ data.roles.find(x=>x.id===props.item.role).name }}</td>
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
    data: () => ({
      dialog: false,
      search: '',
      searchCity: '',
      searchCityFilter: '',
      loading: false,
      dataFilter:{},
      showFilter: false,
      rowsPerPageItems: [5, 10, 20, 50, 100],
      total: 0,
      phone: '',
      pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
      isLoading:{
          city: false
      },
      headers: [
        {text: 'ID', value: 'id', show:true, hidden:true},
        {text: 'Email', value: 'email', show:true},
        {text: 'Ім\'я', value: 'name', show:true},
        {text: 'Прізвище', value: 'lastname', show:true},
        {text: 'По батькові', value: 'surname', show:true},
        {text: 'Роль', value: 'role', show:true},
        {text: 'Телефони', value: 'phones', show: true},
        {text: 'Дія', value: 'action', show:true, hidden:true, sortable: false},
      ],
      selectedHeaders: [],
      dataFilter:{},
      data: {
          city: [],
      },
      phoneItem: 0,
      readyData: 0,
      tableData: [],
      editedIndex: -1,
      editedItem: {},
      deletePhones:[],
      defaultItem: {
        name: '',
        lastname: '',
        surname: '',
        email: '',
        password: '',
        password_confirmation: '',
        phones:[],
        role: 0
      },

    }),

    computed: {
      formTitle() {
        return this.editedIndex === -1 ? 'Добавити користувача' : 'Редагувати користувача';
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
        searchCityFilter(value)
        {
            if(!value && value!='')
            {
                return;
            }
            this.isLoading.city = true;
            axios.post('/api/city/search',{
                 'word':this.searchCityFilter
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
      getData()
      {
        this.loading = true;
        const direction = this.pagination.descending ? 'desc' : 'asc';
        axios.post('/api/users/search',{
            'word':this.search,
            'page':this.pagination.page,
            'numberPage':this.pagination.rowsPerPage,
            'filter':this.dataFilter,
            'direction':direction,
            'sortBy':this.pagination.sortBy,
            'select':this.headers.map(x=>x.value)
        }).then(response => {
            switch(response.data.status)
            {
                case 200:
                    this.tableData = response.data.value;
                    this.total=response.data.all;
                    break;
                default:
                    alert("Error: "+response.data.value);
            }
        }).finally(this.loading=false);

        //axios.get('/api/roles').then(response=>this.allRoles=response.data.data);
        //axios.get('/api/permissions').then(response=>this.allPermissions=response.data.data);
      },

      editItem(item) {
          this.editedIndex = this.tableData.indexOf(item);
          axios.post('/api/users/'+this.tableData[this.editedIndex].id).then(response=>{
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
                      alert("Error: "+response.data.value);;
              }
          })
      },

      deleteItem(item) {
        const index = this.tableData.indexOf(item);
        confirm('Ви дійсно хочете видалити цього користувача?') && axios
            .delete('/api/users/'+item.id+'/delete').then((response)=> {
            switch(response.data.status)
            {
                case 200:
                    this.tableData.splice(index, 1);
                    break;
                default:
                    alert("Error: "+response.data.value);
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
          this.editedItem["deletePhones"]=this.deletePhones;
          axios.put('/api/users/'+this.editedItem.id+'/edit',this.editedItem).then((response)=> {
              switch(response.data.status)
              {
                  case 200:
                      this.getData();
                      this.close();
                      break;
                  default:
                      alert("Error: "+response.data.value);
              }
          });
        } else {

          axios.post('/api/users/add',this.editedItem).then((response)=> {
              switch(response.data.status)
              {
                  case 200:
                      this.getData();
                      this.close();
                      break;
                  default:
                      alert("Error: "+response.data.value);
              }
          });
        }
      },
    },
  };
</script>
