<template>
    <h3>{{ block.last_name }} {{ block.first_name }} {{ block.middle_name }}</h3>
    <p>{{ block.birth_date }}</p>
    <code>{{ block }}</code>
</template>

<script>
import { defineAsyncComponent } from 'vue';

export default {
    props: {
        block: Object,
    },
    data() {
        return {}; // Возвращаем пустой объект
    },
    computed: {
    },
    methods: {
    }
};
</script>