<x-guest-layout>
    <div class="container mt-5 w-25">
        <h4 class="text-center">Banking App</h4>
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="mb-5">Create new account</h4>
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

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" name="name" id="name" class="form-control"
                            placeholder="Enter Name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter Email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter Your Password" required>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="agree_terms_policy">
                        <label class="form-check-label" for="agree_terms_policy">
                            Agree the <a href="#">terms and policy</a>
                        </label>
                      </div>
                    <button class="mt-3 btn btn-primary w-100">Create new account</button>
                </form>
            </div>
        </div>

        <p class="text-center mt-4">Already have an account <a href="{{ route('login') }}">Sign In</a></p>
    </div>
</x-guest-layout>
