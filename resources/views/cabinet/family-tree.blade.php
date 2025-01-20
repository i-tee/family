<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Family Tree') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">{{ __('Your Family Trees') }}</h3>
                    
                    <!-- Список деревьев -->
                    @forelse ($trees as $tree)
                        <div class="mb-4">
                            <a href="#" class="text-blue-600">{{ $tree->name }}</a>
                        </div>
                    @empty
                        <p>{{ __('No family trees found. Create one!') }}</p>
                    @endforelse

                    <!-- Кнопка добавления нового дерева -->
                    <a href="#" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                        {{ __('Create New Tree') }}
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
