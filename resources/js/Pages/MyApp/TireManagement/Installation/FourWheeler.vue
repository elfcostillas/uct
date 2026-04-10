<template>
    <div>
        <Fieldset legend="4 Wheeler Vehicle">
            <div class="grid grid-cols-3 gap-4 m-2">
                <div>
                    <label> Vehicle Code</label>
                    <Select v-model="form.vehicle_id" disabled :options="vehicleOptions" optionLabel="veh_code" optionValue="veh_id" id="vehicle_id" class="w-full " />  
                
                </div>
                <div>
                    <label> Odometer Reading</label>
                    <InputNumber v-model="form.odometer_reading" id="odometer_reading" :min=0 :max=999999 :useGrouping="false" class="w-full " />  
                </div>
                <div>
                    <label> Hour Meter Reading</label>
                    <InputNumber v-model="form.hour_meter_reading" id="hour_meter_reading" :min=0 :max=999999 :useGrouping="false" class="w-full " />  
                </div>
                <div>
                    <Image src="/images/tire.jpg" alt="Front Left" width="40" /> 
                    <label for="front_left_wheel_id" class="block text-gray-700 whitespace-nowrap">Front Left</label>
                    <Select v-model="form.front_left_wheel_id" :invalid="isDuplicateWheel(form.front_left_wheel_id)" id="front_left_wheel_id" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" class=" w-full" />
                </div>
                <div class="row-span-3 grow-2 flex justify-center">
                    <Image src="/images/4.jpg" alt="Vehicle" width="200" />  
                </div>
                <div >
                    <label for="front_right_wheel_id" class="block text-gray-700"><Image src="/images/tire.jpg" alt="Front Right" width="40" /> Front Right</label>
                    <Select v-model="form.front_right_wheel_id" :invalid="isDuplicateWheel(form.front_right_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id"  id="front_right_wheel_id" class=" w-full" />
                </div>
                <div></div>
                <div></div>
                
                <div>
                    <label for="rear_left_wheel_id" class="block text-gray-700"><Image src="/images/tire.jpg" alt="Front Right" width="40" />Rear Left</label>
                    <Select v-model="form.rear_left_wheel_id" :invalid="isDuplicateWheel(form.rear_left_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id"  id="rear_left_wheel_id" class=" w-full" />
                </div>
                
                <div>
                    <label for="rear_right_wheel_id" class="block text-gray-700"><Image src="/images/tire.jpg" alt="Front Right" width="40" />Rear Right</label>
                    <Select v-model="form.rear_right_wheel_id" :invalid="isDuplicateWheel(form.rear_right_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id"  id="rear_right_wheel_id" class=" w-full" />
                </div>
                
                <div></div>
                <div>
                    <label for="spare_wheel_id" class="block text-gray-700"><Image src="/images/tire.jpg" alt="Front Right" width="40" />Spare</label>
                    <Select v-model="form.spare_wheel_id" :invalid="isDuplicateWheel(form.spare_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id"  id="spare_wheel_id" class=" w-full" />
                    </div>
                <div></div>
          
            </div>
           
        </Fieldset>
        <div class="mt-2">
            <Button
                icon="pi pi-save"
                label="Save"
                @click="save">
                
            </Button>
        </div>
      
    </div>
</template>

<script setup>

import { ref,computed, onMounted } from 'vue';
import { useToast } from "primevue/usetoast";

const toast = useToast();

const props = defineProps([
    'selectedVehicle',
    'vehicles',
    'availableTires'
]);

// const availableTires = ref([ { label : 'No Tire Selected' , value : null } ]);

const availableTiresOptions = computed(() => {
    return [{ branding_no : 'No Tire Selected' , id : null }, ...(props.availableTires || []).map(item => ({
        branding_no: item.branding_no,
        id: item.id
    }))];
});

onMounted(() => {
    // console.log(props.selectedVehicle);
    // availableTires.value = [{ label : 'No Tire Selected' , value : null }, ...props.availableTires.map(item => ({
    //     label: item.branding_no,
    //     value: item.id
    // }))];
});

const vehicleOptions = computed (()=> {
    return props.vehicles.map(item => ({
        ...item,
        veh_id: item.vehicle ? item.vehicle.id : null,
        veh_code: item.vehicle ? item.vehicle.veh_code : '',
        
    }));
});

const form = ref({
    id : props.selectedVehicle?.id || null,
    vehicle_id : props.selectedVehicle.vehicle?.id || null,
    spare_wheel_id : props.selectedVehicle?.spare_wheel_id || null,

    front_left_wheel_id : props.selectedVehicle?.front_left_wheel_id || null,
    front_right_wheel_id : props.selectedVehicle?.front_right_wheel_id || null,

    rear_left_wheel_id : props.selectedVehicle?.rear_left_wheel_id || null,
    rear_right_wheel_id : props.selectedVehicle?.rear_right_wheel_id || null
});

const save = async () => {
  
    if(hasDuplicateWheelIds.value){
        toast.add({severity:'error', summary:'Error', detail:'Duplicate wheel selection is not allowed.', life: 3000});
    
    }else{
        emit('save', form.value);
    }
}

const isDuplicateWheel = (wheelId) => {
    if(!wheelId) return false; // Ignore null or empty values

    const wheelIds = [
        form.value.spare_wheel_id,
        form.value.front_left_wheel_id,
        form.value.front_right_wheel_id,
        form.value.rear_left_wheel_id,
        form.value.rear_right_wheel_id
    ];

    // return wheelIds.includes(wheelId);
    return wheelIds.filter(id => id === wheelId).length > 1;
};

const hasDuplicateWheelIds = computed(() => {
    const wheelIds = [
        form.value.spare_wheel_id,
        form.value.front_left_wheel_id,
        form.value.front_right_wheel_id,
        form.value.rear_left_wheel_id,
        form.value.rear_right_wheel_id
    ].filter(id => id !== null && id !== '');

    // console.log(new Set(wheelIds).size,wheelIds.length);

    return new Set(wheelIds).size !== wheelIds.length;
});

const emit = defineEmits([
    'save'
]);


</script>

<style lang="css" scoped>
 * {
    font-size: 11pt;
 }
</style>