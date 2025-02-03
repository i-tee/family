// Обеспечьте безопасную инициализацию locale
let locale;

// Определите loadTranslations ДО её использования
const loadTranslations = async () => {
    try {
        const response = await fetch(`/api/localization/${window.locale}`);
        if (!response.ok) {
            throw new Error(`Ошибка загрузки переводов: ${response.status}`);
        }
        window.translations = await response.json();
    } catch (error) {
        console.error("Не удалось загрузить переводы:", error);
    }
};

// Инициализация приложения
const initializeApp = async () => {
    // Установите значение по умолчанию, если VITE_APP_LOCALE не определено
    locale = import.meta.env.VITE_APP_LOCALE || 'ru';
    window.locale = locale;
    // Вызов loadTranslations после инициализации locale
    await loadTranslations();
};

initializeApp();

// Остальной код остаётся без изменений
import 'bootstrap/dist/css/bootstrap.min.css';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

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
import TreeListChoose from './components/tools/TreeListChoose.vue';

function mountApp(component, selector) {
    const mountElement = document.querySelector(selector);
    if (mountElement) {
        createApp(component).mount(selector);
    }
}

function mountAppWithData(component, selector) {
    const elements = document.querySelectorAll(selector);
    elements.forEach(mountElement => {
        const props = Object.fromEntries(
            Object.entries(mountElement.dataset).map(([key, value]) => [key, value])
        );
        createApp(component, props).mount(mountElement);
    });
}

mountApp(Person, '#appPerson');
mountApp(Tree, '#appTree');
mountAppWithData(Modal, '.appModal');
mountApp(InteractiveCanvas, '#InteractiveCanvas');
mountApp(TreeListChoose, '.appTreeListChoose');