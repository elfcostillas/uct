<template>
    <div>
        <Fieldset legend="10 Wheeler Vehicle">
            <div class="grid grid-cols-5 gap-4 m-2">
               <div>
                    <label> Vehicle Code</label>
                    <Select v-model="form.vehicle_id" disabled :options="vehicleOptions" optionLabel="veh_code" optionValue="veh_id" id="vehicle_id" class="w-full " />  
                
                </div>
                <div class="w-48 min-w-0" >
                    <label> Odometer Reading</label>
                    <InputNumber v-model="form.odometer_reading" id="odometer_reading" :min=0 :max=999999 :useGrouping="false" class="w-full" inputClass="w-full" />  
                </div>
                <div class="w-48 min-w-0" >
                    <label> Hour Meter Reading</label>
                    <InputNumber v-model="form.hour_meter_reading" id="hour_meter_reading" :min=0 :max=999999 :useGrouping="false" class="w-full" inputClass="w-full" />  
                </div>
                <div class="w-48" ></div>
                <div class="w-48" ></div>

                <div></div>
                <div>
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="front_left_wheel_id" class="block text-gray-700 whitespace-nowrap">Front Left </label>
                    <Select v-model="form.front_left_wheel_id" :invalid="isDuplicateWheel(form.front_left_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="front_left_wheel_id" class=" w-full" />
                </div>
                <div class="row-span-4">
                    <Image src="/images/10.jpg" alt="Vehicle" width="150" />  
                </div>
                <div>
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="front_right_wheel_id" class="block text-gray-700 whitespace-nowrap">Front Right </label>
                    <Select v-model="form.front_right_wheel_id" :invalid="isDuplicateWheel(form.front_right_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="front_right_wheel_id" class=" w-full" />
                </div>
                <div></div>

                <div></div>
                <div></div>
                
                <div></div>
                <div></div>

                <div> 
                    <Image src="/images/tire.jpg" alt="Center Left Outer" width="40" /> 
                    <label for="center_left_outer_wheel_id" class="block text-gray-700 whitespace-nowrap">Center Left Outer</label>
                    <Select v-model="form.center_left_outer_wheel_id" :invalid="isDuplicateWheel(form.center_left_outer_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="center_left_outer_wheel_id" class=" w-full" />
                </div>
                <div>
                    <Image src="/images/tire.jpg" alt="Center Left Inner" width="40" /> 
                    <label for="center_left_inner_wheel_id" class="block text-gray-700 whitespace-nowrap">Center Left Inner</label>
                    <Select v-model="form.center_left_inner_wheel_id" :invalid="isDuplicateWheel(form.center_left_inner_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="center_left_inner_wheel_id" class=" w-full" />
                </div>
                
                <div> 
                    <Image src="/images/tire.jpg" alt="Center Right Inner" width="40" /> 
                    <label for="center_right_inner_wheel_id" class="block text-gray-700 whitespace-nowrap">Center Right Inner</label>
                    <Select v-model="form.center_right_inner_wheel_id" :invalid="isDuplicateWheel(form.center_right_inner_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="center_right_inner_wheel_id" class=" w-full" />
                </div>
                <div>
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="center_right_outer_wheel_id" class="block text-gray-700 whitespace-nowrap">Center Right Outer</label>
                    <Select v-model="form.center_right_outer_wheel_id" :invalid="isDuplicateWheel(form.center_right_outer_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="center_right_outer_wheel_id" class=" w-full" />
                </div>

                <div> 
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="rear_left_outer_wheel_id" class="block text-gray-700 whitespace-nowrap">Rear Left Outer </label>
                    <Select v-model="form.rear_left_outer_wheel_id" :invalid="isDuplicateWheel(form.rear_left_outer_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="rear_left_outer_wheel_id" class=" w-full" />
                </div>
                <div>
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="rear_left_inner_wheel_id" class="block text-gray-700 whitespace-nowrap">Rear Left Inner </label>
                    <Select v-model="form.rear_left_inner_wheel_id" :invalid="isDuplicateWheel(form.rear_left_inner_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="rear_left_inner_wheel_id" class=" w-full" />
                </div>
                
                <div>
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="rear_right_inner_wheel_id" class="block text-gray-700 whitespace-nowrap">Rear Right Inner </label>
                    <Select v-model="form.rear_right_inner_wheel_id" :invalid="isDuplicateWheel(form.rear_right_inner_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="rear_right_inner_wheel_id" class=" w-full" />

                </div>
                <div>
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="rear_right_outer_wheel_id" class="block text-gray-700 whitespace-nowrap">Rear Right Outer </label>
                    <Select v-model="form.rear_right_outer_wheel_id" :invalid="isDuplicateWheel(form.rear_right_outer_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="rear_right_outer_wheel_id" class=" w-full" />

                </div>

                <div></div>
                <div></div>
                <div>  
                    <Image src="/images/tire.jpg" alt="Center Right Outer" width="40" /> 
                    <label for="spare_wheel_id" class="block text-gray-700 whitespace-nowrap">Spare </label>
                    <Select v-model="form.spare_wheel_id" :invalid="isDuplicateWheel(form.spare_wheel_id)" :options="availableTiresOptions" optionLabel="branding_no" optionValue="id" id="spare_wheel_id" class=" w-full" /></div>
                <div></div>
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
        <Toast />
    </div>
