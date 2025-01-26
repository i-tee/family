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
  <div class="map-index" id="map-index">
    <!-- Вывод информации о холсте -->
    <div class="canvas-info">
      <span>Ширина холста: {{ canvasWidth }}px</span><br>
      <span>Высота холста: {{ canvasHeight }}px</span><br>
      <span>Позиция холста: ({{ canvasX }}, {{ canvasY }})</span><br>
      <span>Позиция центра холста: ({{ centerX }}, {{ centerY }})</span>
    </div>
    <!-- Кнопка для центрирования холста -->
    <button @click="centerCanvas">Центрировать холст</button>
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
        { id: 1, top: 550, left: 100, width: 100, height: 50, text: 'Блок 1' },
        { id: 2, text: 'Блок 2', top: 200, left: 150, width: 120, height: 60 },
        { id: 3, text: 'Блок 3', top: 200, left: 300, width: 80, height: 40 },
      ],
      selectedBlock: null,
      tree: window.tree, // Используем глобальную переменную
      canvasWidth: 0, // Ширина холста
      canvasHeight: 0, // Высота холста
      canvasX: 0, // Позиция холста по X
      canvasY: 0, // Позиция холста по Y
      centerX: 0, // Координата X центра холста
      centerY: 0, // Координата Y центра холста
      panzoomInstance: null, // Экземпляр Panzoom
    };
  },
  methods: {
    initPanzoom() {
      const canvas = this.$refs.canvas;
      this.panzoomInstance = Panzoom(canvas, {
        maxScale: 5, // Максимальный масштаб
        minScale: 0.5, // Минимальный масштаб
      });

      // Отслеживаем изменения позиции холста
      canvas.addEventListener('panzoomchange', (event) => {
        const { x, y } = event.detail;
        this.canvasX = x;
        this.canvasY = y;
        this.updateCanvasCenter(); // Обновляем координаты центра
      });
    },
    selectBlock(block) {
      this.selectedBlock = block;
      console.log('Выбран блок:', block);
    },
    updateCanvasSize() {
      const canvas = this.$refs.canvas;
      this.canvasWidth = canvas.offsetWidth;
      this.canvasHeight = canvas.offsetHeight;
      this.updateCanvasCenter(); // Обновляем координаты центра
    },
    // Функция для обновления координат центра холста
    updateCanvasCenter() {
      const { centerX, centerY } = this.calculateCanvasCenter();
      this.centerX = centerX;
      this.centerY = centerY;
    },
    // Функция для расчета координат центра холста
    calculateCanvasCenter() {
      const centerX = this.canvasX + this.canvasWidth / 2;
      const centerY = this.canvasY + this.canvasHeight / 2;
      return { centerX, centerY };
    },
    // Функция для центрирования холста
    centerCanvas() {
      if (this.panzoomInstance) {
        // Сбрасываем масштаб и позицию холста
        this.panzoomInstance.reset();
        // Обновляем координаты
        this.canvasX = 0;
        this.canvasY = 0;
        this.updateCanvasCenter(); // Обновляем координаты центра
      }
    },
  },
  mounted() {
    this.initPanzoom(); // Инициализация Panzoom при монтировании компонента

    // Отслеживаем изменения размеров холста
    const resizeObserver = new ResizeObserver(() => {
      this.updateCanvasSize();
    });
    resizeObserver.observe(this.$refs.canvas);

    // Инициализация начальных размеров
    this.updateCanvasSize();
  },
};
</script>