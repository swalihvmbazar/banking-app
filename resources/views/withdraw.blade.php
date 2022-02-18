<x-app-layout>
    <div class="container mt-5 w-50">
        <div class="card">
            <div class="card-header">
                Withdraw Money
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <p><strong>Opps Something went wrong</strong></p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        Successfully withdraw
                    </div>
                @endif
                <form action="{{ route('withdraw') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control"
                            placeholder="Enter amount to withdraw" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 w-100">Withdraw</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
