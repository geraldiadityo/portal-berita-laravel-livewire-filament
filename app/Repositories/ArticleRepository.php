<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ArticleRepository
{
    const TTL = 3600;

    public function getHeadline()
    {
        return Cache::tags(['articles', 'home'])->remember('headlines', self::TTL, function () {
            return Article::with(['category', 'author'])
                ->where('status', 'publish')
                ->latest()
                ->first();
        });
    }

    public function getLatestPaginated(int $page, int $perPage = 9): LengthAwarePaginator
    {
        $key = "article_page_{$page}_perpage_{$perPage}";

        return Cache::tags(['artilces', 'home'])->remember($key, self::TTL, function () use ($perPage) {
            return Article::with(['category', 'author'])
                ->where('status', 'publish')
                ->latest()
                ->paginate($perPage);
        });
    }

    public function getBySlug(string $slug): Article
    {
        return Cache::tags(['articles', 'detail'])->remember("article_{$slug}", self::TTL, function () use ($slug) {
            return Article::with(['category', 'author', 'tags'])
                ->where('slug', $slug)
                ->where('status', 'publish')
                ->firstOrFail();
        });
    }
}
