<template>
  <div>
    <h2>Список персон</h2>
    <button @click="showForm">Добавить персону</button>
    <ul>
      <li v-for="person in persons" :key="person.id">
        {{ person.first_name }} {{ person.last_name }}
        <button @click="editPerson(person)">Редактировать</button>
        <button @click="deletePerson(person.id)">Удалить</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      persons: [],
    };
  },
  methods: {
    fetchPersons() {
      axios.get('/api/persons')
        .then(response => {
          this.persons = response.data;
        })
        .catch(error => {
          console.error('Ошибка при загрузке персон:', error);
        });
    },
    showForm() {
      this.$emit('show-form');
    },
    editPerson(person) {
      this.$emit('edit-person', person);
    },
    deletePerson(id) {
      if (confirm('Вы уверены, что хотите удалить эту персону?')) {
        axios.delete(`/api/persons/${id}`)
          .then(() => {
            this.fetchPersons();
          })
          .catch(error => {
            console.error('Ошибка при удалении персоны:', error);
          });
      }
    }
  },
  mounted() {
    this.fetchPersons();
  }
};
</script>

<style scoped>
ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin: 10px 0;
}
</style>