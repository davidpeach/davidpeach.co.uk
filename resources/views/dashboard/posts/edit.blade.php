<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 flex">
            <div class="w-1/2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-xl">
                    <form action="{{ route('dashboard.post.update', ['post' => $post]) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('put') !!}
                        <label
                            for="title"
                            class="block w-full"
                        >Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="block w-full mb-5 text-xl"
                            value="{{ $post->title }}"
                        >
                        <label
                            for="body_raw"
                            class="block w-full"
                        >Body</label>
                        <textarea
                            name="body_raw"
                            id="body_raw"
                            cols="30"
                            rows="10"
                            class="block w-full mb-5 text-xl"
                        >{{ $post->body_raw }}</textarea>

                        <label for="published_at"></label>
                        <input
                            type="datetime-local"
                            name="published_at"
                            id="published_at"
                            value="{{ parseDateForHtmlInput($post->published_at) }}"
                        >

                        <label for="status" class="block">Status</label>
                        <select
                            name="status"
                            id="status"
                            class="block"
                        >
                            <option value="draft" {{ $post->status === 'draft' ? 'selected': '' }}>Draft</option>
                            <option value="live" {{ $post->status === 'live' ? 'selected': '' }}>Live</option>
                            <option value="scheduled" {{ $post->status === 'scheduled' ? 'selected': '' }}>Scheduled</option>
                        </select>

                        <button type="submit">Update</button>

                    </form>
                    <form
                        method="POST"
                        action="{{ route('dashboard.post.delete', ['post' => $post]) }}"
                        onClick="return confirm('Delete?');"
                    >
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit">delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>