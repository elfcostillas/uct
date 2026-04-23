<template>
    <div>
       <AppLayout>
            <template #nav>
                <NavBar/>
            </template>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800" > 
                    BI - Daily Changes
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

// const download = () => {
//     window.open('');
// }

const download = () => {
    window.open(`/api/reports/daily-changes/download/${selectedYear.value}`);
};

const loading = ref(false);

const props = defineProps([
    'years',
    // 'dates',
    // 'data'
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