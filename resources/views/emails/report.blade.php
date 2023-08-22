@extends('emails.template')

@section('content')
<p>Hi Admin,</p>
<p>A link has been reported on {{ config('app.name') }}.</p>
<p><strong>Email</strong>: {{ $report->email }}</p>
<p><strong>Reported Link</strong>: {{ url($report->url) }}</p>
<p><strong>Actual Link</strong>: {{ url($report->link->hash) }}</p>
<p><strong>Comment</strong>: {{ $report->comment }}</p>
@endsection
