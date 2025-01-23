<template>
    <div>
        <button @click="openModal">Добавить персону</button>

        <!-- Модальное окно -->
        <div v-if="isModalOpen" class="modal">
            <div class="modal-content">
                <span class="close" @click="closeModal">&times;</span>
                <h2>{{ isEditing ? 'Редактировать персону' : 'Добавить персону' }}</h2>
                <form @submit.prevent="submitForm">
                    <div>
                        <label for="first_name">Имя:</label>
                        <input type="text" id="first_name" v-model="form.first_name" required />
                    </div>
                    <div>
                        <label for="last_name">Фамилия:</label>
                        <input type="text" id="last_name" v-model="form.last_name" required />
                    </div>
                    <div>
                        <label for="middle_name">Отчество:</label>
                        <input type="text" id="middle_name" v-model="form.middle_name" />
                    </div>
                    <div>
                        <label for="birth_date">Дата рождения:</label>
                        <input type="date" id="birth_date" v-model="form.birth_date" />
                    </div>
                    <div>
                        <label for="death_date">Дата смерти:</label>
                        <input type="date" id="death_date" v-model="form.death_date" />
                    </div>
                    <div>
                        <label for="tree_id">ID дерева:</label>
                        <input type="number" id="tree_id" v-model="form.tree_id" required />
                    </div>
                    <button type="submit">{{ isEditing ? 'Обновить' : 'Создать' }}</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            isModalOpen: false,
            isEditing: false,
            form: {
                id: null,
                first_name: '',
                last_name: '',
                middle_name: '',
                birth_date: '',
                death_date: '',
                tree_id: null,
            },
        };
    },
    methods: {
        openModal(person = null) {
            if (person) {
                this.isEditing = true;
                this.form = { ...person };
            } else {
                this.isEditing = false;
                this.form = {
                    id: null,
                    first_name: '',
                    last_name: '',
                    middle_name: '',
                    birth_date: '',
                    death_date: '',
                    tree_id: null,
                };
            }
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        async submitForm() {
            try {
                if (this.isEditing) {
                    await axios.put(`/api/persons/${this.form.id}`, this.form);
                } else {
                    await axios.post('/api/persons', this.form);
                }
                this.closeModal();
                this.$emit('refresh'); // Сообщаем родительскому компоненту об обновлении данных
            } catch (error) {
                console.error('Ошибка:', error.response.data);
            }
        },
    },
};
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    width: 300px;
}

.close {
    float: right;
    cursor: pointer;
}
</style>