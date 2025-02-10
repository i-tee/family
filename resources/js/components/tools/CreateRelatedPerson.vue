<template>
    <div>
        <p>Прямая биологическая связь</p>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <!-- Мать -->
            <input 
                type="radio" 
                class="btn-check" 
                :name="`btnradio-${person.id}`" 
                :id="`btnradio1-${person.id}`" 
                v-model="type" 
                value="m" 
                autocomplete="off"
                :disabled="person.mother_id !== null"
            >
            <label class="btn btn-outline-primary" :for="`btnradio1-${person.id}`">Мать</label>

            <!-- Отец -->
            <input 
                type="radio" 
                class="btn-check" 
                :name="`btnradio-${person.id}`" 
                :id="`btnradio2-${person.id}`" 
                v-model="type" 
                value="f" 
                autocomplete="off"
                :disabled="person.father_id !== null"
            >
            <label class="btn btn-outline-primary" :for="`btnradio2-${person.id}`">Отец</label>

            <!-- Сын -->
            <input 
                type="radio" 
                class="btn-check" 
                :name="`btnradio-${person.id}`" 
                :id="`btnradio3-${person.id}`" 
                v-model="type" 
                value="s" 
                autocomplete="off"
            >
            <label class="btn btn-outline-primary" :for="`btnradio3-${person.id}`">Сын</label>

            <!-- Дочь -->
            <input 
                type="radio" 
                class="btn-check" 
                :name="`btnradio-${person.id}`" 
                :id="`btnradio4-${person.id}`" 
                v-model="type" 
                value="d" 
                autocomplete="off"
                checked
            >
            <label class="btn btn-outline-primary" :for="`btnradio4-${person.id}`">Дочь</label>
        </div>
    </div>
    <div>
        <PersonBlock :person="person" :bio="type" :hideGender="true" :apiLink="'/relative'" />
    </div>
</template>

<script>
import PersonBlock from './CreatPerson.vue'; // Импортируем дочерний компонент PersonBlock

export default {
    components: {
        PersonBlock // Регистрируем дочерний компонент
    },
    props: {
        person: Object, // Принимаем объект person как пропс
    },
    data() {
        return {
            type: 'm' // Инициализируем переменную type значением по умолчанию
        };
    },
    computed: {
    },
    methods: {
    },
    mounted() {
        //console.log(this.person)
    }
};
</script>