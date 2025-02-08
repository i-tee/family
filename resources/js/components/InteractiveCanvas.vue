<template>

  <div class="menu" id="appMenu"></div>
  <div id="windowcontainer" class="canvas-container" ref="canvasContainer" style="opacity: 0;">
    <div ref="canvas" class="canvas">
      <!-- Элементы внутри холста -->
      <div v-for="(block, index) in blocks" :key="index" class="card person-card" :data-id="block.id" :style="{
        top: block.top + 'px',
        left: block.left + 'px',
        width: block.width + 'px',
        height: block.height + 'px',
      }" @click="selectBlock(block)">
        <div>
          <div v-if="block.alert">
            <h3>Начало</h3>
            <p>Для начала работы с семейным деревом, нужно создать первого человека</p>
            <Modal :title="'Создать'" :button-class="'btn btn-primary btn-sm js-CreatPerson'"
              :descr="'Создайте нового члена семьи'" :button-text="'Добавить человека'" :button-confirm="'false'"
              :component-name="'CreatPerson'" />
          </div>
          <div v-else="block.alert">
            <PersonBlock :block="block" /> <!-- Используем дочерний компонент -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="map-index" id="map-index">
    <!-- Вывод информации о холсте -->
    <div class="canvas-info">
      <span>Холст: ({{ canvasX }}, {{ canvasY }})</span>
      <span>Центр контейнера: ({{ containerCenterX }}, {{ containerCenterY }})</span>
      <span>Центр холста: ({{ staticCenterX }}, {{ staticCenterY }})</span>
    </div>
    <!-- Поле для ввода координат и кнопка для центрирования -->
    <input type="number" v-model.number="targetX" placeholder="X">
    <input type="number" v-model.number="targetY" placeholder="Y">
    <button @click="centerCanvasOnCoordinates(targetX, targetY)">Go</button>
    <button @click="fetchTree()">fetchTree</button>
    <button @click="checkCP()">checkCP</button>
    <button @click="fetchPersons()">fetchPersons</button>
  </div>

</template>

<script>

import Panzoom from '@panzoom/panzoom'; // Импортируем библиотеку Panzoom для управления масштабированием и панорамированием
import Modal from './Modal.vue'; // Импортируем дочерний компонент Modal
import PersonBlock from './dashboard/PersonBlock.vue'; // Импортируем дочерний компонент PersonBlock
import { nextTick } from 'vue'; // Импортируем nextTick из Vue для работы с асинхронными обновлениями DOM
import { toRaw } from 'vue';

