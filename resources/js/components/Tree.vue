<template>
  <div>
    <h1>Деревья</h1>
    <ul>
      <li v-for="tree in trees" :key="tree.id">
        {{ tree.name }}
        <button @click="editTree(tree.id)">Редактировать</button>
        <button @click="deleteTree(tree.id)">Удалить</button>
      </li>
    </ul>
    <button @click="showCreateForm">Создать новое дерево</button>

    <!-- Форма для создания/редактирования -->
    <div v-if="showForm">
      <h2>{{ isEdit ? 'Редактировать дерево' : 'Создать новое дерево' }}</h2>
      <form @submit.prevent="submitForm">
        <label for="name">Название:</label>
        <input type="text" id="name" v-model="tree.name" required>
        <button type="submit">{{ isEdit ? 'Обновить' : 'Создать' }}</button>
        <button type="button" @click="cancelForm">Отмена</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      trees: [],
      showForm: false,
      isEdit: false,
      tree: {
        id: null,
        name: '',
      },
    };
  },
  created() {
    this.initializeCsrf();
  },
  methods: {
    async initializeCsrf() {
      try {
        // Вызов маршрута sanctum/csrf-cookie для получения токена
        await axios.get('/sanctum/csrf-cookie');
        // После получения токена загружаем данные
        this.fetchTrees();
      } catch (error) {
        console.error('Ошибка инициализации CSRF', error);
      }
    },
    async fetchTrees() {
      try {
        const response = await axios.get('/api/trees');
        this.trees = response.data;
      } catch (error) {
        console.error('Ошибка загрузки деревьев', error);
      }
    },
    async showCreateForm() {
      this.isEdit = false;
      this.tree = { id: null, name: '' };
      this.showForm = true;
    },
    async editTree(id) {
      try {
        const response = await axios.get(`/api/trees/${id}`);
        this.tree = response.data;
        this.isEdit = true;
        this.showForm = true;
      } catch (error) {
        console.error('Ошибка при редактировании дерева', error);
      }
    },
    async deleteTree(id) {
      try {
        await axios.delete(`/api/trees/${id}`);
        this.fetchTrees();
      } catch (error) {
        console.error('Ошибка при удалении дерева', error);
      }
    },
    async submitForm() {
      try {
        if (this.isEdit) {
          await axios.put(`/api/trees/${this.tree.id}`, this.tree);
        } else {
          await axios.post('/api/trees', this.tree);
        }
        this.fetchTrees();
        this.cancelForm();
      } catch (error) {
        console.error('Ошибка при сохранении дерева', error);
      }
    },
    cancelForm() {
      this.showForm = false;
      this.isEdit = false;
      this.tree = { id: null, name: '' };
    },
  },
};
</script>
