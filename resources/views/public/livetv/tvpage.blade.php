@extends('includes.master')
@section('content')

<section class="home-top">
    <div class="container">
        <div class="row">
            <div class="col-md-9 up">
                <div class="title-section">
                    <h1><span>{{$tvinfo->title}}</span></h1>
                    @if($tvinfo->live == "yes")
                        <span class="tvlive"><i class="fa fa-circle fa-fw"></i>Live</span>
                    @endif
                </div>
                <div class="showtv">
                    {!! $tvinfo->embed !!}
                </div>
                <div class="descriptions">
                    <h3>Description</h3><hr>
                    {!!$tvinfo->description!!}
                </div>

                <div class="descriptions">
                    <div class="fb-comments" data-width="100%" data-href="{{url('/tv')}}/{{$tvinfo->id}}" data-numposts="5"></div>
                </div>

            </div>
        </div>
    </div>
</section>

@stop