<template>
    <h3>{{ block.last_name }} {{ block.first_name }} {{ block.middle_name }}</h3>
    <p>{{ block.birth_date }}</p>
    <a :href="`/dashboard/tree/person/${block.id}`">Редактировать</a>
    <!-- <code>{{ JSON.stringify(block, null, 2) }}</code> -->
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