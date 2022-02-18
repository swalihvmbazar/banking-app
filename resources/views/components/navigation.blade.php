<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center w-100 ">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item d-flex align-items-center mr-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa fa-home"></i>
                    <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="nav-item d-flex align-items-center {{ request()->routeIs('deposit') ? 'active' : '' }}">
                    <i class="fa fa-upload"></i>
                    <a class="nav-link" aria-current="page" href="{{ route('deposit') }}">Deposit</a>
                </li>

                <li class="nav-item d-flex align-items-center {{ request()->routeIs('withdraw') ? 'active' : '' }}">
                    <i class="fa fa-download"></i>
                    <a class="nav-link" aria-current="page" href="{{ route('withdraw') }}">Withdraw</a>
                </li>

                <li class="nav-item d-flex align-items-center">
                    <i class="fa fa-arrow-right"></i>
                    <a class="nav-link" aria-current="page" href="#">Transfer</a>
                </li>
              
                <li class="nav-item d-flex align-items-center">
                    <i class="fa fa-file"></i>
                    <a class="nav-link" aria-current="page" href="#">Statement</a>
                </li>

            </ul>
        </div>
    </div>
</nav>