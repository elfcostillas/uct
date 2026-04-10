<script setup>
import AppLayoutVue from '@/Layouts/AppLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavBar from './Navigation/NavBar.vue';

import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';


const props = defineProps([
    'vehicles',
]);
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
                    
                </h2>
            </template>
            <template #section>
                <div>
                    <Card>
                        <template #title>
                            <h3></h3>
                        </template>
                        <template #content>
                            <h3>Work in progress...</h3>
                        </template>
                    </Card>

                </div>
            </template>
            <template #main>
                <div class="flex gap-6 flex-wrap justify-center">
                    <Card v-for="vtype in props.vehicles" class="shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 p-2"
                        :key="vtype.id"
                        :style="{ backgroundColor: '#D0F0C0',width:'164px',height:'124px'}"
                        @click="router.visit('/master-files/vehicles?search=' + vtype.id)"
                        >
                       
                        <template #title>
                            <h3>{{ vtype.veh_code }}</h3>
                        </template>
                        <template #content>
                            <h3>{{ vtype.no_of_units }}</h3>
                        </template>
                    </Card>
                </div>

            </template>
            <template #footer>
                <p>
                  
                </p>
            </template>
        </AppLayout>
    </div>
</template>

<style lang="css" >
   
    

</style>