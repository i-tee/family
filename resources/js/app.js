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

import { createApp } from 'vue';

import Person from './components/Person.vue';
import Tree from './components/Tree.vue';
import InteractiveCanvas from './components/InteractiveCanvas.vue';

// Функция для безопасного монтирования приложения
function mountApp(component, selector) {
    const mountElement = document.querySelector(selector);
    if (mountElement) {
        createApp(component).mount(selector);
    }
}

// Монтируем приложения только если их целевые элементы существуют
mountApp(Person, '#appPerson');
mountApp(Tree, '#appTree');
mountApp(InteractiveCanvas, '#InteractiveCanvas');