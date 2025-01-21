// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

import { createApp } from 'vue';

import ExampleComponent from './components/ExampleComponent.vue';
const app = createApp(ExampleComponent);
app.mount('#app');

import ButtonCreatPerson from './components/ButtonCreatPerson.vue';
const app2 = createApp(ButtonCreatPerson);
app2.mount('#app2');