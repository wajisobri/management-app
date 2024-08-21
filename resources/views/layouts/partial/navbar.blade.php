<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                <i class="ri-menu-line wrapper-menu"></i>
                <a href="../backend/index.html" class="header-logo">
                    <h4 class="logo-title text-uppercase">Webkit</h4>

                </a>
            </div>
            <div class="navbar-breadcrumb">
                <h5>Dashboard</h5>
            </div>
            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <button type="button" class="btn btn-md btn-secondary ml-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ri-logout-box-line"></i> Logout
                </button>
            </div>
        </nav>
    </div>
</div>
