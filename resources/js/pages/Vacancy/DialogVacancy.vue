<template>
    <div>
        <v-dialog max-width="700px" v-model="dialogShow">
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
                            <v-flex xs3>
                                <v-text-field v-model="editedItem.minPaymentSuma" label="Мінімальна зарплата"></v-text-field>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field v-model="editedItem.maxPaymentSuma" label="Максимальна зарплата"></v-text-field>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field v-model="editedItem.minYear" label="Мінімальний вік" type="number"></v-text-field>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field v-model="editedItem.maxYear" label="Максимальний вік"></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field v-model="editedItem.number" label="Кількість робочих місць" type="number"></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-select
                                    v-model="editedItem.city"
                                    :items="data.city"
                                    item-value="id"
                                    item-text="name"
                                    label="Місто"
                                    chips
                                ></v-select>
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
                                    v-model="editedItem.category"
                                    :items="data.category"
                                    label="Категорія"
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
                            <!--<v-flex>
                                <img :src="imgDataUrl">
                            </v-flex>-->
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
    </div>
</template>

<script>
    import myUpload from 'vue-image-crop-upload';
    import ImageUpload from "./ImageUpload";

    export default {
        components: {ImageUpload},
        props: ['editedItem', "data", "close","saveEdit","saveCreate","dialogShow"],
        name: "DialogVacancy",
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Добавити вакансію' : 'Редагувати вакансію';
            },
        },
        data: () => ({
            dialogUploadImage: false,

        }),
        methods: {
            showDialog() {
                this.dialogUploadImage=!this.dialogUploadImage
            },
            save() {

                    if (this.editedIndex > -1) {
                        this.saveCreate();
                    } else {
                        this.saveEdit();
                    }
                }
            }
        }
</script>

<style scoped>

</style>
