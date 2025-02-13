<template>
    <!-- Кнопка для открытия модального окна -->
    <button type="button" :class="buttonClass" @click="openModal">
        {{ text() }} <i v-if="getIconClass()" :class="getIconClass()"></i>
    </button>

    <!-- Модальное окно -->
    <teleport to="body">
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
                        <component :is="dynamicComponent" :person="person"/>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" @click="closeModal">Закрыть</button> -->
                        <button v-if="isButtonConfirm" type="button" class="btn btn-primary">{{ buttonConfirm
                            }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Затемнение фона -->
        <div class="modal-backdrop fade" :class="{ show: isOpen }" :style="{ display: isOpen ? 'block' : 'none' }"></div>
    </teleport>

</template>

<script>
import { defineAsyncComponent } from 'vue';

export default {
    props: {
        title: String,
        person: Object,
        descr: String,
        buttonText: String,
        buttonClass: String,
        buttonConfirm: String,
        icon: String,
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
        },
        getIconClass() {
            // Если this.icon существует и не является пустой строкой, возвращаем его
            // Иначе возвращаем null (чтобы не рендерить <i>)
            return this.icon?.trim() ? this.icon : null;
        },
        text() {
            // Возвращаем buttonText, если он существует и не пустой
            return this.buttonText?.trim() ? this.buttonText : '';
        }
    },
    mounted(){
        //console.log(this.person)
    }
};
</script>