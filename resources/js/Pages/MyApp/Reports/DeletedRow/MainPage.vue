<template>
    <div>
       <AppLayout>
            <template #nav>
                <NavBar/>
            </template>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800" > 
                    BI - Deleted Rows
                </h2>
            </template>
            <template #main>
                <div style=" margin : 0 auto; width: 28rem">   
                    <Card>   
                        <template #content>
                            <div class="flex gap-3">
                                <div class="w-4 mb-2" style=""> 
                                    <label for="" style="color:#5a5a5a"> Year</label>
                                    <Select 
                                        v-model="selectedYear"
                                        :options="props.years"
                                        optionLabel="fy_year"
                                        optionValue="fy_year"
                                        @update:modelValue="yearChange"
                                        class="w-full"
                                    />
                                </div>
                                <div class="w-5 mb-2" style=""> 
                                    <label for="" style="color:#5a5a5a"> Upload Date</label>
                                    <Select 
                                        v-model="selectedDate"
                                        :options="props.dates"
                                        optionLabel="upload_date"
                                        optionValue="upload_date"
                                        @update:modelValue="dateChange"
                                        class="w-full"
                                    />
                                </div>
                                <div style="" class="mb-2 flex items-end justify-center">
                                    <Button 
                                        icon="pi pi-cloud-download" 
                                        aria-label="Download" 
                                        label="Download" 
                                        class="w-32" 
                                        @click="download"
                                    />
                                </div>
                            
                            </div>
                        </template>
                    </Card>   
                    


                </div>

                <DataTable
                        class="mt-3"
                        :value="props.data"
                        :cols="cols"
                        scrollable
                        scrollDirection="horizontal"
                        selectionMode="multiple" 
                        v-model:selection="selectedRow"
                        scrollHeight="44rem"
                        :loading="loading"
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
            </template>
        </AppLayout>
    </div>
</template>

<script setup>
import { format } from 'date-fns';
import { ref,onMounted,computed,watch } from 'vue';
import AppLayout from '@/Layouts/AppLayoutNoSide.vue';
import NavBar from '@/Pages/Navigation/NavBar.vue';
import { router } from '@inertiajs/vue3';

const selectedYear = ref();
const selectedDate = ref();

const loading = ref(false);

const props = defineProps([
    'years',
    'dates',
    'data'
]);

const yearChange = (item) => {

    if(selectedYear.value != null)
    {
        router.get(route('deleted-rows.index'), {
            year_filter : selectedYear.value
        }, {
            only: ['dates'],
            preserveScroll: true,
            preserveState: true
        })
    }
};

const toggleLoading = () => {
    loading.value = !loading.value;
    console.log(loading.value);
};

const dateChange = async  (item) => {

    if(selectedDate.value != null)
    {

        router.get(route('deleted-rows.index'), {
            date_filter : selectedDate.value
        }, {
            only: ['data'],
            preserveScroll: true,
            preserveState: true,
            onStart: () => {
                toggleLoading();
            },

            onFinish: () => {
                toggleLoading();
            }
        });
        
    }
};

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

    { field : 'gr_comments', header : 'GR Comments', },
    { field : 'ap_comments', header : 'AP Comments', },
    { field : 'ppv_var', header : 'PPV Var', },

    { field : 'buyer_comments', header : 'Buyer Comments', },
    { field : 'item_type', header : 'Item type', },


    


]);



</script>

<style lang="css" scoped>
.p-menubar-submenu {
    z-index: 9999999999 !important;
}

.p-menu {
    z-index: 9999999999 !important;
}

.p-datatable .p-datatable-thead > tr > th {
    z-index: 1 !important;
}
</style>