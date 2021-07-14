@extends('layouts.main')

@section('main')
    @foreach($posts as $post)
        <article>
            <h2>
                <a href="{{ route('post.show', ['post' => $post]) }}">{{ $post->title }}</a>
            </h2>
            <p><time>published on {{ $post->published_at->format('jS F, Y') }}</time></p>
            <div>
                {!! $post->body_html !!}
            </div>
        </article>
    @endforeach
@endsection