<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CategoryRepostitory
{
    const TTL = 86400;

    public function getAll()
    {
        return Cache::tags(['categories', 'global_ui'])->remember('all_categories', self::TTL, function () {
            return Category::all();
        });
    }

    public function getBySlug(string $slug): Category
    {
        return Cache::tags(['categories'])->remember("category_{$slug}", self::TTL, function () use ($slug) {
            return Category::where('slug', $slug)->firstOrFail();
        });
    }

    public function getArticleByCategory(Category $category, int $page, int $perPage = 12): LengthAwarePaginator
    {
        $key = "category_{$category->slug}_articles_page_{$page}";

        return Cache::tags(['articles', 'categories'])->remember($key, 3600, function () use ($category, $perPage) {
            return $category->articles()
                ->with('author')
                ->where('status', 'publish')
                ->latest()
                ->paginate($perPage);
        });
    }
}
