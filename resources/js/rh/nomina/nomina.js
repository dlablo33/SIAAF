import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import '@mdi/font/css/materialdesignicons.css';
import Index from './Index.vue';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import 'vuetify/styles';

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        themes: {
            light: {
                colors: {
                    primary: '#c1611a', // Color personalizado
                },
            },
        },
    },
});


const app = createApp({});
app.component('index', Index);
app.use(vuetify);
app.mount('#nomina');
