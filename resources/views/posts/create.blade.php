<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('post.store') }}" method="POST">
                        {!! csrf_field() !!}
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title">
                        <hr>
                        <label for="body_raw">Body</label>
                        <textarea name="body_raw" id="body_raw" cols="30" rows="10"></textarea>
                        <hr>
                        <button type="submit">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>