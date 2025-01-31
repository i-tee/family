<!-- resources/js/components/Modal.vue -->
<template>
    <!-- Кнопка для открытия модального окна -->
    <button type="button" class="btn btn-primary" @click="openModal">
        {{ button }}
    </button>

    <!-- Модальное окно -->
    <div class="modal fade" :class="{ show: isOpen }" tabindex="-1" :style="{ display: isOpen ? 'block' : 'none' }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ descr }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Затемнение фона -->
    <div class="modal-backdrop fade" :class="{ show: isOpen }" :style="{ display: isOpen ? 'block' : 'none' }"></div>

</template>

<script>
export default {
    props: {
        title: String,
        descr: String,
        button: String
    },
    data() {
        return {
            isOpen: false, // Состояние модального окна
        };
    },
    methods: {
        openModal() {
            this.isOpen = true; // Открыть модальное окно
        },
        closeModal() {
            this.isOpen = false; // Закрыть модальное окно
        },
    },
    mounted(){
        
    }
};
</script>

<style scoped>
/* Стили для модального окна */
.modal {
    background: rgba(0, 0, 0, 0.5);
}

.modal.show {
    display: block;
}

.modal-backdrop.show {
    display: block;
}
</style>