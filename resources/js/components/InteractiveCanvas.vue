<template>
  <div class="menu" id="appMenu">
    <Menu /> <!-- Используем дочерний компонент -->
  </div>
  <div class="canvas-container">
    <div ref="canvas" class="canvas">
      <!-- Элементы внутри холста -->
      <div v-for="(block, index) in blocks" :key="index" class="block" :style="{
        top: block.top + 'px',
        left: block.left + 'px',
        width: block.width + 'px',
        height: block.height + 'px',
      }" @click="selectBlock(block)">
        {{ block.text }}
      </div>
    </div>
  </div>
</template>

<script>
import Panzoom from '@panzoom/panzoom';
import Menu from './dashboard/Menu.vue';

export default {
  components: {
    Menu, // Регистрируем дочерний компонент
  },
  name: 'InteractiveCanvas',
  data() {
    return {
      blocks: [
        { id: 1, top: 50, left: 50, width: 100, height: 50, text: 'Блок 1' },
        { id: 2, text: 'Блок 2', top: 200, left: 150, width: 120, height: 60 },
        { id: 3, text: 'Блок 3', top: 200, left: 300, width: 80, height: 40 },
      ],
      selectedBlock: null,
      tree: window.tree, // Используем глобальную переменную
    };
  },
  methods: {
    initPanzoom() {
      // Инициализация Panzoom на холсте
      const canvas = this.$refs.canvas;
      Panzoom(canvas, {
        maxScale: 5, // Максимальный масштаб
        minScale: 0.5, // Минимальный масштаб
      });
    },
    selectBlock(block) {
      this.selectedBlock = block;
      console.log('Выбран блок:', block);
    },
  },
  mounted() {
    this.initPanzoom(); // Инициализация Panzoom при монтировании компонента
  },
};
</script>
