@extends('layouts.main')

@section('main')
    <h2>Create post</h2>

    <form action="{{ route('post.store') }}" method="POST">
        {!! csrf_field() !!}
        <label for="title">Title</label>
        <input type="text" id="title" name="title">
        <hr>
        <label for="body">Body</label>
        <textarea name="body" id="body" cols="30" rows="10"></textarea>
        <hr>
        <button type="submit">Post</button>
    </form>
@endsection