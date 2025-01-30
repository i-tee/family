<x-app-layout>
    <script>
        window.tree = @json($tree);       
        window.persons = @json($persons);
        console.log(window.tree);
        console.log(window.persons);
    </script>
    <div class="InteractiveCanvas" id="InteractiveCanvas">InteractiveCanvas</div>
</x-app-layout>