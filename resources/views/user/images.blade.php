@extends('layouts.app')

@section('content')
    <h1 class="page-title">{{ meta()->pageTitle() }}
        <a href="{{ url('my/image/upload') }}" title="Upload Video">Upload</a>
    </h1>
    <div class="block row">
        @if($images->count())
            <div class="row">

                @foreach($images as $image)
                    <div class="col-md-3" style="padding-bottom: 4px;">
                        <a href="{{ url('i/'.$image->hash) }}" title=""><img src="{{ asset_cdn('i/t/'.$image->hash.'.'.$image->image_extension) }}" class="img-responsive" alt="{{ $image->image_title }}"></a>
                        <button type="button" data-image-id="{{ $image->id }}" class="btn btn-sm btn-danger btn_delete_image"><i class="fa fa-trash-o"></i></button>
                    </div>
                @endforeach
            </div>
            <div class="clearfix"></div>
        @endif
    </div>
    <div class="pull-left" style="">{!! $images->render() !!}</div>
@endsection