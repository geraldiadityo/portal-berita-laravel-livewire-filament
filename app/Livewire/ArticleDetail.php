<?php

namespace App\Livewire;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Livewire\Component;

class ArticleDetail extends Component
{
    public Article $article;
    public string $title;

    public function mount($slug, ArticleRepository $repo)
    {
        $this->article = $repo->getBySlug($slug);
        $this->title = $this->article->title;
    }


    public function render()
    {
        return view('livewire.article-detail');
    }
}
