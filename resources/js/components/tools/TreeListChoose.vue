<template>
    <div class="container mt-4">
        <div class="list-group">
            <a v-for="tree in trees" :key="tree.id" :href="`/dashboard/tree/${tree.id}`"
                class="list-group-item list-group-item-action">
                {{ tree.name }}
            </a>
            <div v-if="nocountTrees()">
                <p>Нет ни одного дерева для работы, создайте семейное дерево</p>
                <p><a href="/dashboard">Панель упарвления</a></p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            trees: [], // Массив для хранения списка деревьев
        };
    },
    created() {
        this.initializeCsrf();
    },
    methods: {
        async initializeCsrf() {
            try {
                // Вызов маршрута sanctum/csrf-cookie для получения токена
                await axios.get('/sanctum/csrf-cookie');
                // После получения токена загружаем данные
                this.fetchTrees();
            } catch (error) {
                console.error('Ошибка инициализации CSRF', error);
            }
        },
        async fetchTrees() {
            try {
                const response = await axios.get('/api/trees');
                this.trees = response.data;
            } catch (error) {
                console.error('Ошибка загрузки деревьев', error);
            }
        },
        async nocountTrees() {

            if(this.trees.length){
                return true;
            }


        }
    },
    mounted() {
        this.nocountTrees();
    }
};
</script>

<style scoped>
/* Дополнительные стили, если нужно */
.list-group-item {
    transition: background-color 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    /* Цвет фона при наведении */
}
</style>