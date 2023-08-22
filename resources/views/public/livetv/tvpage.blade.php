@extends('layouts.app')

@section('content')
    <h1 class="page-title">{{ meta()->pageTitle() }}</h1>
    <div class="block">
        <div class="block-image">
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
        </div>
    </div>

@stop