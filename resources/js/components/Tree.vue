<template>
  <div class="container mt-4">
    <table class="table table-hover">
      <tbody>
        <tr v-for="tree in trees" :key="tree.id">
          <td>{{ tree.name }}</td>
          <td>
            <a :href="`/dashboard/tree/${tree.id}`" class="btn btn-primary btn-sm">
              <i class="bi bi-arrow-right"></i>
            </a>
            <button @click="editTree(tree.id)" class="btn btn-warning btn-sm">
              <i class="bi bi-pencil"></i>
            </button>
            <button @click="deleteTree(tree.id)" class="btn btn-danger btn-sm">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <button @click="showCreateForm" class="btn btn-success">
      <i class="bi bi-plus-lg"></i> Создать новое дерево
    </button>

    <!-- Форма для создания/редактирования -->
    <div v-if="showForm" class="mt-4">
      <h2>{{ isEdit ? 'Редактировать дерево' : 'Создать новое дерево' }}</h2>
      <form @submit.prevent="submitForm" class="form-inline">
        <div class="form-group mb-2">
          <label for="name" class="sr-only">Название:</label>
          <input type="text" id="name" v-model="tree.name" class="form-control" placeholder="Название" required>
        </div>
        <button type="submit" class="btn btn-primary mb-2">
          <i class="bi" :class="isEdit ? 'bi-arrow-clockwise' : 'bi-check-lg'"></i> {{ isEdit ? 'Обновить' : 'Создать' }}
        </button>
        <button type="button" @click="cancelForm" class="btn btn-secondary mb-2">
          <i class="bi bi-x-lg"></i> Отмена
        </button>
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
