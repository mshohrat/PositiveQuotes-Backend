@extends('layouts.app', [
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'Download',
    'backgroundImage' => asset('assets') . "/img/bg10.jpeg",
])

@section('content')
    <div class="content">
        <div class="container">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
                <div class="container">
                    <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-9">

                            </div>
                            <div class="col-lg-5 col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ml-auto mr-auto text-center">
            <button id="google" class="btn btn-success" style="direction: rtl; width: 200px;" href="https://play.google.com/store/apps/details?id=com.ms.quokkaism">دانلود از Google Play</button>
            <br/>
            <button id="bazaar" class="btn btn-success" style="direction: rtl; width: 200px;" href="https://cafebazaar.ir/app/?id=com.ms.quokkaism">دانلود از Cafebazaar</button>
        </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
            $('.navbar-brand').off('click');
            $('#google').click(function () {
                window.location = 'https://play.google.com/store/apps/details?id=com.ms.quokkaism';
            });
            $('#bazaar').click(function () {
                window.location = 'https://cafebazaar.ir/app/?id=com.ms.quokkaism';
            });
        });
    </script>
@endpush
