@extends('layouts.main')

@section('main')
<h2>{{ $post->title }}</h2>
<div>
    {{ $post->body }}
</div>
@endsection