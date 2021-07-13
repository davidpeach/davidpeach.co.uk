@extends('layouts.main')

@section('main')
    @foreach($posts as $post)
        <article>
            <h2>
                <a href="{{ route('post.show', ['post' => $post]) }}">{{ $post->title }}</a>
            </h2>
            <div>
                {{ $post->body }}
            </div>
        </article>
    @endforeach
@endsection