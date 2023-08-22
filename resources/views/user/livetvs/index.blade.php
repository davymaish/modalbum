@extends('layouts.app')

@section('content')
    <div class="card">

        <!-- Page Heading -->
        <div class="card-header">
            <div class="pull-right">
                <a href="{!! url('my/livetvs/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New TV/Video</a>
            </div>
            <h3>Manage TVs</h3>
            <div class="go-line"></div>
        </div>
        <div class="card-body">
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
                    <th>Album</th>
                    <th>Live</th>
                    <th>Views</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tvs as $tv)
                    <tr>
                        <td>{{$tv->title}}</td>
                        <td>{{$tv->album ? $tv->album['title'] : 'None' }}</td>
                        <td>{{$tv->live}}</td>
                        <td>{{$tv->views}}</td>
                        <td>
                            <form method="DELETE" action="{!! url('my/livetvs/destroy/'. $tv->id) !!}">
                                {{csrf_field()}}
                                <a href="{!! url('my/livetvs/edit/'. $tv->id) !!}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                <a href="{!! url('tv/'. $tv->id) !!}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> View </a>
                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop