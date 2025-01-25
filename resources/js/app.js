// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

import './bootstrap';

import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
axios.defaults.baseURL = import.meta.env.VITE_VUE_APP_API_URL;
axios.defaults.withCredentials = true;
window.axios = axios;

//vue.js

import { createApp } from 'vue';

import Person from './components/Person.vue';
import Tree from './components/Tree.vue';

createApp(Person).mount('#appPerson');
createApp(Tree).mount('#appTree');
