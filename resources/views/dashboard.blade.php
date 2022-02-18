<x-app-layout>
    <div class="container mt-5 w-50 border p-3">
        <h5>Welcome {{ auth()->user()->name }}</h5>
        <table class="table mt-5">
            <tr>
                <th>YOUR ID</th>
                <td>{{ auth()->user()->email }}</td>
            </tr>
            <tr>
                <th>YOUR BALANCE</th>
                <td>{{ auth()->user()->balance->amount }}</td>
            </tr>
        </table>
    </div>
</x-app-layout>
