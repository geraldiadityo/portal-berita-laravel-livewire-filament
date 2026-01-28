<?php

namespace App\Livewire;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public function render(ArticleRepository $repo)
    {
        return view('livewire.home', [
            'headline' => $repo->getHeadline(),
            'secondaryHeadlines' => $repo->getSecondaryHeadlines(),
            'breakingNews' => $repo->getBreakingNews(),
            'trendingArticles' => $repo->getTrending(),
            'popularTags' => $repo->getPopularTags(),
            'articles' => $repo->getLatestPaginated($this->getPage(), 6),
        ]);
    }
}
