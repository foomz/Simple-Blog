<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog Posts') }}
        </h2>
    </x-slot>
    
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @foreach ($posts as $post)
                <article class="mb-8 pb-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <span>{{ $post->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}</span>
                    </div>

                    @if ($post->featured_image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" 
                                class="w-full h-64 object-cover rounded">
                        </div>
                    @endif

                    <div class="prose mb-4">
                        {{ Str::limit(strip_tags($post->content), 250) }}
                    </div>
                    
                    <a href="{{ route('posts.show', $post->slug) }}" class="inline-block text-blue-600 hover:text-blue-800">
                        Read more →
                    </a>
                </article>
            @endforeach

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-main-layout>
