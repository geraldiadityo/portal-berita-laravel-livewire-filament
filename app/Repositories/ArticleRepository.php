<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Get breaking news articles for ticker
     */
    public function getBreakingNews(int $limit = 5): Collection
    {
        return Cache::tags(['articles', 'home'])->remember("breaking_news_{$limit}", self::TTL, function () use ($limit) {
            return Article::select(['id', 'title', 'slug'])
                ->where('status', 'publish')
                ->latest()
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get trending/popular articles based on views
     */
    public function getTrending(int $limit = 5): Collection
    {
        return Cache::tags(['articles', 'home'])->remember("trending_{$limit}", self::TTL, function () use ($limit) {
            return Article::with(['category'])
                ->where('status', 'publish')
                ->orderByDesc('views')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get secondary headlines for hero grid (excluding the main headline)
     */
    public function getSecondaryHeadlines(int $limit = 3): Collection
    {
        return Cache::tags(['articles', 'home'])->remember("secondary_headlines_{$limit}", self::TTL, function () use ($limit) {
            return Article::with(['category', 'author'])
                ->where('status', 'publish')
                ->latest()
                ->skip(1)
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get popular tags with article count
     */
    public function getPopularTags(int $limit = 10): Collection
    {
        return Cache::tags(['tags', 'home'])->remember("popular_tags_{$limit}", self::TTL, function () use ($limit) {
            return Tag::withCount(['articles' => function ($query) {
                $query->where('status', 'publish');
            }])
                ->having('articles_count', '>', 0)
                ->orderByDesc('articles_count')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get related articles from the same category
     */
    public function getRelatedArticles(Article $article, int $limit = 5): Collection
    {
        $key = "related_articles_{$article->id}_{$limit}";
        
        return Cache::tags(['articles', 'detail'])->remember($key, self::TTL, function () use ($article, $limit) {
            return Article::with(['category', 'author'])
                ->where('category_id', $article->category_id)
                ->where('id', '!=', $article->id)
                ->where('status', 'publish')
                ->latest()
                ->limit($limit)
                ->get();
        });
    }
}
