<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public function render()
    {
        $article = Article::with(['category', 'user'])
            ->where('status', 'publish')
            ->latest()
            ->paginate(9);

        $headline = Article::with(['category', 'user'])
            ->where('status', 'publish')
            ->latest()
            ->first();

        return view('livewire.home', [
            'articles' => $article,
            'headline' => $headline
        ]);
    }
}
