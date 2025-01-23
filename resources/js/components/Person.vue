<template>
    <div>
      <PersonList ref="personList" v-if="!showFormVisible" @show-form="showFormVisible = true" @edit-person="editPerson" />
      <PersonForm v-else :person="selectedPerson" @refresh="fetchPersons" @cancel-form="showFormVisible = false" />
    </div>
  </template>
  
  <script>
  import PersonList from './PersonList.vue';
  import PersonForm from './PersonForm.vue';
  
  export default {
    components: {
      PersonList,
      PersonForm,
    },
    data() {
      return {
        showFormVisible: false,
        selectedPerson: {},
      };
    },
    methods: {
      editPerson(person) {
        this.selectedPerson = person;
        this.showFormVisible = true;
      },
      fetchPersons() {
        if (this.$refs.personList && this.$refs.personList.fetchPersons) {
          this.$refs.personList.fetchPersons();
        }
      }
    }
  };
  </script>