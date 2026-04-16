<template>
    <div>
       <AppLayout>
            <template #nav>
                <NavBar/>
            </template>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800" >
                    Invoice - Upload
                </h2>
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

    const response = await axios.post('/api/data-source/excel-uploader/invoice-upload', formData);

    fileupload.value.clear();
    loading.value=false;

}

</script>

<style lang="css" scoped>

</style>