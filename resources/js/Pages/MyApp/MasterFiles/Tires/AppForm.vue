<template>
    <div>
        <div class="grid grid-cols-4 gap-4 m-2">
            <div>
                <label for="branding_no" class="block text-gray-700">Branding No.</label>
                <InputText v-model="form.branding_no" id="branding_no" class=" w-full" />
            </div>
            <div>
                <label for="locations_id" class="block text-gray-700">Location</label>
                <Select v-model="form.locations_id" :options="props.locations" option-label="location_altername" option-value="id" class="w-full " />
            </div>
             <div>
                <label for="tire_brand_id" class="block text-gray-700">Brand</label>
                <Select v-model="form.tire_brand_id" :options="props.tireBrands" option-label="brand_name" option-value="id" class="w-full " />
            </div>
            <div>
                <label for="purchase_date" class="block text-gray-700">Purchase Date</label>
                <DatePicker v-model="form.purchase_date" showIcon id="purchase_date" class=" w-full" />
            </div>
            <div>
                <label for="vehicle_type_id" class="block text-gray-700">Vehicle Group</label>
                <Select v-model="form.vehicle_type_id" :options="props.vehicleTypes" option-label="name" option-value="value" class="w-full " />
            </div>
            <div>
                <label for="tire_type_id" class="block text-gray-700">Tire Type</label>
                <Select v-model="form.tire_type_id" :options="props.tireTypes" option-label="type_desc" option-value="id" class="w-full " />
            </div>
            <div>
                <label for="tire_size" class="block text-gray-700">Tire Size</label>
                <InputText v-model="form.tire_size" id="tire_size" class=" w-full" />
            </div>
            <div>
                <label for="tire_status_id" class="block text-gray-700">Tire Status</label>
                <Select v-model="form.tire_status_id" :options="props.tireStatus" option-label="status_desc" option-value="id" class="w-full " />
            </div>
            <div class="col-span-4"> 
                <label for="remarks" class="block text-gray-700">Remarks</label>
                <InputText v-model="form.remarks" id="remarks" class=" w-full" />
            </div>
            <div>
                <Button
                    icon="pi pi-save"
                    label="Save"
                    @click="save">
                    
                </Button>
            </div>
        </div>
    </div>

</template>

<script setup>
    import { onMounted, ref } from "vue";
    import { format } from 'date-fns';

    // const selectedTire = ref(null);

    onMounted(() => {
       
        form.value = {
            id : props.selectedTire?.id ?? null,
            locations_id : props.selectedTire?.locations_id ?? null,
            branding_no : props.selectedTire?.branding_no ?? null,        
            tire_brand_id : props.selectedTire?.tire_brand_id ?? null,         
            purchase_date :  props.selectedTire?.purchase_date ? new Date(props.selectedTire.purchase_date) : null,
            tire_type_id : props.selectedTire?.tire_type_id ?? null,       
            tire_size : props.selectedTire?.tire_size ?? null,       
            vehicle_type_id : props.selectedTire?.vehicle_type_id ?? null,       
            tire_status_id : props.selectedTire?.tire_status_id ?? null,       
            remarks : props.selectedTire?.remarks ?? null,             
        };

        console.log(form.value);
    });

    const form = ref({
        id : null,
        locations_id : null,
        branding_no : null,
        tire_brand_id : null,
        purchase_date : null,
        tire_type_id : null,
        tire_size : null,
        vehicle_type_id : null,
        tire_status_id : null,
        remarks : null,
    });

    const props = defineProps([
        'vehicleTypes', 
        'locations',
        'tireTypes',
        'tireStatus',
        'tireBrands',
        'selectedTire'
        // 'manufacturers',    
        // 'employees',
        // 'vehicles',
        // 'suppliers',
        // 'selectedVehicle',
    ]);

    const emit = defineEmits([
        'save'
    ]);

    const save = () => {
        emit('save', form.value);
    }

</script>

<style lang="css" scoped>

</style>