<template>
    <div>
        <template>
        <v-layout 
           row 
           wrap
        >
        <v-flex xs5>
        <v-select     
                      v-model="dataFilter.tripID"
                      :items="data.trip"
                      item-value="id"
                      :item-text="item=>item.route.name+' '+item.timeFrom"
                      label="Рейс"
                      clearable
                      hide-details
                      hide-selected
                      chips
                      
                      >
            </v-select>
        </v-flex>
        <v-flex xs2 justify-center>
            <v-btn slot="activator" color="red" dark class="mb-2" @click="print">Друк</v-btn>
        </v-flex>
        <v-flex xs5>
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
        </v-flex>
        </v-layout>
        
        </template>
        <div id="dataList">
        <v-container fill-height>
         <v-row justify="center" align="center">
         <v-col cols="12" sm="4" v-if="this.trip!=null">
            <h2>{{this.trip.route.name}}</h2>
            <h3>Дата: {{this.trip.trip.timeFrom}}</h3>
            <h4>Всього: {{this.trip.all}}</h4>
         </v-col>
         
         </v-row>
        </v-container>
        <v-data-table
        v-if="this.dataFilter['tripID']!=undefined"
            v-model="selected"
            :single-select="singleSelect"
            :headers="selectedHeaders.filter(x=>x.show)"
            :items="tableData"
            disable-initial-sort
            hide-actions
            disable-sort
            disable-pagination
            hide-default-footer
        >
        <template v-slot:headers="props">
        <tr>
          <th v-for="header in props.headers" :key="header.text">
            {{ header.text }}
          </th>
        </tr>
        </template>
            <template
                   slot="items"
                   slot-scope="props"
            >
            <tr>
                <td
                  class="justify-center"
                  >{{ props.item.id }}</td>
                <td
                   class="justify-center"
                >
                    <div v-for="user in props.item.drivers">{{ user.name+'\n'+user.lastname }}</div>
                </td>
                <td
                   class="justify-center"
                   v-if="'perhap' in props.item"
                >{{ props.item.perhap.perhap }}</td>
                <td
                   class="justify-center"
                   v-if="'transport' in props.item"
                >{{ props.item.transport.name }}</td>
                <td
                   class="justify-center"
                   v-if="'clientText' in props.item"
                >{{ props.item.clientText }}</td>
                <td
                   class="justify-center"
                   v-if="'from' in props.item"
                >{{ props.item.from.name }}</td>
                <td
                   class="justify-center"
                   v-if="'to' in props.item"
                >{{ props.item.to.name }}</td>
                <td
                   class="justify-center"
                   v-if="'price' in props.item"
                >{{ props.item.price }}</td>
                <td
                   v-if="'currency' in props.item"
                >{{ props.item.currency.value }}</td>
                <td
                   class="justify-center"
                   v-if="'type_payment' in props.item"
                >{{ props.item.type_payment.value }}</td>
                <td
                   class="justify-center"
                   v-if="'timeFrom' in props.item"
                >{{ props.item.timeFrom }}</td>
                <td>{{ props.item.created_at }}</td>
                
                </tr>
            </template>
            
        </v-data-table>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            search:'',
            trip: null,
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
                {text: 'ID', value: 'id', show:true, hidden:true, align:'center'},
                {text: 'Водії', value: 'drivers', show:true, align:'center'},
                {text: 'Місце', value: 'perhap', show:true, align:'center'},
                {text: 'Транспорт', value: 'transport', show:true, align:'center'},
                {text: 'Клієнт', value: 'clientText', show:true, align:'center'},
                {text: 'Звідки', value: 'from', show:true, align:'center'},
                {text: 'Куди', value: 'to', show:true, align:'center'},
                {text: 'Ціна', value: 'price', show:true, align:'center'},
                {text: 'Валюта', value: 'currency', show:true, align:'center'},
                {text: 'Спосіб оплати', value: 'typePayment', show:true, align:'end'},
                {text: 'Дата', value: 'timeFrom', show:true, align:'end'},
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
            
            dataFilter:{
                handler()
                {
                    this.getData();
                },
                deep: true
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
            
            initialize() {
                axios.post('/api/ticket/data').then((response) => {
                    switch(response.data.status)
                    {
                        case 200:
                            this.data = response.data.value;
                            this.dataReady = 1;
                            break;
                        default:alert(response.data.value);    
                    }
                });
                /*axios.post('/api/city/search').then((response) => {
                    this.data.cityFrom = response.data.value
                    this.data.cityTo = response.data.value
                    this.dataReady = 1
                });*/
            },
            getData()
            {
                if(this.dataFilter["tripID"]==undefined)
                {
                    return
                }
                this.loading = true;
                const direction = this.pagination.descending ? 'desc' : 'asc';
                axios.post('/api/ticket/report',{
                    'filter':this.dataFilter,
                    'direction':direction,
                    'sortBy':this.pagination.sortBy,
                    'select':this.headers.map(x=>x.value)
                }).then((response) => {
                    switch (response.data.status) {
                        case 200:
                            this.trip=response.data.data;
                            this.tableData = response.data.value;
                            this.total=response.data.all;
                            break;
                    }
                    this.loading=false;
                }).finally(this.loading=false);
            },
            print () {
                this.$htmlToPaper('dataList');
                }
        },
    };
</script>
<style>
.v-data-table-header th {
  text-transform: uppercase;
  color:red;
}
</style>