<div class="max-w-4xl mx-auto">
    <nav class="flex text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('category.show', $this->article->category->slug) }}"
            class="hover:text-indigo-600">{{ $this->article->category->name }}</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">{{ Str::limit($article->title, 20) }}</span>
    </nav>

    <header class="mb-8">
        <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>
        <div class="flex items-center space-x-4 text-gray-600">
            <div class="flex items-center">
                <span class="font-medium">{{ $article->author->name }}</span>
            </div>
            <span>&bull;</span>
            <time>{{ $article->created_at->format('d F Y, H:i') }}</time>
        </div>
    </header>

    <figure class="mb-10">
        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
            class="w-full h-auto rounded-xl shadow-lg">
    </figure>

    <article class="prose prose-lg prose-indigo max-w-none mb-10">
        {{-- Jika konten disimpan sebagai Markdown --}}
        {{-- {!! Str::markdown($article->content) !!} --}}

        {{-- Jika konten disimpan sebagai HTML (Rich Editor Filament) --}}
        {!! $article->content !!}
    </article>

    @if ($article->tags->count() > 0)
        <div class="border-t pt-6 mt-6">
            <h3 class="text-lg font-semibold mb-3">Tags:</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($article->tags as $tag)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif
</div>
