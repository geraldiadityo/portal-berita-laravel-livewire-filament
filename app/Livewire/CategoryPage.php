<?php

namespace App\Livewire;

use App\Models\Category;
use App\Repositories\CategoryRepostitory;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPage extends Component
{
    use WithPagination;
    public Category $category;
    public string $title;

    public function mount($slug, CategoryRepostitory $repo)
    {
        $this->category = $repo->getBySlug($slug);
        $this->title = $this->category->name;
    }


    public function render(CategoryRepostitory $repo)
    {
        $articles = $repo->getArticleByCategory($this->category, $this->getPage());
        return view('livewire.category-page', [
            'articles' => $articles
        ]);
    }
}
