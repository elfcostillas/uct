<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import NavBar from '../../../Navigation/NavBar.vue';
import { router } from '@inertiajs/vue3';

import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from './DataTable.vue';

import { computed, onMounted, ref } from 'vue';
import DataTableVue from './DataTable.vue';
import AppForm from './AppForm.vue';

import { postFN } from '@/api/transmit.js';
import { useConfirm } from 'primevue';
import { useToast } from "primevue/usetoast";

import useConfirmSave from '@/composables/useConfirmSave.js';
const { confirmAndSave } = useConfirmSave();

const selectedItem = ref(null);
const listboxItems = ref([{value : 0, name : 'All'}]);

const selectedVehicle = ref(null);

const params = new URLSearchParams(window.location.search);

// const data = computed (()=>props.vehicles);
const data = computed (()=> {
    return props.vehicles.map(item => ({
        ...item,
        vehicle_type_name : item.vehicle_type ? item.vehicle_type.veh_description : '',
        manufacturer: item.manufacturer ? item.manufacturer.name : '',
        assigned_employee : item.assigned_employee ? item.assigned_employee.employee_name : '',
    }));
});

const confirmDialog = useConfirm();
const toast = useToast();

const statuses = ref([
    { value : 'active', name : 'Active'},
    { value : 'inactive', name : 'Inactive'},
]);

const props = defineProps([
    'vehicleTypes',
    'manufacturers',
    'employees',
    'vehicles',
    'suppliers',
    'tireCounts',
    'locations',
]);

onMounted(() => {
    listboxItems.value.push(...props.vehicleTypes);

    if(params.get('search'))
    {
        selectedItem.value = listboxItems.value.find(item => item.value == params.get('search'));
    }
});

const listBoxItemChange = (item) => {
    if(item != null)
    {
        router.get(route('vehicle.index'), {
            search: item.value
        }, {
            only: ['vehicles'],
            preserveScroll: true,
            preserveState: true
        })
    }
}

const showDialog = () => {
    isVisible.value = true;
}

const loading = ref(false);

const cols = ref([
    { field: 'id', header: 'ID' },
    { field: 'veh_code', header: 'Code' },
    // { field: 'manufacturer_name', header: 'Manufacturer' },
    { field: 'manufacturer', header: 'Manufacturer' },
    { field: 'model', header: 'Model' },
    { field: 'manufacture_year', header: 'Year' },
    { field: 'plate_no', header: 'Plate No.' },
    { field: 'assigned_employee', header: 'Assigned To' },
    { 
        field : 'actions',
        header : 'Actions',
        type : 'actions',
        buttons : ['edit']
    }
]);

const isVisible = ref(false);

const edit = (data) => {
    // console.log(data);
    selectedVehicle.value = data;
    showDialog();
};

const create = () => {
   

    selectedVehicle.value = {
        id : null,
        veh_type : null,
        veh_code : null,
        manufacturer_id : null,
        model : null,
        manufacture_year : null,
        plate_no : null,
        veh_identification_no : null,
        veh_color : null,
        supplier_id : null,
        purchase_date : null,
        assigned_to : null,
        veh_status : 'active',
        veh_remarks : null,
        tire_count_id : null,
        location_id : null,
        mixer_drum_no : null,
        engine_no : null
    };
    
    showDialog();

}

const save = async (formData) => {
    confirmAndSave({
        data : formData,
        url: `/master-files/vehicles/${formData.id ? 'update' : 'create'}`,
        onSuccess: () => {
            router.reload({
                only: ['vehicles'],
                preserveScroll: true,
                preserveState: true
            });
        },
        
    });
}

/*
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
           
            await postFN(`/master-files/vehicles/${mode}`, formData)
            .then(response => {
                toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
                // isVisible.value = false;

                router.reload({
                    only: ['vehicles'],
                    preserveScroll: true,
                    preserveState: true
                });

                return response;

            })
            .catch(error => {
                let message = '';

                console.log(error.response.data.errors);

                Object.keys(error.response.data.errors).forEach(field => {
                    error.response.data.errors[field].forEach(msg => {
                        message += `${msg}\n`;
                    })
                });

                toast.add({ severity: 'error', summary: 'Error', detail: message || 'An error occurred', life: 3000 });
            });

            // toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });


}
*/

</script>

<template>
    <div>
        <AppLayout>
            <template #nav>
                <NavBar/>
            </template>
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Vehicles
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
                <DataTable :data="data" :cols="cols" :loading="loading" @create="create" @edit="edit"> </DataTable>  
                 
            </template>
            <template #footer>
                <p>
                  
                </p>
            </template>

            <template #dialog>
                <Dialog v-model:visible="isVisible" modal header="Vehicle Information" :style="{ width: '62rem',}">
                    <AppForm 
                        :vehicleTypes="props.vehicleTypes"
                        :manufacturers="props.manufacturers"
                        :employees="props.employees"
                        :vehicles="props.vehicles"
                        :suppliers="props.suppliers"
                        :selectedVehicle="selectedVehicle"
                        :tireCounts="props.tireCounts"
                        :locations="props.locations"

                        @save="save"
                    />  
                    <ConfirmDialog></ConfirmDialog>
                    <Toast></Toast>
                </Dialog>
               
            </template>
        
        </AppLayout>
    </div>
</template>
 <style lang="css">
    * {
        font-size: 11pt;
    }
 </style>