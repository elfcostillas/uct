<template>
    <div style="width:100%;">
        <DataTable 
            tableStyle="width:100%" 
            :value="data"
            paginator
            paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
            currentPageReportTemplate="{first} to {last} of {totalRecords}"
            :rows=7
            :loading="loading"
            v-model:filters="filters"
            >  
            <template #header> 
                <Button 
                    severity="primary" raised
                    icon="pi pi-plus" 
                    label="Create"  
                    
                    @click="$emit('create',null)">
                    
                </Button>
                <Toolbar class="mt-2">
                    <template #start>
                        <IconField>
                            <InputIcon class="p-inputicon pi pi-search" />
                            <InputText v-model="filters['global'].value" class=" w-80" placeholder="Search" />
                        </IconField>
                        <Button icon="pi pi-filter-slash" severity="secondary" @click="filters['global'].value=''" class="ml-2"> </Button>
                       
                    </template>
                    <template #end>
                        <Button icon="pi pi-sync" severity="contrast" @click="$emit('fetchData')"  class="ml-2"> </Button>
                    </template>
                </Toolbar>
            </template>
            <Column v-for="col of cols" :key="col.field" :field="col.field" :header="col.header">
                <template #body="{ data }">
                    <div>
                        <span v-if="col.type === 'actions'">
                             <Button
                                v-if="col.buttons?.includes('edit')"
                                severity="info" raised
                                icon="pi pi-pencil"
                                label="Edit"
                                
                                @click="$emit('edit', data)"
                            />

                            <Button
                                v-if="col.buttons?.includes('print')"
                                severity="danger" raised
                                icon="pi pi-file-pdf"
                                label="Print"
                                
                                @click="$emit('print', data)"
                            />
                        </span>
                        <span v-else-if="col.type === 'date'">
                            {{ format(new Date(data[col.field]), 'MM/dd/yyyy') }}
                        </span>
                        <span v-else>
                            {{ data[col.field] }}
                        </span>
                    </div>
                </template>
            </Column>
        </DataTable>  
    </div>
</template>

<script setup>
    import { format } from 'date-fns';

    import { ref } from 'vue';
    import { FilterMatchMode, FilterOperator } from '@primevue/core/api';

    defineProps([
        'data',
        'cols',
        'loading'
    ]); 

    const filters = ref(
        {
            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        }
    );

</script>

<style lang="scss" scoped>

</style>