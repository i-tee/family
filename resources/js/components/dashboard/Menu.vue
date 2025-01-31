<template>
    <div class="wrapp-menu">
        <div class="p-2">
            <span>[id:{{ tree.id }}] {{ tree.name }}</span>
        </div>
        <div class="p-2"></div>
        <div class="p-2"></div>
        <div class="p-2"></div>
        <div class="p-2" v-if="hasPersons">
            <button @click="childMethod">click</button>
        </div>
    </div>
</template>

<script>
import { toRaw } from 'vue';

export default {
    methods: {
        childMethod() {
            console.log(toRaw(this.tree));
            console.log(toRaw(this.persons));
        },
        checkPersons() {
            if (Array.isArray(this.persons) && this.persons.length > 0) {
                return false;
            }
            return true;
        }
    },
    computed: {
        hasPersons() {
            return this.checkPersons();
        }
    },
    data() {
        return {
            tree: window.tree,
            persons: window.persons,
        };
    },
    mounted() {
        this.childMethod();
    },
};
</script>