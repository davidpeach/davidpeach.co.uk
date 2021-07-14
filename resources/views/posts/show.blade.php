@extends('layouts.main')

@section('main')
<h1>{{ $post->title }}</h1>
<div>
    {!! $post->body_html !!}
</div>
@endsection