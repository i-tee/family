<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header bg-primary text-white">
              <h2 class="card-title mb-0">Добавить новую персону</h2>
            </div>
            <div class="card-body">
              <!-- Форма для создания персоны -->
              <form @submit.prevent="submitForm">
                <div class="mb-3">
                  <label for="first_name" class="form-label">Имя:</label>
                  <input
                    type="text"
                    id="first_name"
                    v-model="form.first_name"
                    class="form-control"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="last_name" class="form-label">Фамилия:</label>
                  <input
                    type="text"
                    id="last_name"
                    v-model="form.last_name"
                    class="form-control"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="middle_name" class="form-label">Отчество:</label>
                  <input
                    type="text"
                    id="middle_name"
                    v-model="form.middle_name"
                    class="form-control"
                  />
                </div>
                <div class="mb-3">
                  <label for="birth_date" class="form-label">Дата рождения:</label>
                  <input
                    type="date"
                    id="birth_date"
                    v-model="form.birth_date"
                    class="form-control"
                  />
                </div>
                <div class="mb-3">
                  <label for="death_date" class="form-label">Дата смерти:</label>
                  <input
                    type="date"
                    id="death_date"
                    v-model="form.death_date"
                    class="form-control"
                  />
                </div>
                <div class="mb-3">
                  <label for="tree_id" class="form-label">ID дерева:</label>
                  <input
                    type="number"
                    id="tree_id"
                    v-model="form.tree_id"
                    class="form-control"
                    required
                  />
                </div>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Создать
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="resetForm"
                  >
                    <i class="bi bi-x-lg"></i> Сбросить
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          first_name: "",
          last_name: "",
          middle_name: "",
          birth_date: "",
          death_date: "",
          tree_id: null,
        },
      };
    },
    methods: {
      async submitForm() {
        try {
          // Отправка данных на сервер
          await axios.post("/api/persons", this.form);
          alert("Персона успешно создана!");
          this.resetForm(); // Сброс формы после успешного создания
        } catch (error) {
          console.error("Ошибка при создании персоны:", error);
          alert("Произошла ошибка при создании персоны.");
        }
      },
      resetForm() {
        // Сброс формы к начальным значениям
        this.form = {
          first_name: "",
          last_name: "",
          middle_name: "",
          birth_date: "",
          death_date: "",
          tree_id: null,
        };
      },
    },
  };
  </script>
  
  <style scoped>
  /* Дополнительные стили, если нужно */
  .card {
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  }
  
  .card-header {
    border-radius: 0.5rem 0.5rem 0 0;
  }
  
  .form-label {
    font-weight: 500;
  }
  
  .btn {
    font-weight: 500;
  }
  </style>