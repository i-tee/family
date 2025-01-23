// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

import axios from 'axios';
axios.defaults.baseURL = import.meta.env.VITE_VUE_APP_API_URL;
window.axios = axios;

import { createApp } from 'vue';

import Person from './components/Person.vue';
createApp(Person).mount('#appPerson');