@extends('layouts.app')

@section('content')
    <h1 class="page-title">{{ meta()->pageTitle() }}</h1>
    <div class="block">
        <div id="hero">
            <div>
                <div id="progressBar"></div>
                <video id="output" class="video-js vjs-default-skin" controls preload="auto" data-setup="{}" poster="{{ url('v/p/'.$video->id.'-'.mt_rand(1,5).'.png') }}" style="height: 350px;">
                    {{--<source src="{{ url($video->file_path.$video->file_name) }}" type="video/mp4"/>--}}
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a web browser that
                        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>
            </div>
            <div id="status">
                <div>
                    <span class="show-leech">Playing </span>
                    <span class="show-seed">Seeding </span>
                    <code>
                        <span id="torrentName">Filename</span>
                    </code>
                    <span class="show-leech"> from </span>
                    <span class="show-seed"> to </span>
                    <code id="numPeers">0 peers</code>.
                </div>
                <div>
                    <code id="downloaded"></code>
                    of <code id="total"></code>
                    — <span id="remaining"></span><br/>
                    &#x2198;<code id="downloadSpeed">0 b/s</code>
                    / &#x2197;<code id="uploadSpeed">0 b/s</code>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header_css')
    <link href="{{ url('vendor/video.css') }}" rel="stylesheet">
@endsection

@section('footer_js')
    <script src="{{ url('vendor/video.js') }}"></script>
    <script type="module" src="{{ mix('js/webtorrent.js') }}"></script>
    <script type="module">
        var torrentId = '{{ url('v/t/'.$video->id.'.torrent') }}';
        WebTorrentInit(torrentId);
    </script>
@endsection