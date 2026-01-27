<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPage extends Component
{
    use WithPagination;
    public Category $category;
    public string $title;

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)->firstorFail();
        $this->title = $this->category->name;
    }


    public function render()
    {
        $articles = $this->category->articles()
            ->with('author')
            ->where('status', 'publish')
            ->latest()
            ->paginate(12);
        return view('livewire.category-page', [
            'articles' => $articles
        ]);
    }
}