export default {
  components: {
    Modal, // Регистрируем дочерний компонент Modal
    PersonBlock // Регистрируем дочерний компонент PersonBlock
  },
  name: 'InteractiveCanvas', // Имя компонента
  data() {
    return {
      // Массив блоков, которые отображаются на холсте
      blocks: [],
      canvasSetting: window.canvasSetting,
      tree: [],
      persons: [],
      personCenter: false,
      canvasWidth: 0, // Ширина холста
      canvasHeight: 0, // Высота холста
      canvasX: 0, // Текущая позиция холста по оси X
      canvasY: 0, // Текущая позиция холста по оси Y
      staticCenterX: 0, // Координата X центра холста (без учета смещения)
      staticCenterY: 0, // Координата Y центра холста (без учета смещения)
      panzoomInstance: null, // Экземпляр Panzoom для управления холстом
      targetX: 2331, // Целевая координата X для центрирования
      targetY: 2475, // Целевая координата Y для центрирования
      containerWidth: 0, // Ширина контейнера, в котором находится холст
      containerHeight: 0, // Высота контейнера, в котором находится холст
      containerCenterX: 0, // Координата X центра контейнера
      containerCenterY: 0, // Координата Y центра контейнера
    };
  },
  methods: {
    // Инициализация Panzoom для управления холстом
    initPanzoom() {
      const canvas = this.$refs.canvas; // Получаем ссылку на элемент холста
      this.panzoomInstance = Panzoom(canvas, {
        maxScale: 5, // Максимальный масштаб
        minScale: 0.5, // Минимальный масштаб
      });

      // Отслеживаем изменения позиции и масштаба холста
      canvas.addEventListener('panzoomchange', (event) => {
        const { x, y } = event.detail; // Получаем текущие координаты холста
        this.canvasX = x; // Обновляем позицию холста по X
        this.canvasY = y; // Обновляем позицию холста по Y
      });
    },

    CreatFirstPersonBlock() {
      this.blocks.push({
        "top": this.staticCenterX,
        "left": this.staticCenterY,
        "alert": 'Надо создавть'
      });
    },

    async fetchPersons(id) {
      if (id) {
        try {
          const response = await axios.get('/api/persons/' + id);
          return response.data; // Возвращаем данные
        } catch (error) {
          console.error('Ошибка при загрузке персон:', error);
          return null; // Возвращаем null в случае ошибки
        }
      } else {
        try {
          const response = await axios.get('/api/persons/tree/' + window.tree_id);
          this.persons = response.data;
          //console.log(toRaw(this.persons));
        } catch (error) {
          console.error('Ошибка при загрузке персон:', error);
        }
      }
    },

    async checkCP() {
      if (this.tree.cp_id) {
        try {
          this.personCenter = await this.fetchPersons(this.tree.cp_id);
          this.personCenter.top = this.staticCenterX;
          this.personCenter.left = this.staticCenterY;
          this.personCenter.width = this.canvasSetting.width;
          this.personCenter.height = this.canvasSetting.height;
          return true;
        } catch (error) {
          console.error('Ошибка при загрузке центральной персоны:', error);
          return false;
        }
      } else {
        return false;
      }
    },

    //Получаем детали дерева
    async fetchTree() {
      try {
        const response = await axios.get('/api/trees/' + window.tree_id);
        this.tree = response.data;

        //console.log(toRaw(this.tree));

      } catch (error) {
        console.error('Ошибка загрузки деревьев', error);
      }
    },

    // Обработчик выбора блока на холсте
    selectBlock(block) {
      // Центрируем холст на координатах выбранного блока
      this.centerCanvasOnCoordinates(block.left, block.top);
    },

    // Обновление размеров холста
    updateCanvasSize() {
      const canvas = this.$refs.canvas; // Получаем ссылку на элемент холста
      this.canvasWidth = canvas.offsetWidth; // Обновляем ширину холста
      this.canvasHeight = canvas.offsetHeight; // Обновляем высоту холста
    },

    // Обновление размеров контейнера
    updateContainerSize() {
      const container = this.$refs.canvasContainer; // Получаем ссылку на контейнер
      this.containerWidth = container.offsetWidth; // Обновляем ширину контейнера
      this.containerHeight = container.offsetHeight; // Обновляем высоту контейнера
      this.updateContainerCenter(); // Обновляем координаты центра контейнера
    },

    // Обновление координат центра контейнера
    updateContainerCenter() {
      this.containerCenterX = Math.ceil(this.containerWidth / 2); // Вычисляем X центра контейнера
      this.containerCenterY = Math.ceil(this.containerHeight / 2); // Вычисляем Y центра контейнера
    },

    // Вычисление центра холста (без учета смещения)
    centerCanvas() {
      this.staticCenterX = Math.ceil(this.canvasWidth / 2); // Вычисляем X центра холста
      this.staticCenterY = Math.ceil(this.canvasHeight / 2); // Вычисляем Y центра холста
    },

    // Центрирование холста на указанных координатах
    centerCanvasOnCoordinates(targetX, targetY) {
      if (this.panzoomInstance) {
        const containerCenterX = this.containerCenterX; // Получаем X центра контейнера
        const containerCenterY = this.containerCenterY; // Получаем Y центра контейнера

        // Вычисляем смещение для центрирования холста на целевых координатах
        const offsetX = containerCenterX - targetX;
        const offsetY = containerCenterY - targetY;

        // Применяем смещение с анимацией
        this.panzoomInstance.pan(offsetX, offsetY, {
          animate: true,
          duration: 500, // Длительность анимации в миллисекундах
          easing: 'ease-in-out', // Тип анимации
        });

        // Обновляем текущие координаты холста
        this.canvasX = offsetX;
        this.canvasY = offsetY;
      }
    },

    // Центрирование холста при загрузке компонента
    centerCanvasOnLoad() {
      if (this.panzoomInstance) {
        // Вычисляем смещение для центрирования холста относительно контейнера
        const offsetX = this.containerCenterX - this.staticCenterX;
        const offsetY = this.containerCenterY - this.staticCenterY;

        // Применяем смещение с анимацией
        this.panzoomInstance.pan(offsetX, offsetY, { animate: true });

        // Обновляем текущие координаты холста
        this.canvasX = offsetX;
        this.canvasY = offsetY;
      }
    },
  },
  mounted() {
    // Инициализация Panzoom при монтировании компонента
    this.initPanzoom();

    // Создаем наблюдатель за изменениями размеров холста
    const canvasResizeObserver = new ResizeObserver(() => {
      this.updateCanvasSize(); // Обновляем размеры холста при изменении
    });
    canvasResizeObserver.observe(this.$refs.canvas); // Начинаем наблюдение за холстом

    // Создаем наблюдатель за изменениями размеров контейнера
    const containerResizeObserver = new ResizeObserver(() => {
      this.updateContainerSize(); // Обновляем размеры контейнера при изменении
    });
    containerResizeObserver.observe(this.$refs.canvasContainer); // Начинаем наблюдение за контейнером

    // Инициализация начальных размеров
    this.updateCanvasSize(); // Обновляем размеры холста
    this.updateContainerSize(); // Обновляем размеры контейнера
    this.centerCanvas(); // Вычисляем центр холста

    // Используем nextTick для ожидания обновления DOM
    nextTick(() => {
      // Ждем завершения ResizeObserver и других асинхронных операций
      setTimeout(() => {
        this.updateCanvasSize(); // Обновляем размеры холста
        this.updateContainerSize(); // Обновляем размеры контейнера
        this.centerCanvas(); // Вычисляем центр холста

        // Если Panzoom инициализирован, центрируем холст и делаем его видимым
        if (this.panzoomInstance) {
          this.centerCanvasOnLoad(); // Центрируем холст
          document.getElementById('windowcontainer').style.opacity = '1'; // Делаем контейнер видимым
        }
      }, 100); // Таймаут для завершения отрисовки
    });

    this.fetchTree().then(async () => {
      if (await this.checkCP()) {
        //console.log(toRaw(this.personCenter));
        this.blocks.push(this.personCenter);
        //console.log(toRaw(this.blocks));
      } else {
        this.CreatFirstPersonBlock();
        //console.log('Центральная персона не установлена.');
      }
    });

    //console.log(toRaw(this.canvasSetting));

  },
};
</script>