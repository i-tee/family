<x-app-layout>
    <div class="p-3">
        <h1>Debug: Validated Data</h1>
        <pre>
            {{ var_dump(session('validated')) }}
        </pre>
    </div>
</x-app-layout>
