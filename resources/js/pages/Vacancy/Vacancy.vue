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
                    v-model="dataFilter.bonus"
                    :items="data.bonus"
                    label="Бонус"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.food"
                    :items="data.food"
                    label="Харчування"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.house"
                    :items="data.house"
                    label="Проживання"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.changes"
                    :items="data.changes"
                    label="Змінни"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.workSeason"
                    :items="data.season"
                    label="Сезонність"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.skillLanguage"
                    :items="data.skillLanguage"
                    label="Знання мови"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.visa"
                    :items="data.visa"
                    label="Віза"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.urgently"
                    :items="data.urgently"
                    label="Терміновість"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs4>
            <v-select
                    v-model="dataFilter.sex"
                    :items="data.sex"
                    label="Стать"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-select>
        </v-flex>
        <v-flex xs6>
            <v-autocomplete
                    v-model="dataFilter.cityID"
                    :items="data.cityFilter"
                    :loading="isLoading.cityFilter"
                    :search-input.sync="searchCityFilter"
                    dense
                    filled
                    small-chips
                    no-filter
                    label="Місто"
                    item-value="id"
                    item-text="name"
                    clearable
            ></v-autocomplete>
        </v-flex>
        <v-flex xs6>
            <v-autocomplete
                    v-model="dataFilter.categoryID"
                    :items="data.categoryFilter"
                    :loading="isLoading.categoryFilter"
                    :search-input.sync="searchCategoryFilter"
                    label="Категорія"
                    item-value="id"
                    item-text="name"
                    clearable
                    dense
                    filled
                    small-chips
                    
            ></v-autocomplete>
        </v-flex>
        </v-layout>
        </template>
        <v-toolbar dark
                   color="blue darken-3"
                   class="mb-1">
            <v-toolbar-title>Вакансії</v-toolbar-title>
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
                        <v-flex>
                            <span class="headline">{{ formTitle }}</span>
                        </v-flex>
                        <v-flex>
                            <div class="justify-end" v-if="editedItem.author"> Автор: {{ editedItem.author.name }} {{ editedItem.author.lastname }}</div>
                        </v-flex>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>


                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.name" label="Назва"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea v-model="editedItem.description" label="Опис"></v-textarea>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea v-model="editedItem.duties" label="Обов'язки"></v-textarea>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea v-model="editedItem.requirements" label="Вимоги"></v-textarea>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea v-model="editedItem.schedule" label="Графік роботи"></v-textarea>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.minPaymentSuma" label="Мінімальна зарплата" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.maxPaymentSuma" label="Максимальна зарплата" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-select
                                        v-model="editedItem.paymentPeriod"
                                        :items="data.paymentPeriod"
                                        item-value="id"
                                        item-text="name"
                                        label="Тип оплати"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.maxTimeDay" label="Макс. кіл. годин в день" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.maxTimeWeek" label="Макс. кіл. годин в тиждень" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="editedItem.maxTimeMonth" label="Макс. кіл. годин в місяць" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field v-model="editedItem.minYear" label="Мінімальний вік" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-text-field v-model="editedItem.maxYear" label="Максимальний вік" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="editedItem.number" label="Кількість робочих місць" type="number"></v-text-field>
                                </v-flex>
                                <v-flex xs6>
                                    <v-autocomplete
                                        v-model="editedItem.cityID"
                                        :items="data.city"
                                        :loading="isLoading.city"
                                        :search-input.sync="searchCity"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        no-filter
                                        label="Місто"
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs6>
                                    <v-autocomplete
                                        v-model="editedItem.categoryID"
                                        :items="data.category"
                                        label="Категорія"
                                        :loading="isLoading.category"
                                        :search-input.sync="searchCategory"
                                        item-value="id"
                                        item-text="name"
                                        dense
                                        filled
                                        small-chips
                                        chips
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.sex"
                                        :items="data.sex"
                                        label="Стать"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.changes"
                                        :items="data.changes"
                                        label="Зміни"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.visa"
                                        :items="data.visa"
                                        label="Віза"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.urgently"
                                        :items="data.urgently"
                                        label="Терміново"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.workSeason"
                                        :items="data.season"
                                        label="Сезонність"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.food"
                                        :items="data.food"
                                        label="Харчування"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.house"
                                        :items="data.house"
                                        label="Проживання"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.skillLanguage"
                                        :items="data.skillLanguage"
                                        label="Знання мови"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6>
                                    <v-select
                                        v-model="editedItem.bonus"
                                        :items="data.bonus"
                                        label="Бонуси"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="editedItem.employers"
                                        :items="data.employers"
                                        :loading="isLoading.employer"
                                        :search-input.sync="searchEmployer"
                                        label="Роботодавці"
                                        item-value="id"
                                        item-text="name"
                                        chips
                                        hide-no-data 
                                        hide-selected
                                        deletable-chips
                                        multiple
                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex xs12>
                                    <v-textarea
                                        v-model="editedItem.text"
                                        label="Додаток"
                                    ></v-textarea>
                                </v-flex>
                                <v-flex>
                                    <!---<ImageUpload
                                        v-on:showDialogImage="showDialogImage"
                                        :dialog="dialogUploadImage"
                                        :vacancy="editedItem.id"
                                        :addImage="addImage"
                                    >
                                    </ImageUpload>--->
                                    <my-upload field="img"
                                               @crop-success="cropSuccess"
                                               @crop-upload-success="cropUploadSuccess"
                                               @crop-upload-fail="cropUploadFail"
                                               :width="300"
                                               :height="300"
                                               url="/api/images/upload"
                                               lang-type="ua"
                                               v-model="dialogUploadImage"
                                               :params="paramsUploadImage"
                                               :headers="headerUploadImage"
                                               img-format="png">
                                    </my-upload>
                                </v-flex>
                                <v-flex xs12>
                                    <h3>Зображення</h3>
                                    <div class="images" v-viewer="{movable: false}">
                                        <img style="width:100px;height:100px;border-radius:50px;margin: 10px" v-for="src in images.show" :src="src.url" :key="src.id" @click="show">
                                    </div>
                                </v-flex>
                            </v-layout>
                        </v-container>

                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="blue darken-1" flat @click="showDialog">Добавити зображення</v-btn>
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
                    v-if="selectedHeaders.find(x=>x.value=='id').show"
                >{{ props.item.id }}</td>
                <td
                    v-if="'name' in props.item"
                >{{ props.item.name }}</td>
                <td
                    v-if="'description' in props.item"
                >{{ props.item.description }}</td>
                <td
                    v-if="'city' in props.item"
                >{{ props.item.city.name }}</td>
                <td
                    v-if="'category' in props.item"
                >{{ props.item.category.name }}</td>
                <td
                    v-if="'sex' in props.item"
                >{{ data.sex[props.item.sex].name }}</td>
                <td
                    v-if="'minYear' in props.item"
                    class="text-xs-right"
                >{{ props.item.minYear }}</td>
                <td
                    v-if="'maxYear' in props.item"
                    class="text-xs-right"
                >{{ props.item.maxYear }}</td>
                <td
                    v-if="'minPaymentSuma' in props.item"
                    class="text-xs-right"
                >{{ props.item.minPaymentSuma }}</td>
                <td
                    v-if="'maxPaymentSuma' in props.item"
                    class="text-xs-right"
                >{{ props.item.maxPaymentSuma }}</td>
                <td
                    v-if="'urgently' in props.item"
                >{{ data.urgently[props.item.urgently].name }}</td>
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
    import myUpload from 'vue-image-crop-upload'
    import 'viewerjs/dist/viewer.css'

    export default {
        components: {myUpload},
        data: () => ({
            search: '',
            searchCity: '',
            searchCityFilter: '',
            searchCategory: '',
            searchEmployer: null,
            searchCategoryFilter: '',
            isLoading:{
                city: false,
                category: false,
                employer: false
            },
            dialog: false,
            dialogImage: false,
            loading: true,
            showFilter:false,
            dataFilter:{},
            rowsPerPageItems: [5, 10, 20, 50, 100],
            total: 0,
            imgDataUrl: '',
            pagination:{'sortBy': 'id', 'descending': true, 'rowsPerPage': 20},
            paramsUploadImage:{},
            headerUploadImage: {
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            headers:[
                {text: 'ID', value: 'id', show: true, hidden: true},
                {text: 'Назва', value: 'name', show: true},
                {text: 'Опис', value: 'description', show: true},
                {text: 'Місто', value: 'city', show: true},
                {text: 'Категорія', value: 'category', show: true},
                {text: 'Стать', value: 'sex', show: true},
                {text: 'Мін. вік', value: 'minYear', show: true},
                {text: 'Макс. вік', value: 'maxYear', show: true},
                {text: 'Мін. зарп.', value: 'minPaymentSuma', show: true},
                {text: 'Макс. зарп.', value: 'maxPaymentSuma', show: true},
                {text: 'Терміново', value: 'urgently', show: true},
                {text: 'Дія', value: 'action', show: true, hidden: true, sortable: false}
            ],
            selectedHeaders: [],
            check:1,
            sel:[],
            dataReady: 0,
            images: {show: [],new:[],delete:[]},
            tableData: [],
            editedIndex: -1,
            dialogUploadImage: false,
            data: {
              city:[],
              sex: [],
              changes: [],
              visa: [],
              category: [],
              season: [],
              urgently: [],
              paymentPeriod: [],
              house:[],
              food:[]
            },
            defaultItem: {},
            editedItem: {
                name: '',
                description: '',
                duties: '',
                paymentPeriod: 0,
                requirements: '',
                schedule: '',
                sex: 2,
                changes: 1,
                minPaymentSuma: 0,
                maxPaymentSuma: 0,
                minYear: 0,
                maxYear: 0,
                maxTimeDay: 0,
                maxTimeWeek: 0,
                maxTimeMonth: 0,
                city:{id:0},
                category:{id:0},
                visa:0,
                house: 0,
                food: 0,
                bonus: 0,
                listImages: [],
                workSeason: 0,
                experience: 0,
                skillLanguage: 0,
                urgently: 0,
                employers: [],
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити вакансію' : 'Редагувати вакансію';
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
            searchEmployer(value)
            {
                this.isLoading.employer = true;
                axios.post('/api/users/search',{
                    'word':this.searchEmployer,
                    'filter':{
                        'role':2
                    }
                }).then(response=>{
                    switch (response.data.status) {
                        case 200:
                            this.data.employers=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.employer = false
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
                            this.data.cityFilter=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.city = false
                });
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
            searchCategory(value)
            {
                if(!value && value!='')
                {
                    return;
                }
                this.isLoading.CityFrom = true;
                axios.post('/api/vacancy/category/search',{
                    'word':this.searchCategory
                }).then(response=>{
                    switch (response.data.status) {
                        case 200:
                            this.data.category=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.CityFrom = false
                });
            },
            searchCategoryFilter(value)
            {
                if(!value && value!='')
                {
                    return;
                }
                this.isLoading.CityFrom = true;
                axios.post('/api/vacancy/category/search',{
                    'word':this.searchCategoryFilter
                }).then(response=>{
                    switch (response.data.status) {
                        case 200:
                            this.data.categoryFilter=response.data.value
                            break;
                    }
                })
                .finally(()=>{
                    this.isLoading.CityFrom = false
                });
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
    
            showDialog() {
                this.dialogUploadImage=!this.dialogUploadImage
            },
            initialize() {
                axios.post('/api/vacancy/data').then((response)=>{
                    this.data=response.data.value;
                    this.data.cityFilter=this.data.city;
                    this.data.categoryFilter=this.data.category;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            getData() {
                const direction = this.pagination.descending ? 'desc' : 'asc';
                this.loading=true;
                axios.post('/api/vacancy/search',{
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
                }).catch(function (error) {
                    console.log(error);
                }).finally(this.loading=false);
            },
            getImages() {
                axios.post("/api/vacancy/image/"+this.editedItem.id+"/get").then(response=>{
                    if(response.data.status==200 && response.data.number>0)
                    {
                        this.images.show=response.data.value;
                    }
                })
            },
            addImage(image)
            {
                if(this.editedItem.listImage==null)
                {
                    this.editedItem.listImage=[image.id];
                }else{
                    this.editedItem.listImage.push(image.id);
                }
                this.images.show.push(image);
            },

            editItem(item) {
                this.editedIndex = this.tableData.indexOf(item);
                axios.post('/api/vacancy/'+this.tableData[this.editedIndex].id).then(response=>{
                    switch (response.data.status) {
                        case 200:
                            var $this=this;

                            this.editedItem=response.data.value;
                            this.data.city.indexOf(this.editedItem.city) === -1 ? this.data.city.push(this.editedItem.city) : 1;
                            this.data.category.indexOf(this.editedItem.category) === -1 ? this.data.category.push(this.editedItem.category) : 1;

                            $this.editedItem.employers=[];
                            $this.editedItem.a_employers.forEach(function(item)
                            {
                                $this.data.employers.indexOf(item) === -1? $this.data.employers.push(item) : 1;
                                $this.editedItem.employers.push(item.id);
                            })

                            if('images' in response.data.value)
                            {
                                this.images.show=response.data.value.images;
                            }
                            this.dialog=true;
                            break;
                        default:
                            alert("Error: "+response.data.value);
                    }
                })
            },

            deleteItem(item) {
                const index = this.tableData.indexOf(item);
                confirm('Ви дійсно хочете видалити цю вакансію?') && axios
                    .delete('/api/vacancy/'+item.id+'/delete').then((response)=> {
                    switch (response.data.status) {
                        case 200:
                            this.tableData.splice(index, 1);
                            console.log(response.data);
                            break;
                    }
                })

            },

            close() {
                this.dialog=false;
                this.dialogUploadImage=false;
                this.images={show:[],new:[],delete:[]};
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                }, 300);
            },

            save() {
                if (this.editedIndex > -1) {
                    Object.assign(this.tableData[this.editedIndex], this.editedItem);
                    axios.put('/api/vacancy/'+this.editedItem.id+"/edit",this.editedItem).then((response)=> {
                        /*if(this.images.new.length>0)
                        {
                            this.saveAddImage();
                        }*/
                        switch(response.data.status)
                        {
                            case 200:
                                this.getData();
                                this.close();
                                break;
                            default: alert("Error: "+response.data.value);    
                        }
                    });
                } else {
                    axios.post('/api/vacancy/add',this.editedItem).then((response)=>
                    {
                     switch(response.data.status) {
                             case 200:
                                 console.log(response.data);
                                 //this.editedItem.id = response.data.value;
                                 //this.tableData.push(this.editedItem);
                                 /*if(this.images.new.length>0)
                                 {
                                     this.saveAddImage();
                                 }*/
                                 this.getData();
                                 this.close();
                                 break;
                             default: alert(response.data.value);
                     }
                    });
                }
            },
            show () {
                const viewer = this.$el.querySelector('.images').$viewer
                viewer.show()
            },

            cropSuccess(imgDataUrl, field) {
                console.log('-------- crop success --------');
                this.imgDataUrl = imgDataUrl;
            },

            cropUploadSuccess(jsonData, field) {
                console.log('-------- upload success --------');
                if(jsonData.status==200) {
                    console.log(11)
                    this.addImage(jsonData.value);
                }
                console.log(22)
                console.log('field: ' + field);
            },

            cropUploadFail(status, field) {
                console.log('-------- upload fail --------');
                console.log(status);
                console.log('field: ' + field);
            },

        },
    };
</script>
<style>
    td {
        max-width: 500px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
