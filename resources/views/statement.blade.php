<x-app-layout>
    <div class="container mt-5 w-50">
        <div class="card">
            <div class="card-header">
                Statement of account
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DATETIME</th>
                            <th>AMOUNT</th>
                            <th>TYPE</th>
                            <th>DETAILS</th>
                            <th>BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transactions->perPage() * ($transactions->currentPage() - 1) + $loop->iteration }}
                                </td>
                                <td>{{ $transaction->created_at->format('d-m-Y h:i A') }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ $transaction->details }}</td>
                                <td>{{ $transaction->balance }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">no transactions</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="d-flex">
                    {{ $transactions->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
