@extends('layouts.main')

@section('main')
    <h1>Posts by David Peach</h1>
    @foreach($posts as $post)
        <article>
            <h2>
                <a href="{{ route('post.show', ['post' => $post]) }}">{{ $post->title }}</a>
            </h2>
            <p><time>published on {{ $post->published_at->format('jS F, Y') }} at {{ $post->published_at->format('H:i') }}</time></p>
            <div>
                {!! $post->body_html !!}
            </div>
        </article>
    @endforeach
@endsection