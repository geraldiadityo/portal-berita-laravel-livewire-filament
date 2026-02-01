<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class SearchPage extends Component
{
    use WithPagination;

    public string $query = '';

    protected $queryString = [
        'query' => ['except' => '', 'as' => 'q']
    ];

    public function mount()
    {
        $this->query = request()->query('q', '');
    }

    public function updatedQuery()
    {
        $this->resetPage();
    }

    public function render()
    {
        $articles = collect();

        if (strlen($this->query) >= 2) {
            $articles = Article::query()
                ->where('status', 'published')
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->query . '%')
                      ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->with(['category', 'author'])
                ->latest()
                ->paginate(9);
        }

        return view('livewire.search-page', [
            'articles' => $articles,
        ]);
    }
}
