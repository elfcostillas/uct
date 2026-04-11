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
                    Daily AP Report
                </h2>
            </template>

            <template #main>
                <div style="width:50%">
                    <DataTable
                        :value="props.count_by_vendor"
                        :cols="cols"
                        >
                        <Column field="vendor" header="Vendor" />
                        <Column field="ref_no_count" style="min-width: 12rem;padding-right : 10rem;" header="Total" bodyClass="text-right" />

                        <template #footer>
                            <div class="flex justify-end font-bold p-2">
                               <div style="width: 12rem" class=""> Grand Total  </div> <div style="width: 12rem;padding-right : 9rem;" class="text-right">   {{ sumOfTotals }} </div>
                            </div>
                        </template>

                    </DataTable>

                   
                </div>
                <div style="width:100%">
                    <DataTable
                        class="mt-2"
                        :value="monthly_data"
                    >
                        <Column
                            v-for="col in monthly_cols"
                            :key="col.field"
                            :field="col.field"
                            :header="col.header"
                        />
                    </DataTable>
                </div>

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


const sumOfTotals = computed(()=> {
    return props.count_by_vendor.reduce( (sum,item) => {
        return sum + Number(item.ref_no_count || 0);
    },0);
});

const cols = ref([
    { field : 'vendor', header : 'Vendor'},
    { field : 'ref_no_count', header : 'Total'},
]);

const monthly_data = computed(()=> {
    if (!props.monthly_ap_report.length) return [];

    const row = {};
    let total = 0;

    props.monthly_ap_report.forEach(item => {
        row[item.label] = item.count;
        total += Number(item.count || 0)   
    })

    row['Total'] = total;

    return [row]

});

const monthly_cols = computed(() => {
    const dynamicCols =  props.monthly_ap_report.map(item => ({
        field: item.label,
        header: item.label
    }));

    return [
        ...dynamicCols,
        { field: 'Total', header: 'Total' }
    ]
})


const props = defineProps([
    'count_by_vendor',
    'monthly_ap_report'
]);
</script>

<style lang="css" scoped>
    * {
        font-size: 10pt;
    }
</style>