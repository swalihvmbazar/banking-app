<x-app-layout>
    <div class="container">
        <div class="card">
            <div class="card-body">
                Welcome {{ auth()->user()->name }}
            </div>
        </div>
    </div>
</x-app-layout>