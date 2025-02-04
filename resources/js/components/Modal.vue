<template>
    <!-- Кнопка для открытия модального окна -->
    <button type="button" :class="buttonClass" @click="openModal">
        {{ buttonText }}
    </button>

    <!-- Модальное окно -->
    <div class="modal fade" :class="{ show: isOpen }" tabindex="-1" :style="{ display: isOpen ? 'block' : 'none' }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="p-3">{{ descr }}</div>
                <!-- Динамически загружаемый компонент -->
                <div class="modal-body">
                    <component :is="dynamicComponent" />
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Закрыть</button>
                    <button v-if="isButtonConfirm" type="button" class="btn btn-primary">{{ buttonConfirm }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Затемнение фона -->
    <div class="modal-backdrop fade" :class="{ show: isOpen }" :style="{ display: isOpen ? 'block' : 'none' }"></div>

</template>

<script>
import { defineAsyncComponent } from 'vue';

export default {
    props: {
        title: String,
        descr: String,
        buttonText: String,
        buttonClass: String,
        buttonConfirm: String,
        componentName: String // Передаем имя компонента
    },
    data() {
        return {
            isOpen: false // Состояние модального окна
        };
    },
    computed: {
        dynamicComponent() {
            if (!this.componentName) return null; // Если не передали компонент, ничего не рендерим

            return defineAsyncComponent(() => import(`./tools/${this.componentName}.vue`));
        },
        isButtonConfirm() {
            // Проверяем, что buttonConfirm не равно "false", не пустое, не null и не 0 (включая строку '0')
            return this.buttonConfirm !== false &&
                this.buttonConfirm !== "" &&
                this.buttonConfirm !== null &&
                this.buttonConfirm !== undefined &&
                this.buttonConfirm !== 0 &&
                this.buttonConfirm !== '0' &&
                this.buttonConfirm !== "false";
        }
    },
    methods: {
        openModal() {
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        }
    }
};
</script>
