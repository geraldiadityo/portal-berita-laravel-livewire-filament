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
            'articles' => $repo->getLatestPaginated($this->getPage()),
            'headline' => $repo->getHeadline()
        ]);
    }
}
