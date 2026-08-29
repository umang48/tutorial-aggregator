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
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-2">
                        <h2 class="text-xl font-bold">
                            <a href="{{ $article->url }}" target="_blank" class="hover:text-indigo-600 transition">{{ $article->title }}</a>
                        </h2>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2 py-1 rounded-full whitespace-nowrap">
                            💖 {{ $article->public_reactions_count }}
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">{{ Str::limit($article->description, 150) }}</p>
                    <div class="flex gap-2">
                        @foreach ($article->tags as $tag)
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">#{{ $tag }}</span>
                        @endforeach
                    </div>
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