<template>
  <div>
    <div class="row justify-content-center">
      <div>
        <div>
          <div class="card-body">
            <p></p>
            <!-- Форма для создания персоны -->
            <form @submit.prevent="submitForm">

              <div class="row">
                <div class="mb-3 col">
                  <label for="first_name" class="form-label">Имя:</label>
                  <input type="text" id="first_name" v-model="form.first_name" class="form-control" required />
                </div>
                <div class="mb-3 col">
                  <label for="middle_name" class="form-label">Отчество:</label>
                  <input type="text" id="middle_name" v-model="form.middle_name" class="form-control" />
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col">
                  <label for="last_name" class="form-label">Фамилия:</label>
                  <input type="text" id="last_name" v-model="form.last_name" class="form-control" required />
                </div>
                <!-- Пол -->
                <div class="mb-3 col">
                  <label class="form-label">Пол:</label><br />
                  <div class="form-check form-check-inline">
                    <input type="radio" id="gender_male" v-model="form.gender" value="1" class="form-check-input"
                      :disabled="isGenderDisabled" />
                    <label for="gender_male" class="form-check-label">Мужской</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input type="radio" id="gender_female" v-model="form.gender" value="0" class="form-check-input"
                      :disabled="isGenderDisabled" checked />
                    <label for="gender_female" class="form-check-label">Женский</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col">
                  <label for="birth_date" class="form-label">Дата рождения:</label>
                  <input type="date" id="birth_date" v-model="form.birth_date" class="form-control" />
                </div>
                <div class="mb-3 col">
                  <label for="death_date" class="form-label">Дата смерти:</label>
                  <input type="date" id="death_date" v-model="form.death_date" class="form-control" />
                </div>
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

import { toRaw } from 'vue';

export default {
  props: {
    bio: String,
    person: Object,
    hideGender: Boolean,
    apiLink: String
  },
  data() {
    return {
      form: {
        first_name: "",
        last_name: "",
        middle_name: "",
        birth_date: "",
        death_date: "",
        gender: 0, // Добавлено поле для пола
        tree_id: null,
      },
      isGenderDisabled: false,
    }
  },
  watch: {
    // Наблюдаем за изменением bio
    bio(newVal, oldVal) {
      //console.log("bio изменился:", newVal);
      if (newVal == 'f' || newVal == 's') {
        this.form.gender = "1";
      } else {
        this.form.gender = "0";
      }
    }
  },
  methods: {
    async submitForm() {

      try {

        if (this.apiLink) {

          let data = {
            form: this.form,
            person: this.person,
            bio: this.bio
          }

          await axios.post(`/api/persons${this.apiLink}`, data);  // Отправка данных на сервер

        } else {

          await axios.post("/api/persons", this.form);  // Отправка данных на сервер

        }

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
        gender: null, // Сбрасываем поле пола
        tree_id: null,
      };
    },
  },
  mounted() {
    // Проверяем, существует ли объект window (защита от SSR)
    if (typeof window !== 'undefined') {
      this.form.tree_id = window.tree_id;
    }
    if (this.hideGender) {
      this.isGenderDisabled = true;
    }
  },
};
</script>
