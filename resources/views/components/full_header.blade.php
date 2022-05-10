<header class="main-header navbar">
    <div class="col-nav">
        <a href="{{ url('/admin') }}" class="brand-wrap">
            <img src="{{url('assets/imgs/logo-emshop.png')}}" class="logo" alt="Nest Dashboard" />
        </a>
    </div>
    <div class="col-search">
        <form class="searchform">
            <div class="input-group">
                <input list="search_terms" type="text" class="form-control" placeholder="Coba Ketikkan" />
                <button class="btn btn-light bg" type="button"><i class="material-icons md-search"></i></button>
            </div>
            <datalist id="search_terms">
                <option value="Products"></option>
                <option value="New orders"></option>
                <option value="Apple iphone"></option>
                <option value="Ahmed Hassan"></option>
            </datalist>
        </form>
    </div>
    <div class="col-nav">
        <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link btn-icon" href="#">
                    <i class="material-icons md-notifications"></i>
                </a>
            </li>
            <li class="dropdown nav-item">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false"> <img class="img-xs rounded-circle" src="{{url('assets/imgs/people/avatar-2.png')}}" alt="User" /></a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                    <a class="dropdown-item" href="{{ url('/edit-profile') }}"><i class="material-icons md-perm_identity"></i>Edit Profile</a>
                    <a class="dropdown-item" href="#"><i class="material-icons md-help_outline"></i>Help center</a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger" href="{{ url('/logout') }}"><i class="material-icons md-exit_to_app"></i>Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>

<style>
    .searchform input {
        max-width: none;
    }
    .searchform button {
        width: auto;
    }
</style>