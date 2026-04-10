<template>
    <div>
       <AppLayout>
            <template #nav>
                <NavBar/>
            </template>

            <template #main>
                <FileUpload  
                    name="file"
                    
                  
                    accept=".csv"
                    chooseLabel="Browse"
                    :customUpload="true"
                    :maxFileSize="100000000"
                    @uploader="onUpload"
                />
            </template>
       </AppLayout>
    </div> 
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import NavBar from '@/Pages/Navigation/NavBar.vue';
import { postFN } from '@/api/transmit.js';
//  url='/api/data-source/excel-uploader/upload'
const onUpload = async (event) => {
    const formData = new FormData()

    event.files.forEach((file) => {
        formData.append('files', file)
    });

    const response = await axios.post('/api/data-source/excel-uploader/upload', formData);

}

</script>

<style lang="css" scoped>
    * {
        font-size: 10pt;
    }
</style>