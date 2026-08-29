<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Tutorial Idea Aggregator</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

                    @if ($article->is_bookmarked)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <form action="{{ route('articles.draft', $article) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tutorial Outline & Notes</label>
                                <!-- Using a monospaced font for a better Markdown drafting experience -->
                                <textarea name="draft_outline" rows="4" placeholder="Draft your tutorial outline here using Markdown..." class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none text-sm text-gray-800 font-mono">{{ $article->draft_outline }}</textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold text-sm hover:bg-indigo-700 transition">Save Notes</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
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