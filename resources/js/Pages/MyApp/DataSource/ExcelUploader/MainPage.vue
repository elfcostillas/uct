<template>
    <div>
       <AppLayout>
            <template #nav>
                <NavBar/>
            </template>

            <template #main>
                <FileUpload  
                    name="file"
                    ref="fileupload" 
                   
                    accept=".csv"
                    chooseLabel="Browse"
                    :customUpload="true"
                    :maxFileSize="100000000"
                    @uploader="onUpload"
                    :loading="loading"
                    @upload="onSuccess"
                    @error="onError"   
                >
                    <template #content="{ files }">
                        <div v-for="file in files" :key="file.name">
                            <span>{{ file.name }}</span>
                        </div>
                    </template>
                </FileUpload>
                <div v-if="loading" class="overlay">
                    <ProgressSpinner />
                </div>
            </template>
       </AppLayout>
    </div> 
</template>

<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import NavBar from '@/Pages/Navigation/NavBar.vue';
import { postFN } from '@/api/transmit.js';
import { ref } from 'vue';
//  url='/api/data-source/excel-uploader/upload'

// const objectURL = URL.createObjectURL(file);

const getPreview = (file) => {
    return URL.createObjectURL(file);
};

const loading=ref(false);

const fileupload = ref(null);


const onUpload = async (event) => {
    loading.value=true;

    const formData = new FormData()


    event.files.forEach((file) => {
        formData.append('files', file)
    });

    const response = await axios.post('/api/data-source/excel-uploader/upload', formData);

    fileupload.value.clear();
    loading.value=false;

}


// const onSuccess = () => {
//     console.log('fired success')
//     fileUpload.value.removeUploadedFile();
// };

// const onError = () => {
//     console.log('fired error')
//     fileUpload.value.removeUploadedFile();
// };

// const onUpload = async (event) => {
//     try {
//         const formData = new FormData();

//         event.files.forEach(file => {
//             formData.append('file', file);
//         });

//         const res = await fetch('/api/data-source/excel-uploader/upload', {
//             method: 'POST',
//             body: formData
//         });

//         const data = await res.json();

//         // ✅ THIS is your "onSuccess"
//         console.log('success', data);

//         fileupload.value.clear();

//     } catch (err) {
//         // ✅ THIS is your "onError"
//         console.error('error', err);
//     }
// };

</script>

<style lang="css" scoped>
    * {
        font-size: 10pt;
    }
</style>