</template>

<script setup>

import { ref,computed } from 'vue';

const props = defineProps([
    'selectedVehicle',
    'vehicles',
    'availableTires'
]);

const vehicleOptions = computed (()=> {
    return props.vehicles.map(item => ({
        ...item,
        veh_id: item.vehicle ? item.vehicle.id : null,
        veh_code: item.vehicle ? item.vehicle.veh_code : '',
        
    }));
});

const availableTiresOptions = computed(() => {
    return [{ branding_no : 'No Tire Selected' , id : null }, ...(props.availableTires || []).map(item => ({
        branding_no: item.branding_no,
        id: item.id
    }))];
});


const form = ref({
    id : props.selectedVehicle?.id || null,
    vehicle_id : props.selectedVehicle.vehicle?.id || null,
    spare_wheel_id : props.selectedVehicle?.spare_wheel_id || null,

    front_left_wheel_id : props.selectedVehicle?.front_left_wheel_id || null,
    front_right_wheel_id : props.selectedVehicle?.front_right_wheel_id || null,

    center_left_inner_wheel_id : props.selectedVehicle?.center_left_inner_wheel_id || null,
    center_left_outer_wheel_id : props.selectedVehicle?.center_left_outer_wheel_id || null,

    center_right_inner_wheel_id : props.selectedVehicle?.center_right_inner_wheel_id || null,
    center_right_outer_wheel_id : props.selectedVehicle?.center_right_outer_wheel_id || null,

    rear_left_inner_wheel_id : props.selectedVehicle?.rear_left_inner_wheel_id || null,
    rear_left_outer_wheel_id : props.selectedVehicle?.rear_left_outer_wheel_id || null,

    rear_right_inner_wheel_id : props.selectedVehicle?.rear_right_inner_wheel_id || null,
    rear_right_outer_wheel_id : props.selectedVehicle?.rear_right_outer_wheel_id || null,

    odometer_reading : props.selectedVehicle?.odometer_reading || null,
    hour_meter_reading : props.selectedVehicle?.hour_meter_reading || null,
           
});

const isDuplicateWheel = (wheelId) => {
    if(!wheelId) return false; // Ignore null or empty values

    const wheelIds = [
        form.value.spare_wheel_id,

        form.value.front_left_wheel_id,
        form.value.front_right_wheel_id,

        form.value.center_left_inner_wheel_id,
        form.value.center_left_outer_wheel_id,

        form.value.center_right_inner_wheel_id,
        form.value.center_right_outer_wheel_id,

        form.value.rear_left_inner_wheel_id,
        form.value.rear_left_outer_wheel_id,

        form.value.rear_right_inner_wheel_id,
        form.value.rear_right_outer_wheel_id,
    ];

    // return wheelIds.includes(wheelId);
    return wheelIds.filter(id => id === wheelId).length > 1;
};

const hasDuplicateWheelIds = computed(() => {
    const wheelIds = [
        form.value.spare_wheel_id,

        form.value.front_left_wheel_id,
        form.value.front_right_wheel_id,

        form.value.center_left_inner_wheel_id,
        form.value.center_left_outer_wheel_id,

        form.value.center_right_inner_wheel_id,
        form.value.center_right_outer_wheel_id,

        form.value.rear_left_inner_wheel_id,
        form.value.rear_left_outer_wheel_id,

        form.value.rear_right_inner_wheel_id,
        form.value.rear_right_outer_wheel_id,
    ].filter(id => id !== null && id !== '');

    // console.log(new Set(wheelIds).size,wheelIds.length);

    return new Set(wheelIds).size !== wheelIds.length;
});

const save = async () => {
  
    if(hasDuplicateWheelIds.value){
        toast.add({severity:'error', summary:'Error', detail:'Duplicate wheel selection is not allowed.', life: 3000});
    
    }else{
        emit('save', form.value);
    }
}

const emit = defineEmits([
    'save'
]);

</script>

<style lang="css" scoped>
 * {
    font-size: 11pt;
 }
</style>