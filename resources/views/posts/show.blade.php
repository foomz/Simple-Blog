<x-main-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->title }}
            </h2>
            @if (Auth::check() && Auth::id() === $post->user_id)
                <div class="flex items-center space-x-2">
                <a href="{{ route('posts.edit', $post->id) }}" 
           style="display: inline-block; background-color: #EAB308; color: white; padding: 8px 16px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; text-decoration: none; margin-right: 8px;">
            Edit
        </a>
                    
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>
    
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <span>{{ $post->user->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                </div>

                @if ($post->featured_image)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" 
                            class="w-full h-80 object-cover rounded">
                    </div>
                @endif

                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <div class="mt-10 pt-10 border-t border-gray-200">
                <h3 class="text-xl font-bold mb-6">Comments ({{ $comments->total() }})</h3>

                @auth
                    <div class="mb-8">
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700">Add a comment</label>
                                <textarea name="content" id="content" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required></textarea>
                                @error('content')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" style="display: inline-block; background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
    Submit Comment
</button>
                        </form>
                    </div>
                @else
                    <div class="bg-gray-100 p-4 rounded mb-8">
                        <p>Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">log in</a> to leave a comment.</p>
                    </div>
                @endauth

                @if ($comments->count() > 0)
                    <div class="space-y-6">
                        @foreach ($comments as $comment)
                            <div class="bg-gray-50 p-4 rounded" id="comment-{{ $comment->id }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <span class="font-medium">{{ $comment->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    @if (Auth::check() && (Auth::id() === $comment->user_id || Auth::id() === $post->user_id))
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                
                                <div class="text-gray-800">
                                    {!! nl2br(e($comment->content)) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $comments->links() }}
                    </div>
                @else
                    <p class="text-gray-500">No comments yet. Be the first to leave a comment!</p>
                @endif
            </div>
        </div>
    </div>
</x-main-layout>
