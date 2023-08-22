@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body block">
                    <h1 class="text-center">Upload and share images securely with {{ config('app.name') }}!</h1>
                    <p class="lead text-center">Select the images and click upload.</p>

                    {!! Form::open(['files'=>true, 'url'=>url('my/image/create'), 'id'=>'form_upload', 'class' => 'form-horizontal', 'role'=>'form']) !!}

                    <div class="form-group row mb-3">
                        <div class="col-sm-12">
                            <div id="image_uploader"></div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-sm-12">
                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder'=>'Image Title']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-sm-12">
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows'=>'3', 'placeholder'=>'Image Description']) !!}
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
                        <div class="col-lg-1 col-md-1 col-sm-2"><label for="adult" class="control-label">Adult: </label></div>
                        <div class="col-lg-1 col-md-1 col-sm-2">
                            <label class="control-label">{!! Form::radio('adult', 1, (old('adult') ? old('adult') : false), []) !!} Yes </label></div>
                        <div class="col-lg-1 col-md-1 col-sm-2">
                            <label class="control-label">{!! Form::radio('adult', 0, (old('adult') ? old('adult') : true), []) !!} No </label></div>
                        <div class="col-sm-12"><p class="help-block">Is this image Safe for Work?</p></div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-lg-1 col-md-1 col-sm-2"><label for="private" class="control-label">Private: </label></div>
                        <div class="col-lg-1 col-md-1 col-sm-2">
                            <label class="control-label">{!! Form::radio('private', 1, (old('private') ? old('private') : false), []) !!} Yes </label>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-2">
                            <label class="control-label">{!! Form::radio('private', 0, (old('private') ? old('private') : true), []) !!} No </label>
                        </div>
                        <div class="col-sm-12"><p class="help-block">Should this image be hidden from search engines?</p></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-lg-1 col-md-1 col-sm-2"><label for="expire" class="control-label">Expire: </label></div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            {!! Form::select('expire', [
                            0 => 'Never',
                            10 => '10 Minutes',
                            60 => '1 Hour',
                            1440 => '1 Day',
                            10080 => '1 Week',
                            43800 => '1 Month',
                            ], null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="col-sm-12">
                            <p class="help-block">This image will be deleted after?</p>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-sm-12">
                            {!! Form::submit('Upload', ['id'=>'btn_image_uploader', 'class'=>'btn btn-info']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
                @include('user.partials.fineuploader')
            </div>
        </div>
    </div>
</div>
@endsection
