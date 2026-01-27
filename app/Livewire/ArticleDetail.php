<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleDetail extends Component
{
    public Article $article;
    public string $title;

    public function mount($slug)
    {
        $this->article = Article::with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        $this->title = $this->article->title;
    }


    public function render()
    {
        return view('livewire.article-detail');
    }
}
