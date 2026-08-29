<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class FetchTrendingTutorials implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $tags = ['php', 'react', 'python', 'javascript'];

        foreach ($tags as $tag) {
            $response = Http::get("https://dev.to/api/articles", [
                'tag' => $tag,
                'top' => 7,
                'per_page' => 5
            ]);

            if ($response->successful()) {
                $articles = $response->json();

                foreach ($articles as $articleData) {
                    Article::updateOrCreate(
                        ['devto_id' => $articleData['id']],
                        [
                            'title' => $articleData['title'],
                            'url' => $articleData['url'],
                            'description' => $articleData['description'],
                            'tags' => $articleData['tag_list'],
                            'public_reactions_count' => $articleData['public_reactions_count'],
                            'published_at' => date('Y-m-d H:i:s', strtotime($articleData['published_at'])),
                        ]
                    );
                }
            }
        }
    }
}