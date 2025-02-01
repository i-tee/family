<x-app-layout>
    <div class="p-3">

        <h1>Надо выбрать дерево для отображения</h1>

        <!-- Передаем данные в компонент через атрибут -->
        <div class="appModal" data-title="Ваши деревья" data-descr="Выдерите одно из деревьев для отображения и работы с ним"
            data-button-text="Список" data-component-name="TreeListChoose" data-button-confirm="">
        </div>

    </div>
</x-app-layout>