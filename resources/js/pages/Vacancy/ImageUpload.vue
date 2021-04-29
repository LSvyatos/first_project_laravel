<template>
    <div>
        <my-upload @input="updateValue"
                   field="img"
                   @crop-success="cropSuccess"
                   @crop-upload-success="cropUploadSuccess"
                   @crop-upload-fail="cropUploadFail"
                   :width="300"
                   :height="300"
                   url="/api/images/upload"
                   lang-type="ua"
                   v-model="dialog"
                   :params="params"
                   :headers="headers"
                   img-format="png">
        </my-upload>
    </div>
</template>

<script>
    import myUpload from 'vue-image-crop-upload';

    export default {
        props: ["dialog","vacancy","addImage","showDialogImage"],
        name: "ImageUpload",
        data: ()=>({
            params: {},
            headers: {
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            imgDataUrl: '',
        }),
        components: {
            'my-upload': myUpload
        },
        methods: {
            updateValue(value) {
                console.log(3);
            },
            /**
             * crop success
             *
             * [param] imgDataUrl
             * [param] field
             */
            cropSuccess(imgDataUrl, field) {
                console.log('-------- crop success --------');
                this.imgDataUrl = imgDataUrl;
            },
            /**
             * upload success
             *
             * [param] jsonData  server api return data, already json encode
             * [param] field
             */
            cropUploadSuccess(jsonData, field) {
                console.log('-------- upload success --------');
                if(jsonData.status==200) {
                    this.addImage(jsonData.value);
                }
                console.log('field: ' + field);
            },
            /**
             * upload fail
             *
             * [param] status    server api return error status, like 500
             * [param] field
             */
            cropUploadFail(status, field) {
                console.log('-------- upload fail --------');
                console.log(status);
                console.log('field: ' + field);
            },
        }
    }
</script>

<style scoped>

</style>
