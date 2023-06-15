@extends('layouts.app')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('my/livetvs') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <h3>Add TV</h3>
                    <div class="go-line"></div>
                </div>
                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="response"></div>
                        <form method="POST" action="{!! action('User\LiveTvController@store') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">TV Title<span class="required">*</span>
                                    <p class="small-label">(In Any Language)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" class="form-control col-md-7 col-xs-12" name="title" placeholder="e.g Sports" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Category<span class="required">*</span>

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="category" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->name}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">
                                </label>
                                <div class="col-md-9 col-sm-6 col-xs-12" data-toggle="buttons">
                                    <label class="btn btn-danger active">
                                        <input type="checkbox" name="live" value="yes" autocomplete="off" checked>
                                        <span class="go_checkbox"><i class="glyphicon glyphicon-ok"></i></span>
                                        Live
                                    </label>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Feature Image<span class="required">*</span>
                                    <p style="color: red" class="small-label">All Featured Image Must Be Same Size<br>(Perfect Size: 600x360)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" accept="image/*" name="featured_image" required>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">TV Embed Code<span class="required">*</span>
                                    <p class="small-label">(Embed Code)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control" name="embed" placeholder="e.g sports"></textarea>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">TV Description<span class="required">*</span>
                                    <p class="small-label">(In Any Language)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control" name="description" id="content1" placeholder="e.g sports"></textarea>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">
                                </label>
                                <div class="col-md-9 col-sm-6 col-xs-12" data-toggle="buttons">
                                    <label class="btn btn-default">
                                        <input type="checkbox" name="featured" value="yes" autocomplete="off" checked>
                                        <span class="go_checkbox"><i class="glyphicon glyphicon-ok"></i></span>
                                        Add To Featured
                                    </label>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-success btn-block">Add TV</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')
    <script type="text/javascript">
        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('content1');
        });
    </script>
@stop