<template>
    <div class="wrapp-menu p-2">
        <div class="row">
            <div class="col">
                <span>[id:{{ tree.id }}] {{ tree.name }}</span>
            </div>
            <div class="col"></div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        childMethod() {
            console.log('Метод дочернего компонента вызван!');
        },
    },
    data() {
        return {
            tree: window.tree // Используем глобальную переменную
        };
    },
};
</script>