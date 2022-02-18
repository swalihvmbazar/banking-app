<x-app-layout>
    <div class="container mt-5 w-50">
        <div class="card">
            <div class="card-header">
                Transfer Money
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
                        Successfully Transfered
                    </div>
                @endif
                <form action="{{ route('transfer') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter Email" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control"
                            placeholder="Enter amount to withdraw" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 w-100">Transfer</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
