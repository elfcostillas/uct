<template>
    <div>
       <AppLayout>
            <template #nav>
                <NavBar/>
            </template>

            <template #main>
                <Card>   
                    <template #content>
                        <div class="grid grid-cols-8 gap-4 ">
                            <div style="">
                                <label>Date</label>
                                <Select 
                                    v-model="selectedDate"
                                    :options="props.po_dates" 
                                    optionLabel="label" 
                                    optionValue="value"
                                    class="w-full"
                                    checkmark
                                    @update:modelValue="dateChange"
                                    filter
                                />
                            </div>

                            <div style="">
                                <label>PO Status</label>
                                <Select 
                                    v-model="selectedPOStatus"
                                    :options="po_options" 
                                    optionLabel="label" 
                                    optionValue="value"
                                    class="w-full"
                                    @update:modelValue="poStatusChange"
                                />
                            </div>
                            <div style="">
                                <label>BA Groups</label>
                                <Select 
                                    v-model="selectedBaGroup"
                                    :options="props.ba_groups" 
                                    optionLabel="ba_group" 
                                    optionValue="ba_group"
                                    class="w-full"
                                />
                            </div>
                         
                            <div style="" class="flex items-end justify-center">
                                <Button icon="pi pi-search" aria-label="Search" label="View" class="w-32" />
                            </div>
                            <div style="" class="flex items-end justify-center">
                                <Button icon="pi pi-cloud-download" aria-label="Download" label="Download" class="w-32" />
                            </div>
                            
                        </div>
                        
                       
                    </template>
                </Card>  
                <div class="mt-2">
                   
                    <DataTable
                        :value="props.data"
                        :cols="cols"
                        scrollable
                        scrollDirection="horizontal"
                        selectionMode="multiple" 
                        v-model:selection="selectedRow"
                        scrollHeight="44rem"
                    > 
                    <Column 
                        v-for="col of cols" 
                        :key="col.field" 
                        :field="col.field" 
                        :header="col.header"
                        style="min-width:10rem;"
                     >
                        <template #body="{ data }">
                            <div>
                                
                                <span v-if="col.type === 'date'">
                                    {{ format(new Date(data[col.field]), 'MM/dd/yyyy') }}
                                    <Sekeleton />
                                </span>
                                <span v-else>
                                    {{ data[col.field] }}
                                    <Sekeleton />
                                </span>
                            </div>
                        </template>
                    </Column>
                    </DataTable> 
                </div>
            </template>
       </AppLayout>
    </div> 
</template>

<script setup>
import { format } from 'date-fns';
import { ref,onMounted,computed } from 'vue';
import AppLayout from '@/Layouts/AppLayoutNoSide.vue';
import NavBar from '@/Pages/Navigation/NavBar.vue';
import { router } from '@inertiajs/vue3';

const selectedRow = ref();

const selectedDate = ref(null);
const selectedBaGroup = ref(null);
const selectedPOStatus = ref(null);

const props = defineProps([
    'po_dates',
    'ba_groups',
    'po_status',
    'data',
]);

const cols = ref([
    { field : 'title', header : 'Title'},
    { field : 'created_date', header : 'Create Date', type : 'date'},
    { field : 'po_no', header : 'P.O. No', },
    { field : 'po_line_no', header : 'P.O. Line No', },
    { field : 'po_status', header : 'P.O. Status', },
    { field : 'vendor', header : 'Vendor', },
    { field : 'ap_person', header : 'AP Person', },
    { field : 'invoice_name', header : 'Invoice Name', },
    { field : 'invoice_value', header : 'Invoice Value', },
    { field : 'currency', header : 'Currency', },
    { field : 'buyer', header : 'Buyer', },
    { field : 'record_issue', header : 'Record Issue', },
    { field : 'ba_group', header : 'BA Group', },
    { field : 'buyer_admin', header : 'Buyer Admin', },
    { field : 'ba_record_status', header : 'BA Record Status', },
    { field : 'ba_comments', header : 'BA Comments', },
    { field : 'buyer_comments', header : 'Buyer Comments', },
    { field : 'item_type', header : 'Item type', },


//     created_date
// po_no
// po_line_no
// po_status
// vendor
// invoice_link
// vendor_email
// ap_person
// invoice_name
// invoice_value
// currency
// buyer
// record_issue
// ba_group
// buyer_admin
// ba_record_status
// ba_comments
// buyer_comments
// auto_update
// item_type
// path
]);

const listboxItems = ref([{value : 0, name : 'All'}]);

const po_options = ref([{ label : 'All', value : 'All' }]);


onMounted(() => {

    po_options.value.push(...props.po_status.map(item => ({
            label : item.po_status,
            value : item.po_status 
        }))
    );

    // listboxItems.value.push(...props.vehicleTypes);

    // if(params.get('search'))
    // {
    //     selectedItem.value = listboxItems.value.find(item => item.value == params.get('search'));
    // }
});

const dateChange = async (data) => {
    // console.log(selectedDate.value,data);
    if(selectedDate.value != null)
    {
        router.get(route('pending-po.index'), {
            created_date: selectedDate.value
        }, {
            only: ['ba_groups','data'],
            preserveScroll: true,
            preserveState: true
        })
    }
}

const poStatusChange = async (data) => {
  
    if(selectedPOStatus.value != null)
    {
        router.get(route('pending-po.index'), {
            created_date: selectedDate.value || null,
            po_status: selectedPOStatus.value ,
        }, {
            only: ['ba_groups'],
            preserveScroll: true,
            preserveState: true
        })
    }
}



</script>

<style lang="css" scoped>
    * {
        font-size: 10pt;
    }
</style>