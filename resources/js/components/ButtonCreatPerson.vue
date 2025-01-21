<template>
    <div>
        <h1>Привет, кнопка!</h1>
        <p>
            <button @click="handleClick">{{ buttext }}</button>
        </p>
        <p>{{ message }}</p>
    </div>
</template>

<script>

export default {
    name: 'ButtonCreatPerson',
    data() {
        return {
            buttext: 'жми',
            message: 'Это сообщение из data!',
            xzc: 'збс, спс',
        };
    },
    methods: {
        handleClick() {
            this.buttext = this.xzc;
        },
    },
};

</script>