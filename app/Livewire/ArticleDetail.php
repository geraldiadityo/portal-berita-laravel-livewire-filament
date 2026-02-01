<?php

namespace App\Livewire;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

use function Pest\Laravel\session;

class ArticleDetail extends Component
{
    public Article $article;
    public string $title;

    public function mount($slug, ArticleRepository $repo)
    {
        $this->article = $repo->getBySlug($slug);
        $this->title = $this->article->title;
        $sessionKey = 'viewed_article_' . $this->article->id;

        if (!Session::has($sessionKey)) {
            $this->article->increment('views');
            Cache::tags(['home'])->flush();
            Session::put($sessionKey, time());
        }
    }

    public function render(ArticleRepository $repo)
    {
        return view('livewire.article-detail', [
            'relatedArticles' => $repo->getRelatedArticles($this->article, 5)
        ]);
    }
}
