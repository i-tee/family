<template>
    <div class="d-flex align-items-center bg-light border-bottom p-2">
      <!-- Информация о дереве -->
      <div class="me-3">
        <span class="fw-bold">[id:{{ tree_id }}]</span>
      </div>
  
      <!-- Кнопки/инструменты -->
      <div class="d-flex gap-2">
        <!-- Модальное окно для создания персоны -->
        <div>
          <Modal
            :title="'Создать'"
            :button-class="'btn btn-primary btn-sm js-CreatPerson'"
            :descr="'Создайте нового члена семьи'"
            :button-text="'Добавить человека'"
            :button-confirm="'Сохранить'"
            :component-name="'CreatPerson'"
          />
        </div>
  
        <!-- Дополнительные кнопки (можно добавить позже) -->
        <div>
          <button class="btn btn-outline-secondary btn-sm" @click="fetchPersons">
            Обновить список
          </button>
        </div>
      </div>
    </div>
  </template>

<script>

import { toRaw } from 'vue';
import Modal from '../Modal.vue'; // Импортируем дочерний компонент Modal

export default {
    components: {
        Modal, // Регистрируем дочерний компонент Menu
    },
    methods: {
        childMethod() {
            //console.log(toRaw(this.tree_id));
        },
        checkPersons() {
            if (Array.isArray(this.persons) && this.persons.length > 0) {
                return false;
            }
            return true;
        },
        fetchPersons() {
            axios.get('/api/persons/tree/'+this.tree_id)
                .then(response => {
                    this.persons = response.data;
                    console.log(toRaw(this.persons));
                })
                .catch(error => {
                    console.error('Ошибка при загрузке персон:', error);
                });
        },
    },
    computed: {
        
    },
    data() {
        return {
          tree_id: window.tree_id
        };
    },
    mounted() {
        this.childMethod();
    },
};
</script>