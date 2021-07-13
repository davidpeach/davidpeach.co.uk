@extends('layouts.main')

@section('main')
    @foreach($posts as $post)
        <article>
            <h2>{{ $post->title }}</h2>
            <div>
                {{ $post->body }}
            </div>
        </article>
    @endforeach
@endsection