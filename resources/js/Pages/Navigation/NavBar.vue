<template>
    <div>
        <Menubar :model="items">
            <template #end>
                |
                <template v-if="user">
                    
                    <Button
                        text
                        icon="pi pi-user"
                        :label="user.name"
                        severity="contrast"
                        @click="toggle"
                    />
                    <Menu ref="menu" :model="userMenu" popup />
                </template>
                <template v-else>
                    
                    <Button
                        text
                        icon="pi pi-sign-in"
                        label="Login"
                        severity="contrast"
                        @click="goLogin"
                    />
                </template>
            </template>
        </Menubar>
      
    </div>
</template>

<script setup>
import { router,usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const user = page.props.auth?.user;
// const rights = page.props.rights;

const items = ref([
    {
        label : 'Dashboard',
        icon : 'pi pi-chart-pie',
        url : '/dashboard'
    }
]); 

const menu = ref();
const toggle = (event) => {
    menu.value.toggle(event);
};

const logout = () => {
    router.post(route('logout'));
};

const userMenu = [{
    label : 'Logout',
    icon : 'pi pi-sign-out',
    command: logout,
}];

const goLogin = () => {
    router.visit('/login');
};


items.value.push(...page.props.rights);

// const items =  page.props.rights;

</script>

<style lang="css" scoped>


</style>