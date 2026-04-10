<template>
    <div>
        <AppLayout>
            <template #nav>
                <NavBar/>
            </template>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tires
                </h2>
            </template>
            <template #section>
                <div >
                    <Listbox :options="listboxItems" 
                        filter 
                        v-model="selectedItem" 
                        optionLabel="name"  listStyle="height:250px;max-height:42rem;min-height:42rem;"
                        @update:modelValue="listBoxItemChange"
                    />
                </div>
            </template>
            <template #main>  
             
                <DataTable :data="data" :cols="cols" :loading="loading" @create="create" @edit="edit"  />
            </template>

            <template #dialog>
               
                <Dialog v-model:visible="isVisible" modal header="Tire Information" :style="{ width: '58rem',}">
                    <AppForm 
                        :vehicleTypes="props.vehicleTypes"

                        :locations="props.locations"    
                        :tireTypes="props.tireTypes"
                        :tireStatus="props.tireStatus"
                        :tireBrands="props.tireBrands"
                        :selectedTire="selectedTire"
                     
                        @save="save"
                    />  
                    <ConfirmDialog></ConfirmDialog>
                    <Toast></Toast>
                </Dialog>
               
            </template>

            <template #footer>
                <p>
                  
                </p>
            </template>
        </AppLayout>

    </div>
</template>

<script setup>
import {ref, onMounted, computed} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import NavBar from "@/Pages/Navigation/NavBar.vue";
import DataTable from "@/Layouts/DataTableTemplate.vue";
import AppForm from "@/Pages/MyApp/MasterFiles/Tires/AppForm.vue";
import { router } from '@inertiajs/vue3';
import { postFN } from '@/api/transmit.js';

import { useConfirm } from 'primevue';
import { useToast } from "primevue/usetoast";
import { App } from "@inertiajs/vue3";

const confirmDialog = useConfirm();
const toast = useToast();

const isVisible = ref(false);
const selectedTire = ref(null);

const showDialog = () => {
    isVisible.value = true;
}

const edit = (data) => {
    
    selectedTire.value = data;
    showDialog();
};


const create = () => {
    selectedTire.value = {
        id : null,
        locations_id : null,
        branding_no : null,
        tire_brand_id : null,
        purchase_date : null,
        tire_type_id : null,
        tire_size : null,
        vehicle_type_id : null,
        tire_status_id : 1,
        remarks : null,
    };

    showDialog();
};

onMounted(() => {
    listboxItems.value.push(...props.vehicleTypes);
  
});

// const data = computed (()=>props.tires);

const data = computed(() => {
    return props.tires.map(item => ({
        ...item,

        location_name: item.location?.location_altername,
        brand_name: item.brand?.brand_name,
        tire_type_name: item.tire_type?.type_desc,
        vehicle_type_name: item.vehicle_type?.veh_description,
        tire_status_name: item.tire_status?.status_desc,
    }));
});

const cols = ref([
    { field: 'branding_no', header: 'Branding No.' },

    { field: 'location_name', header: 'Location' },
    { field: 'brand_name', header: 'Brand' },
    { field: 'tire_size', header: 'Tire Size' },
    { field: 'tire_type_name', header: 'Tire Type' },
    { field: 'vehicle_type_name', header: 'Vehicle Type' },
    { field: 'purchase_date', header: 'Purchase Date', type:'date' },
    { field: 'tire_status_name', header: 'Tire Status' },
    { 
        field : 'actions',
        header : 'Actions',
        type : 'actions',
        buttons : ['edit']
    }
]);

const selectedItem = ref(null);
const listboxItems = ref([{value : 0, name : 'All'}]);

const save = async (formData) => {
    confirmDialog.require({
        message: 'Are you sure you want to proceed?',
        header: 'Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Save'
        },
        accept: async () => {

            let mode = formData.id === null ? 'create' : 'update';
           
            await postFN(`/master-files/tires/${mode}`, formData)
            .then(response => {
                toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
                // isVisible.value = false;

                router.reload({
                    only: ['tires'],
                    preserveScroll: true,
                    preserveState: true
                });

                return response;

            })
            .catch(error => {
                let message = '';

                if (error.response) {

                    // ⭐ HANDLE 401
                    if (error.response.status === 401) {
                        toast.add({
                            severity: 'warn',
                            summary: 'Unauthorized',
                            detail: 'Your session has expired. Please login again.',
                            life: 4000
                        });

                        // Optional: redirect to login
                      
                        return;
                    }

                    if (error.response.status === 422) {
                        Object.keys(error.response.data.errors).forEach(field => {
                            error.response.data.errors[field].forEach(msg => {
                                message += `${msg}\n`;
                            });
                        });
                    } else {
                     
                        message = error.response.data.message || 'An error occurred';
                    }

                } else {
                
                    message = 'Network error. Please check your connection.';
                }

                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: message,
                    life: 3000
                });
            });

            // toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}

const props = defineProps([
    'vehicleTypes',
    'tires',

    'locations',
    'tireTypes',
    'tireStatus',
    'tireBrands'
]);

</script>

<style scoped>

</style>