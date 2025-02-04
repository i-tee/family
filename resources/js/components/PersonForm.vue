<template>
    <div>
      <h2>{{ isEditing ? 'Редактировать персону' : 'Добавить персону' }}</h2>
      <form @submit.prevent="submitForm">
        <div>
          <label for="first_name">Имя:</label>
          <input type="text" id="first_name" v-model="form.first_name" required>
        </div>
        <div>
          <label for="last_name">Фамилия:</label>
          <input type="text" id="last_name" v-model="form.last_name" required>
        </div>
        <div>
          <label for="middle_name">Отчество:</label>
          <input type="text" id="middle_name" v-model="form.middle_name">
        </div>
        <div>
          <label for="birth_date">Дата рождения:</label>
          <input type="date" id="birth_date" v-model="form.birth_date">
        </div>
        <div>
          <label for="death_date">Дата смерти:</label>
          <input type="date" id="death_date" v-model="form.death_date">
        </div>
        <div>
          <label for="tree_id">ID дерева:</label>
          <input type="number" id="tree_id" v-model="form.tree_id" required>
        </div>
        <button type="submit">{{ isEditing ? 'Обновить' : 'Создать' }}</button>
        <button type="button" @click="cancelForm">Отмена</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      person: {
        type: Object,
        default: () => ({})
      }
    },
    data() {
      return {
        form: {
          first_name: '',
          last_name: '',
          middle_name: '',
          birth_date: '',
          death_date: '',
          tree_id: null,
        },
        isEditing: false,
      };
    },
    watch: {
      person: {
        immediate: true,
        handler(newPerson) {
          if (newPerson.id) {
            this.form = { ...newPerson };
            this.isEditing = true;
          } else {
            this.form = {
              first_name: '',
              last_name: '',
              middle_name: '',
              birth_date: '',
              death_date: '',
              tree_id: null,
            };
            this.isEditing = false;
          }
        }
      }
    },
    methods: {
      submitForm() {
        const url = this.isEditing ? `/api/persons/${this.form.id}` : '/api/persons';
        const method = this.isEditing ? 'put' : 'post';
  
        axios[method](url, this.form)
          .then(() => {
            this.$emit('refresh');
            this.cancelForm();
          })
          .catch(error => {
            console.error('Ошибка при сохранении персоны:', error);
          });
      },
      cancelForm() {
        this.$emit('cancel-form');
      }
    }
  };
  </script>
  
  <style scoped>
  form div {
    margin-bottom: 10px;
  }
  </style>