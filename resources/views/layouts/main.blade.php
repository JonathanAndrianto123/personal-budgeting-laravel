<!doctype html>
<html lang="en">

<head>
  <title>Finances &mdash; Website Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="{{ asset('finances-master/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('finances-master/css/jquery-ui.css')}}">
  <link rel="stylesheet" href="{{ asset('finances-master/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('finances-master/css/owl.theme.default.min.css')}}">
  <link rel="stylesheet" href="{{ asset('finances-master/css/owl.theme.default.min.css')}}">

  <link rel="stylesheet" href="{{ asset('finances-master/css/jquery.fancybox.min.css')}}">

  <link rel="stylesheet" href="{{ asset('finances-master/css/bootstrap-datepicker.css')}}">

  <link rel="stylesheet" href="{{ asset('finances-master/fonts/flaticon/font/flaticon.css')}}">

  <link rel="stylesheet" href="{{ asset('finances-master/css/aos.css')}}">

  <link rel="stylesheet" href="{{ asset('finances-master/css/style.css')}}">

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">


  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>


  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    @yield('navbar')

    @yield('content')

    @yield('category')

    @yield('about')
    

    @yield('transactions')
    
    @yield('budgets')

    @yield('reports')


    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-5">
                <h2 class="footer-heading mb-4">About Us</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere laudantium magnam voluptatum
                  autem. Amet aliquid nesciunt veritatis aliquam.</p>
              </div>
              <div class="col-md-3 ml-auto">
                <h2 class="footer-heading mb-4">Quick Links</h2>
                <ul class="list-unstyled">
                  <li><a href="#about-section" class="smoothscroll">Terms</a></li>
                  <li><a href="#about-section" class="smoothscroll">Policy</a></li>
                  <li><a href="#about-section" class="smoothscroll">About Us</a></li>
                  <li><a href="#services-section" class="smoothscroll">Services</a></li>
                  <li><a href="#testimonials-section" class="smoothscroll">Testimonials</a></li>
                  <li><a href="#contact-section" class="smoothscroll">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-md-3 footer-social">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h2 class="footer-heading mb-4">Subscribe Newsletter</h2>
            <form action="#" method="post" class="footer-subscribe">
              <div class="input-group mb-3">
                <input type="text" class="form-control border-secondary text-white bg-transparent"
                  placeholder="Enter Email" aria-label="Enter Email" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary text-black" type="button" id="button-addon2">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              <p>Copyright &copy;
                <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made
                with <i class="icon-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com"
                  target="_blank">Colorlib</a>
              </p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

            </div>
          </div>

        </div>
      </div>
    </footer>

  </div> <!-- .site-wrap -->

  <script src="{{ asset('finances-master/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('finances-master/js/jquery-ui.js') }}"></script>
  <script src="{{ asset('finances-master/js/popper.min.js') }}"></script>
  <script src="{{ asset('finances-master/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('finances-master/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('finances-master/js/jquery.countdown.min.js') }}"></script>
  <script src="{{ asset('finances-master/js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('finances-master/js/aos.js') }}"></script>
  <script src="{{ asset('finances-master/js/jquery.fancybox.min.js') }}"></script>
  <script src="{{ asset('finances-master/js/jquery.sticky.js') }}"></script>
  <script src="{{ asset('finances-master/js/isotope.pkgd.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script src="{{ asset('finances-master/js/main.js') }}"></script>


</body>

</html>