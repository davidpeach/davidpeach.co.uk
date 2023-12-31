<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 flex">
            <div class="w-1/2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-xl">
                    <form action="{{ route('dashboard.post.store') }}" method="POST">
                        {!! csrf_field() !!}
                        <label
                            for="title"
                            class="block w-full"
                        >Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="block w-full mb-5 text-xl"
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
                        ></textarea>

                        <label for="published_at"></label>
                        <input
                            type="datetime-local"
                            name="published_at"
                            id="published_at"
                            value="{{ $currentDateTime }}"
                        >

                        <label for="status" class="block">Status</label>
                        <select
                            name="status"
                            id="status"
                            class="block"
                        >
                            <option value="draft">Draft</option>
                            <option value="live">Live</option>
                            <option value="scheduled">Scheduled</option>
                        </select>

                        <button type="submit">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>