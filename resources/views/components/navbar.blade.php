<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ url('/admin') }}" class="brand-wrap">
            <img src="https://emshop.id/media/logo/stores/7/Logo_emshop_2022_tanpa_tagline.png" class="logo" alt="Nest Dashboard" />
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
        </div>
    </div>
    <nav>
        <ul class="menu-aside">
            <li class="menu-item {{ ($slug == 'dashboard') ? 'active' : '' }}">
                <a class="menu-link" href="{{url('/admin')}}">
                    <i class="icon material-icons md-home"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="menu-item has-submenu {{ ($slug == 'product') || ($slug == 'brand') || ($slug == 'category')  ? 'active' : '' }}">
                <a class="menu-link">
                    <i class="icon material-icons md-shopping_bag"></i>
                    <span class="text">Products</span>
                </a>
                <div class="submenu">
                    <a class="{{ ($slug == 'product') ? 'active' : '' }}" href="{{ url('/product') }}">Product</a>
                    <a class="{{ ($slug == 'brand') ? 'active' : '' }}" href="{{ url('/brand') }}">Brand</a>
                    <a class="{{ ($slug == 'category') ? 'active' : '' }}" href="{{ url('/category') }}">Categories</a>
                </div>
            </li>
            <li class="menu-item {{ ($slug == 'banner') ? 'active' : '' }}">
                <a class="menu-link" href="{{ url('/banner') }}">
                    <i class="icon material-icons md-image"></i>
                    <span class="text">Banner</span>
                </a>
            </li>
        </ul>
        <br />
        <br />
    </nav>
</aside>