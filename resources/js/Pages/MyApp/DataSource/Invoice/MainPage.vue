<template>
    <div>
       <AppLayout>
            <template #nav>
                <NavBar/>
            </template>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800" >
                    Invoice - List
                </h2>
            </template>
            <template #main>
            
                    <DataTable 
                    :data="props.invoices" 
                    :cols="cols" 
                    :loading="loading"
                    @print="print"
                    />
           
            </template>
       </AppLayout>
    </div> 
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayoutNoSide.vue';
import NavBar from '@/Pages/Navigation/NavBar.vue';
import DataTable from "@/Layouts/DataTableTemplate.vue";

import { postFN } from '@/api/transmit.js';
import { ref } from 'vue';

const print = (invoice) => {
    let url = `/api/data-source/invoices/print/${invoice.invoice_no}`;
    window.open(url);
};

const cols = ref([
    { field : 'ship_date', header : 'Ship Date', type : 'date' },
    { field : 'invoice_no', header : 'Ivoice No' },
    { field : 'customer', header : 'Customer' },
    { 
        field : 'actions',
        header : 'Actions',
        type : 'actions',
        buttons : ['print']
    }
]);

const props = defineProps([
    'invoices'
]);


</script>

<style lang="css" scoped>

</style>