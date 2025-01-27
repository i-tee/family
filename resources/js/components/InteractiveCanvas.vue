<template>
  <div class="menu" id="appMenu">
    <Menu /> <!-- Используем дочерний компонент -->
  </div>
  <div class="canvas-container" ref="canvasContainer">
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
      <span>Позиция холста: ({{ canvasX }}, {{ canvasY }})</span>
      <span>Центр контейнера: ({{ containerCenterX }}, {{ containerCenterY }})</span>
      <span>Точка центра холста: ({{ staticCenterX }}, {{ staticСenterY }})</span>
    </div>
    <!-- Кнопка для центрирования холста -->
    <button @click="resetCanvas">Сбросить в 0</button>
    <!-- Поле для ввода координат и кнопка для центрирования -->
    <input type="number" v-model.number="targetX" placeholder="X">
    <input type="number" v-model.number="targetY" placeholder="Y">
    <button @click="centerCanvasOnCoordinates(targetX, targetY)">Go</button>
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
        { id: 1, text: 'Блок 1', top: 300, left: 950, width: 60, height: 60 },
        { id: 2, text: 'Блок 2', top: 200, left: 150, width: 120, height: 60 },
        { id: 3, text: 'Центр?', top: 200, left: 300, width: 80, height: 40 },
      ],
      selectedBlock: null,
      tree: window.tree, // Используем глобальную переменную
      canvasWidth: 0, // Ширина холста
      canvasHeight: 0, // Высота холста
      canvasX: 0, // Позиция холста по X
      canvasY: 0, // Позиция холста по Y
      centerX: 0, // Координата X центра холста
      centerY: 0, // Координата Y центра холста
      staticCenterX: 0, // X центра холста
      staticСenterY: 0, // Y центра холста
      panzoomInstance: null, // Экземпляр Panzoom
      dfX: 0, // Деволтный центр системы отсчёта X
      dfY: 0, // Деволтный центр системы отсчёта Y
      targetX: 0, // Целевая координата X
      targetY: 0, // Целевая координата Y
      containerWidth: 0, // Ширина контейнера
      containerHeight: 0, // Высота контейнера
      containerCenterX: 0, // Координата X центра контейнера
      containerCenterY: 0, // Координата Y центра контейнера
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
      this.centerCanvasOnCoordinates(block.left, block.top);
    },
    updateCanvasSize() {
      const canvas = this.$refs.canvas;
      this.canvasWidth = canvas.offsetWidth;
      this.canvasHeight = canvas.offsetHeight;
      this.updateCanvasCenter(); // Обновляем координаты центра
    },
    updateContainerSize() {
      const container = this.$refs.canvasContainer;
      this.containerWidth = container.offsetWidth;
      this.containerHeight = container.offsetHeight;
      this.updateContainerCenter(); // Обновляем координаты центра контейнера
    },
    // Функция для обновления координат центра контейнера
    updateContainerCenter() {
      this.containerCenterX = Math.ceil(this.containerWidth / 2);
      this.containerCenterY = Math.ceil(this.containerHeight / 2);
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
    resetCanvas() {
      if (this.panzoomInstance) {
        // Сбрасываем масштаб и позицию холста
        this.panzoomInstance.reset();
        // Обновляем координаты
        this.canvasX = 0;
        this.canvasY = 0;
        this.updateCanvasCenter(); // Обновляем координаты центра
      }
    },
    centerCanvas() {
      this.staticCenterX = Math.ceil(this.canvasWidth / 2);
      this.staticСenterY = Math.ceil(this.canvasHeight / 2);
    },
    centerCanvasOnCoordinates(targetX, targetY) {
      if (this.panzoomInstance) {
        const containerCenterX = this.containerCenterX;
        const containerCenterY = this.containerCenterY;

        const offsetX = containerCenterX - targetX;
        const offsetY = containerCenterY - targetY;

        //this.panzoomInstance.pan(offsetX, offsetY, { animate: true });
        this.panzoomInstance.pan(offsetX, offsetY, {
          animate: true,
          duration: 500, // Длительность анимации в миллисекундах
          easing: 'ease-in-out', // Тип анимации
        });

        this.canvasX = offsetX;
        this.canvasY = offsetY;
        this.updateCanvasCenter();
      }
    }
  },
  mounted() {
    this.initPanzoom(); // Инициализация Panzoom при монтировании компонента

    // Отслеживаем изменения размеров холста
    const canvasResizeObserver = new ResizeObserver(() => {
      this.updateCanvasSize();
    });

    canvasResizeObserver.observe(this.$refs.canvas);

    // Отслеживаем изменения размеров контейнера
    const containerResizeObserver = new ResizeObserver(() => {
      this.updateContainerSize();
    });

    containerResizeObserver.observe(this.$refs.canvasContainer);

    // Инициализация начальных размеров
    this.updateCanvasSize();
    this.updateContainerSize();
    this.centerCanvas();
  },
};
</script>