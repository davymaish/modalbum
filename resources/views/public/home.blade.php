@extends('layouts.app')

@section('content')

    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 carousel">
                    <h1 class="section-title">Share Videos and Photos</h1>
                    <p class="jumbotron-sub-text">Effortlessly</p>

                    <div class="jumbotron-button-wrap">
                        <a class="btn btn-lg-outline" href="#">Upload Videos</a>
                        <a class="btn btn-lg-filled" href="{#">Upload Photos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="home-campaign section-bg-white">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">Why choose us </h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="title">
                            <h4>Home1</h4>
                        </div>
                        <div class="desc">
                            <p>Home1 Desc</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-history"></i>
                        </div>
                        <div class="title">
                            <h4>Home2</h4>
                        </div>
                        <div class="desc">
                            <p>Home2 Desc</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <div class="title">
                            <h4>Home3</h4>
                        </div>
                        <div class="desc">
                            <p>Home3 Desc</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="why-choose-us-box">
                        <div class="icon">
                            <i class="fa fa-gift"></i>
                        </div>
                        <div class="title">
                            <h4>Home 4</h4>
                        </div>
                        <div class="desc">
                            <p>Home 4 Desc</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection