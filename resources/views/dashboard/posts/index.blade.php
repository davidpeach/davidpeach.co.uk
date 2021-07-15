<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Posts
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                <p><a href="{{ route('dashboard.post.create') }}">New Post</a></p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach ($posts as $post)
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                    <p>{{ $post->title }}</p>
                    <div>
                        <p><a href="{{ route('dashboard.post.edit', ['post' => $post]) }}">edit</a></p>
                        <p>
                            <form
                                method="POST"
                                action="{{ route('dashboard.post.delete', ['post' => $post]) }}"
                                onClick="return confirm('Delete?');"
                            >
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="submit">delete</button>
                            </form>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>