<x-guest-layout>
    <div class="container mt-5 w-25">
        <h4 class="text-center">Banking App</h4>
        <div class="card mt-4">
            <div class="card-header">
                <h3>Login</h3>
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

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter Your Email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter Your Password" required>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                      </div>
                    <button class="mt-3 btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>