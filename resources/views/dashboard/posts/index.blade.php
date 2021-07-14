<x-app-layout>
    <x-slot name="header">
        <p>POSTS</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach ($posts as $post)
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        {{ $post->title }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>