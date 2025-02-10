<template>

    <div class="personToolsBlock">
        <div class="btn-group" role="group" aria-label="Second group">

            <!-- Ссылка "Редактирование" -->
            <a :href="`/dashboard/tree/person/${block.id}`" class="btn btn-secondary">
                <i class="bi bi-pencil"></i> <!-- Иконка редактирования -->
            </a>

            <!-- Ссылка "Добавить" -->
            <Modal :title="'Создать'" :button-class="'btn btn-secondary js-CreateRelatedPerson'" :icon="'bi bi-plus-lg'"
                :descr="'Укажите связь'" :button-confirm="'false'" :component-name="'CreateRelatedPerson'" :person="block" />

        </div>

    </div>

    <h5>{{ block.first_name }} {{ block.middle_name }}</h5>
    <!-- <code>{{ JSON.stringify(block, null, 2) }}</code> -->
    <div>
        <p><span>{{ block.width }}</span>х<span>{{ block.height }}</span></p>
        <p><span>top: {{ block.top }}</span>, <span>left: {{ block.left }}</span></p>
    </div>

</template>

<script>

//import { defineAsyncComponent } from 'vue';
import Modal from '../Modal.vue'; // Импортируем дочерний компонент Modal

export default {
    components: {
        Modal // Регистрируем дочерний компонент Modal
    },
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