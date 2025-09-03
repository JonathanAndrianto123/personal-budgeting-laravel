@extends('layouts.main')
@section('navbar')
    @include('partials.navbar')
@endsection
@section('content')
    <div class="site-blocks-cover overlay"
        style="background-image: url('{{ asset('finances-master/images/about_2.jpg') }}');" data-aos="fade"
        id="home-section">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10 mt-lg-5 text-center">
                    <div class="">
                        @yield('login')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection