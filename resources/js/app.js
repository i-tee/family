// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

import 'bootstrap/dist/css/bootstrap.min.css';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap; // Делаем доступным глобально

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
import Modal from './components/Modal.vue';

// Функция для безопасного монтирования приложения
function mountApp(component, selector) {
    const mountElement = document.querySelector(selector);
    if (mountElement) {
        createApp(component).mount(selector);
    }
}

function mountAppWithData(component, selector) {
    const elements = document.querySelectorAll(selector); // Находим все элементы с этим классом

    elements.forEach(mountElement => {
        const props = Object.fromEntries(
            Object.entries(mountElement.dataset).map(([key, value]) => [key, value])
        );

        createApp(component, props).mount(mountElement);
    });
}

// Монтируем приложения только если их целевые элементы существуют
mountApp(Person, '#appPerson');
mountApp(Tree, '#appTree');
mountAppWithData(Modal, '.appModal');
mountApp(InteractiveCanvas, '#InteractiveCanvas');