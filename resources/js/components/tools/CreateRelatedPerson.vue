<template>
    <div>
        <p>Прямая биологическая связь</p>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" v-model="type" value="m"
                autocomplete="off">
            <label class="btn btn-outline-primary" for="btnradio1">Мать</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" v-model="type" value="f"
                autocomplete="off">
            <label class="btn btn-outline-primary" for="btnradio2">Отец</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" v-model="type" value="s"
                autocomplete="off">
            <label class="btn btn-outline-primary" for="btnradio3">Сын</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" v-model="type" value="d"
                autocomplete="off">
            <label class="btn btn-outline-primary" for="btnradio4">Дочь</label>
        </div>
    </div>
    <div>
        <PersonBlock :person="person" :bio="type" :hideGender="true" :apiLink="'/relative'"/>
    </div>
</template>

<script>
import PersonBlock from './CreatPerson.vue'; // Импортируем дочерний компонент PersonBlock

export default {
    components: {
        PersonBlock // Регистрируем дочерний компонент
    },
    props: {
        person: Object,
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