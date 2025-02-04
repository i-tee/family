<template>
  <div>
    <div class="row justify-content-center">
      <div>
        <div>
          <div class="card-body">
            <p></p>
            <!-- Форма для создания персоны -->
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <label for="first_name" class="form-label">Имя:</label>
                <input type="text" id="first_name" v-model="form.first_name" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="last_name" class="form-label">Фамилия:</label>
                <input type="text" id="last_name" v-model="form.last_name" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="middle_name" class="form-label">Отчество:</label>
                <input type="text" id="middle_name" v-model="form.middle_name" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="birth_date" class="form-label">Дата рождения:</label>
                <input type="date" id="birth_date" v-model="form.birth_date" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="death_date" class="form-label">Дата смерти:</label>
                <input type="date" id="death_date" v-model="form.death_date" class="form-control" />
              </div>
              <br>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Создать
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
        location.reload();
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
  mounted() {
    // Проверяем, существует ли объект window (защита от SSR)
    if (typeof window !== 'undefined') {
      this.form.tree_id = window.tree_id;
    }
  },
};
</script>