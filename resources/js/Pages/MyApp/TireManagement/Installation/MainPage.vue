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
                    Tire Installation and Replacement
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
                <DataTable 
                    :data="data" 
                    :cols="cols" 
                    :loading="loading" 
                    @create="create" 
                    @edit="edit"
                />  
            </template>

            <template #dialog>
                <Dialog v-model:visible="isVisible" modal header="Tire Installation and Replacement" :style="{ width: '68rem',}">
                    <component 
                        :is="selectedWheelCount" 
                        @save="save" 
                        :selectedVehicle="selectedVehicle" 
                        :vehicles="props.vehicles"
                        :availableTires="availableTires"
                    > </component>
                </Dialog>
                <ConfirmDialog></ConfirmDialog>
                <Toast></Toast>
            </template>

            <template #footer>
              
            </template>
        </AppLayout>  
    </div>
</template>

<script setup>
    import {ref, onMounted, computed} from "vue";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import NavBar from "@/Pages/Navigation/NavBar.vue";
    import DataTable from "@/Layouts/DataTableTemplate.vue";
    // import AppForm from "@/Pages/MyApp/TireManagement/Installation/AppForm.vue";
    import { router } from '@inertiajs/vue3';
    import { postFN } from '@/api/transmit.js';

    import { useConfirm } from 'primevue';
    import { useToast } from "primevue/usetoast";

    import TwoWheeler from "./TwoWheeler.vue";
    import FourWheeler from "./FourWheeler.vue";
    import TenWheeler from "./TenWheeler.vue";
    
    import useConfirmSave from '@/composables/useConfirmSave.js';
    const { confirmAndSave } = useConfirmSave();


    const confirmDialog = useConfirm();
    const toast = useToast();

    const listboxItems = ref([{value : 0, name : 'All'}]);
    const selectedItem = ref(null);
    const selectedVehicle = ref(null);

    const isVisible = ref(false);
    
    const formComponent = {
        1 : TwoWheeler,
        2 : FourWheeler,
        3 : FourWheeler,
        4 : FourWheeler,
        5 : TenWheeler,
    };

    const selectedWheelCount = computed(() => {
        // console.log(selectedVehicle.value.vehicle.tire_count_id);
        return formComponent[selectedVehicle.value.vehicle?.tire_count_id] || null;
    });

    const data = computed (()=> {
        return props.vehicles.map(item => ({
            ...item,
            vehicle_type_name : item.vehicle.vehicle_type ? item.vehicle.vehicle_type.veh_description : '',
            manufacturer: item.vehicle.manufacturer ? item.vehicle.manufacturer.name : '',
            veh_code: item.vehicle ? item.vehicle.veh_code : '',
            plate_no: item.vehicle ? item.vehicle.plate_no : '',
            model: item.vehicle ? item.vehicle.model : '',
        }));
    });

    const listBoxItemChange = (item) => {
        if(item != null)
        {
            router.get(route('installation.index'), {
                search: item.value
            }, {
                only: ['vehicles'],
                preserveScroll: true,
                preserveState: true
            })
        }
    }

    const create = () => {
        selectedVehicle.value = null;
        toast.add({severity:'warn', summary:'Invalid Action', detail:'Create function is unavailable.', life: 3000});
        // isVisible.value = true;
    };

    const edit = (data) => {
        console.log(data);

        router.get(route('installation.index'), {
            vehicle_id: data.vehicle_id,
            veh_type : data.vehicle?.veh_type

        }, {
            only: ['availableTires'],
            preserveScroll: true,
            preserveState: true
        });

        selectedVehicle.value = data;
        isVisible.value = true;
    };

    onMounted(() => {
        listboxItems.value.push(...props.vehicleTypes);
    });

   
    const save = async (formData) => {
        // console.log(formData);
        confirmAndSave({
            data : formData,
            url: `/tire-management/positions/update`,
            onSuccess: () => {
                router.reload({
                    only: ['vehicles'],
                    preserveScroll: true,
                    preserveState: true
                });
            },
        });
    }

    const props = defineProps([
        'vehicleTypes',
        'vehicles',
        'availableTires'
        // manufacturers: Array,
        // employees: Array,
      

        // suppliers: Array,
        // tireCounts: Array
    ]);

    const cols = ref([
        { field: 'id', header: 'ID' },
        { field: 'veh_code', header: 'Vehicle Code' },
        { field: 'vehicle_type_name', header: 'Vehicle Type' },
        { field: 'plate_no', header: 'Plate Number' },
        { field: 'manufacturer', header: 'Manufacturer' },
        { field: 'model', header: 'Model' },
      
        { 
            field: 'actions', 
            header: 'Actions',
            type:'actions', 
            buttons:['edit'] 
        }
    ]);
</script>

<style lang="scss" scoped>

</style>