@extends('layouts.app')

@section('content')
    <h1 class="page-title">
        {{ meta()->pageTitle() }}
        <div class="pull-right">
            <a href="{{ url('my/video/upload') }}" title="Upload Video">Upload</a>
        </div>
    </h1>
    <div class="block">
        @if($videos->count())
            <div class="row">
                @foreach($videos as $video)
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail video-block">
                            <div class="poster-block">
                                <a href="{{ url('v/'.$video->id) }}" title="Watch {{ $video->title }}">
                                    <img src="{{ url('v/p/'.$video->id.'-'.mt_rand(1,5).'.png') }}" class="video-poster" data-gif="{{ url($video->file_path.$video->file_hash.'_0'.mt_rand(1,3).'.gif') }}" title="{{ $video->title }}"></a>
                            </div>
                            <div class="caption">
                                <p>
                                    <a href="{{ url('v/'.$video->id) }}" title="Watch {{ $video->title }}">{{ $video->title }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-sm-12 text-center">{!! $videos->render() !!}</div>
            </div>
        @else
            <div class="block-image">
                <p>No Data Found!</p>
            </div>
        @endif
    </div>
@endsection

@section('footer_js')
    <script>
        (function () {
            var sourceSwap = function () {
                var $this = $(this);
                var newSource = $this.data('gif');
                $this.data('gif', $this.attr('src'));
                $this.attr('src', newSource);
            };

            $(function () {
                $('img.video-poster').hover(sourceSwap, sourceSwap);
            });
        })();
    </script>
@endsection