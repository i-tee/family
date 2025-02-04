<x-app-layout>
    <script>
        window.tree_id = @json($tree_id);       
        window.canvasSetting = @json($canvasSetting);    
    </script>
    <div class="InteractiveCanvas" id="InteractiveCanvas">InteractiveCanvas</div>
</x-app-layout>