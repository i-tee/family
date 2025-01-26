<template>
    <div class="wrapp-menu">
        <div class="p-2">
            <span>[id:{{ tree.id }}] {{ tree.name }}</span>
        </div>
        <div class="p-2"></div>
        <div class="p-2"></div>
        <div class="p-2"></div>
        <div class="p-2"></div>
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
            tree: window.tree
        };
    },
};
</script>