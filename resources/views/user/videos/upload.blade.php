@extends('layouts.app')

@section('content')
    <h1 class="page-title">{{ meta()->pageTitle() }}</h1>
    <div class="block">
        <p class="lead">We accept <strong>3gp, avi, flv, m4v, mov, mp4, mpeg, mpg, vob, webm and wmv</strong> files up
            to <strong>4 GB</strong> file size.</p>
        {!! Form::open(['files'=>true, 'url'=>url('my/video/create'), 'id'=>'form_upload', 'class' => 'form-horizontal', 'role'=>'form']) !!}

        <div class="form-group row mb-3">
            <div class="col-sm-12">
                <div id="video_uploader"></div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <div class="col-sm-12">
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder'=>'Video Title', 'required'=>'required']) !!}
            </div>
        </div>

        <div class="form-group row mb-3">
            <div class="col-sm-12">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows'=>'3', 'placeholder'=>'Video Description', 'required'=>'required']) !!}
            </div>
        </div>

        <div class="item form-group row mb-3">
            <div class="col-sm-12">
                <select class="form-control" name="album">
                    <option value="">Select Album</option>
                    @foreach($albums as $album)
                        <option value="{{$album->id}}">{{$album->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row mb-3">
            <div class="col-sm-12">
                {!! Form::submit('Upload', ['id'=>'btn_video_uploader', 'class'=>'btn btn-info']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
    @include('user.partials.fineuploader')
@endsection
