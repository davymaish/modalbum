@extends('layouts.app')

@section('content')

    <div class="main-banner bg-light mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 carousel text-center pt-5">
                    <h1 class="section-title">Share Videos, Live Streams and Photos Effortlessly </h1>
                    <a class="banner-btn btn btn-lg btn-primary btn-lg-outline" href="{{ url('my') }}">Share Now</a>
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
                    <div class="card p-3 bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <i class="fa-3x fa-fw fa fa-lock"></i>
                            </div>
                            <div class="col-md-9">
                                <h4>Home1</h4>
                                <p>Home1 Desc</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="card p-3 bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <i class="fa-3x fa-fw fa fa-history"></i>
                            </div>
                            <div class="col-md-9">
                                <h4>Home2</h4>
                                <p>Home2 Desc</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="card p-3 bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <i class="fa-3x fa-fw fa fa-thumbs-up"></i>
                            </div>
                            <div class="col-md-9">
                                <h4>Home3</h4>
                                <p>Home3 Desc</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="card p-3 bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <i class="fa-3x fa-fw fa fa-gift"></i>
                            </div>
                            <div class="col-md-9">
                                <h4>Home4</h4>
                                <p>Home4 Desc</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    
    <section class="home-campaign section-bg-white mt-5">
        <div class="container">
            <div class="block">
                <h1 class="page-title">{{ meta()->pageTitle() }}</h1>
                <p class="lead">Source code of this website is open source: <a href="https://github.com/davymaish/modalbum" title="GitHub Repo">GitHub Repo</a></p>
                <p class="lead">Please help us improve this site by contributing on GitHub.</p>
            </div>
        </div>
    </section>
@endsection