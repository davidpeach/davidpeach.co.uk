@extends('layouts.main')

@section('main')
<h2>{{ $post->title }}</h2>
<div>
    {!! $post->body_html !!}
</div>
@endsection