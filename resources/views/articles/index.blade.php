<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Tutorial Idea Aggregator</title>
    <!-- Tailwind with Typography Plugin for styling Markdown -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <!-- Alpine.js for the tab toggles -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-indigo-600">Tutorial Inspiration Board</h1>

        <div class="flex gap-6 mb-6 border-b pb-4">
            <a href="{{ route('home') }}" class="{{ !request('bookmarked') ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1' : 'text-gray-500 hover:text-indigo-600' }}">Trending Now</a>
            <a href="{{ route('home', ['bookmarked' => 1]) }}" class="{{ request('bookmarked') ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1' : 'text-gray-500 hover:text-indigo-600' }}">My Inspiration Board</a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('home') }}" method="GET" class="mb-8 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search topics (e.g., react, python)..." class="flex-1 p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">Search</button>
            @if(request('search'))
                <a href="{{ route('home') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">Clear</a>
            @endif
        </form>

        <!-- Articles List -->
        <div class="space-y-4">
            @forelse ($articles as $article)
                <!-- The Main Card Wrapper -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-4">
                    
                    <!-- Header: Title and Bookmarks -->
                    <div class="flex justify-between items-start mb-2">
                        <h2 class="text-xl font-bold pr-4">
                            <a href="{{ $article->url }}" target="_blank" class="hover:text-indigo-600 transition">{{ $article->title }}</a>
                        </h2>
                        <div class="flex items-center gap-3">
                            <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2 py-1 rounded-full whitespace-nowrap">
                                💖 {{ $article->public_reactions_count }}
                            </span>
                            <form action="{{ route('articles.bookmark', $article) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="Toggle Bookmark" class="text-2xl transition hover:scale-110 {{ $article->is_bookmarked ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-400' }}">
                                    ★
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Description and Tags -->
                    <p class="text-gray-600 mb-4">{{ Str::limit($article->description, 150) }}</p>
                    <div class="flex gap-2">
                        @foreach ($article->tags as $tag)
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">#{{ $tag }}</span>
                        @endforeach
                    </div>

                    <!-- Draft Section (Only shows if bookmarked) -->
                    @if ($article->is_bookmarked)
                        <div class="mt-4 pt-4 border-t border-gray-100" x-data="{ mode: 'preview' }">
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-sm font-semibold text-gray-700">Tutorial Outline & Notes</label>
                                <!-- Tab Controls -->
                                <div class="flex bg-gray-100 rounded-lg p-1">
                                    <button type="button" @click="mode = 'preview'" :class="{'bg-white shadow-sm': mode === 'preview'}" class="text-xs px-3 py-1 rounded font-medium text-gray-600 transition">Preview</button>
                                    <button type="button" @click="mode = 'edit'" :class="{'bg-white shadow-sm': mode === 'edit'}" class="text-xs px-3 py-1 rounded font-medium text-gray-600 transition">Edit</button>
                                </div>
                            </div>

                            <!-- Preview Mode -->
                            <div x-show="mode === 'preview'" class="prose prose-sm prose-indigo max-w-none bg-gray-50 p-4 rounded-lg border border-gray-100 min-h-[100px]">
                                @if($article->draft_outline)
                                    {!! Str::markdown($article->draft_outline) !!}
                                @else
                                    <p class="text-gray-400 italic mb-0">No notes drafted yet. Click edit to start.</p>
                                @endif
                            </div>

                            <!-- Edit Mode -->
                            <form x-cloak x-show="mode === 'edit'" action="{{ route('articles.draft', $article) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <textarea name="draft_outline" rows="5" placeholder="Draft your tutorial outline here using Markdown...&#10;&#10;## Introduction&#10;- Point 1&#10;- Point 2" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none text-sm text-gray-800 font-mono">{{ $article->draft_outline }}</textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold text-sm hover:bg-indigo-700 transition">Save Notes</button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div> <!-- End Main Card Wrapper -->
            @empty
                <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                    No articles found. Try a different search!
                </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        <div class="mt-8">
            {{ $articles->withQueryString()->links() }}
        </div>
    </div>
</body>
</html>