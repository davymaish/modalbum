@extends('layouts.app')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('my/livetvs/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New TV/Video</a>
                    </div>
                    <h3>Manage TVs</h3>
                    <div class="go-line"></div>
                </div>
                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="res">
                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                        </div>

                            <table class="table table-striped table-bordered" cellspacing="0" id="example" width="100%">
                                <thead>
                                <tr>
                                    <th>TV Name</th>
                                    <th>Category</th>
                                    <th>Live</th>
                                    <th>Views</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tvs as $tv)
                                    <tr>
                                        <td>{{$tv->title}}</td>
                                        <td>{{$tv->category}}</td>
                                        <td>{{$tv->live}}</td>
                                        <td>{{$tv->views}}</td>
                                        <td>
                                            <form method="POST" action="{!! action('TvDetailsController@destroy',['id' => $tv->id]) !!}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="my/livetvs/{{$tv->id}}/edit" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

@stop