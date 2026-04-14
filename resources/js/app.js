import '../css/app.css';
import './bootstrap';
import 'primeicons/primeicons.css'

import 'primeflex/primeflex.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

/* Primevue */
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';

import Menubar from 'primevue/menubar';
import Listbox from 'primevue/listbox';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { Toolbar } from 'primevue';
import { ConfirmDialog } from 'primevue';
import { Toast } from 'primevue';
import { ToastService } from 'primevue';
import { InputText } from 'primevue';
import { DatePicker } from 'primevue';
import { Message } from 'primevue';
import { InputIcon } from 'primevue';
import { IconField } from 'primevue';
import { Dialog } from 'primevue';
import { Select } from 'primevue';
import { InputNumber } from 'primevue';
import { Menu } from 'primevue';
import { Card } from 'primevue';
import { Fieldset } from 'primevue';
import { Image } from 'primevue';
import { FileUpload }  from 'primevue';
import { Skeleton } from 'primevue';

import { createPinia } from 'pinia';
import {ProgressSpinner} from 'primevue';


import ConfirmationService from 'primevue/confirmationservice';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(PrimeVue ,{ theme : { preset :Aura }})
            .component('Menubar', Menubar)
            .component('Listbox', Listbox)
            .component('DataTable', DataTable)
            .component('Column', Column)
            .component('Button', Button)
            .component('Message', Message)
            .component('Toolbar', Toolbar)
            .component('InputIcon', InputIcon)
            .component('IconField', IconField)
            .component('ConfirmDialog', ConfirmDialog)
            .component('Card', Card)
           
            .component('InputText', InputText)
            .component('DatePicker', DatePicker)
            .component('Toast', Toast)
            .component('Dialog', Dialog)
            .component('Select', Select)
            .component('InputNumber', InputNumber)
            .component('Menu', Menu)
            .component('Fieldset', Fieldset)
            .component('Image', Image)
            .component('FileUpload', FileUpload)
            .component('Skeleton', Skeleton)
            .component('ProgressSpinner', ProgressSpinner)

            .use(ToastService)
            .use(ConfirmationService)
            .use(pinia)

            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
