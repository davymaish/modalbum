@extends('layouts.app')

@section('content')
    <h1 class="page-title">
        {{ meta()->pageTitle() }}
        <div class="pull-right">
            <a href="{{ url('my/album/create') }}" title="New Album">Add New</a>
        </div>
    </h1>
    <div class="block">
        @if($albums->count())
            @foreach($albums as $album)
                <div class="block-image">
                    <button type="button" data-album-id="{{ $album->id }}" class="btn_delete_album btn btn-sm btn-danger pull-right"><i class="fa fa-trash-o"></i></button>
                    <a href="{!! url('my/album/edit/'. $album->id) !!}" class="btn btn-primary btn-sm pull-right "><i class="fa fa-edit"></i> Edit </a>
                    <h3>
                        <a href="{{ url('a/'.$album->hash) }}" title="{{ ($album->title ? $album->title : 'Album '.$album->hash) }}">{{ ($album->title ? $album->title : 'Album '.$album->hash) }}</a>
                        <span class=""> 
                            ({{ $album->images->count() }} Images . {{ $album->videos->count() }} Videos . {{ $album->livetvs->count() }} Livetvs)
                        </span>
                    </h3>
                    @foreach($album->images->slice(0,6) as $image)
                        <a href="{{ url('i/'.$image->hash) }}" title=""><img src="{{ asset_cdn('t/'.$image->hash.'.'.$image->image_extension) }}" alt=""></a>
                    @endforeach
                    <p>{{ $album->description }}</p>
                </div>
            @endforeach
        @else
        <div class="block-image">
            <p>No Data Found!</p>
        </div>
        @endif
    </div>
    <div class="pull-left" style="">{!! $albums->render() !!}</div>
@endsection