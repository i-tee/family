<x-app-layout>
    <script>
        window.tree = @json($tree);       
        window.persons = @json($persons);
    </script>
    <div class="InteractiveCanvas" id="InteractiveCanvas">InteractiveCanvas</div>
</x-app-layout>