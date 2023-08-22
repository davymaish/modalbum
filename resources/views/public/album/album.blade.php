@extends('layouts.app')

@section('header_css')
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ meta()->pageTitle() }}"/>
    <meta property="og:description" content="{{ ($album->description ? $album->description : config('app.name')) }}"/>
@endsection

@section('content')
    <h1 class="page-title">{{ meta()->pageTitle() }}</h1>
    @if(!empty($album->description))
        <p>{{ $album->description }}</p>
    @endif
    <div class="block">
        <div class="block-image pull-right">
            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#embedModal">Embed</button>
        </div>
        <div class="clearfix"></div>

        @foreach($images as $image)
            <div class="block-image">
                @if(!empty($image->title))
                    <h3>{{ $image->title }}</h3>
                @endif
                <a href="{{ url('i/'.$image->hash) }}" title="{{ ($image->title ? $image->title : 'Image '.$image->hash) }}"><img src="{{ asset_cdn('i/'.$image->hash.'.'.$image->image_extension) }}" alt=""></a>
                @if(!empty($image->description))
                    <p>{{ $image->description }}</p>
                @endif
            </div>
        @endforeach
    </div>
    <div class="pull-left" style="">{!! $images->render() !!}</div>

    @include('public.partials.embed', ['image' => $album->images])
@endsection
