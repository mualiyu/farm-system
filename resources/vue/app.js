// resources/app.js

require('./bootstrap');

import { createApp } from 'vue';

import HelloVue from './components/HelloVue.vue';
import TempVue from './components/TempVue.vue';
import HumudityVue from './components/HumudityVue.vue';
import SoilVue from './components/SoilVue.vue';
import ModeVue from './components/ModeVue.vue';
import PumpVue from './components/PumpVue.vue';

// const app = 
createApp({
    components: {
        HelloVue,
        TempVue,
        HumudityVue,
        SoilVue,
        ModeVue,
        PumpVue,
    }
}).mount('#app');