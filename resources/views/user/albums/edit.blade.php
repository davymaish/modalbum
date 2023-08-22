@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="pull-right">
                <a href="{!! url('my/albums') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <h3>Update Album</h3>
            <div class="go-line"></div>
        </div>
        <div class="card-body">
            <div id="response"></div>
            <form method="POST" action="{!! url('my/album/update/' . $album->id) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="item form-group row mb-3">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Album Title<span class="required">*</span>
                        <p class="small-label">(In Any Language)</p>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="name" class="form-control col-md-7 col-xs-12" name="title" value="{{$album->title}}" placeholder="e.g Sports" required="required" type="text">
                    </div>
                </div>
                <div class="item form-group row mb-3">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Album Description<span class="required">*</span>
                        <p class="small-label">(In Any Language)</p>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" name="description" id="content1" placeholder="e.g sports">{{$album->description}}</textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-lg-1 col-md-1 col-sm-2"><label for="adult" class="control-label">Adult: </label></div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        <label class="control-label">{!! Form::radio('adult', 1, old('adult', $album->adult), []) !!} Yes </label></div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        <label class="control-label">{!! Form::radio('adult', 0, !old('adult', $album->adult), []) !!} No </label></div>
                    <div class="col-sm-12"><p class="help-block">Is this album Safe for Work?</p></div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-lg-1 col-md-1 col-sm-2"><label for="private" class="control-label">Private: </label></div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        <label class="control-label">{!! Form::radio('private', 1, old('private', $album->private), []) !!} Yes </label>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        <label class="control-label">{!! Form::radio('private', 0, !old('private', $album->private), []) !!} No </label>
                    </div>
                    <div class="col-sm-12"><p class="help-block">Should this album be hidden from search engines?</p></div>
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
                        ], old('expire', $expire) , ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-sm-12">
                        <p class="help-block">This album will be deleted after?</p>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group row mb-3">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-success btn-block">Update Album</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('footer')
    <script type="text/javascript">
        bkLib.onDomLoaded(function() {
            new nicEditor({fullcard : true}).cardInstance('content1');
        });
    </script>
@stop