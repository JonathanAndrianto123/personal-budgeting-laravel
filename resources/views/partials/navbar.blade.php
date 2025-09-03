<header class="site-navbar js-sticky-header site-navbar-target" role="banner">

  <div class="container">
    <div class="row align-items-center">

      <div class="col-6 col-xl-2">
        <h1 class="mb-0 site-logo"><a href="index.html" class="h2 mb-0">DompetKu<span class="text-primary">.</span> </a>
        </h1>
      </div>

      <div class="col-12 col-md-10 d-none d-xl-block">
        <nav class="site-navigation position-relative text-right" role="navigation">
          <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
            <li><a href="#home-section" class="nav-link">Beranda</a></li>
            <li class="has-children">
              <a href="#category-section" class="nav-link">Kategori</a>
              <ul class="dropdown">
                <li><a href="#allcategories-section" class="nav-link">Lihat Semua</a></li>
                <li><a href="#addcategories-section" class="nav-link">Tambah Kategori</a></li>
                <li class="has-children">
                  <a href="#">More Links</a>
                  <ul class="dropdown">
                    <li><a href="#">Menu One</a></li>
                    <li><a href="#">Menu Two</a></li>
                    <li><a href="#">Menu Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>


            <li class="has-children">
              <a href="#transactions-section" class="nav-link">Transaksi</a>
              <ul class="dropdown">
                <li><a href="#alltransactions-section" class="nav-link">Lihat Semua</a></li>
                <li><a href="#addtransactions-section" class="nav-link">Tambah Transaksi</a></li>
                <li><a href="#transaction-report-section" class="nav-link">Laporan Transaksi</a></li>
                <li><a href="#transaction-chart-section" class="nav-link">Laporan Keuangan</a></li>
              </ul>
            </li>

            <li>
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary ml-4">Logout</button>
              </form>
            </li>
          </ul>
        </nav>
      </div>


      <div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;"><a href="#"
          class="site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a></div>

    </div>
  </div>

</header>