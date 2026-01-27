<div>
    @if ($headline)
        <section class="mb-12">
            <div class="relative rounded-xl overflow-hidden shadow-lg group cursor-pointer"
                onclick="window.location='{{ route('article.show', $headline->slug) }}'">
                <img src="{{ Storage::url($headline->image) }}" alt="{{ $headline->title }}"
                    class="w-full h-96 object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-linear-to-t from-black/80 to-transparent flex items-end p-8">
                    <div class="text-white">
                        <span class="bg-indigo-600 text-xs px-2 py-1 rounded uppercase tracking-wider mb-2 inline-block">
                            {{ $headline->category->name }}
                        </span>
                        <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $headline->title }}</h1>
                        <p class="text-gray-200 line-clamp-2">{{ Str::limit(strip_tags($headline->content), 150) }}</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section>
        <h2 class="text-2xl font-bold mb-6 border-l-4 border-indigo-600 pl-4">Berita Terbaru</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($articles as $article)
                @if ($loop->first && $articles->currentPage() == 1)
                    @continue
                @endif

                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
                    <a href="{{ route('article.show', $article->slug) }}">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                            class="w-full h-48 object-cover" />
                    </a>
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center text-xs text-gray-500 mb-2 space-x-2">
                            <span class="text-indigo-600 font-semibold">{{ $article->category->name }}</span>
                            <span>&bull;</span>
                            <span>{{ $article->created_at->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('article.show', $article->slug) }}" class="block mt-1">
                            <h3 class="text-xl font-semibold text-gray-900 line-clamp-2 hover:text-indigo-600">
                                {{ $article->title }}
                            </h3>
                        </a>
                        <p class="mt-2 text-gray-600 text-sm line-clamp-3 grow">
                            {{ Str::limit(strip_tags($article->content), 100) }}
                        </p>
                        <div class="mt-4 flex items-center">
                            <div class="shrink-0">
                                <span class="sr-only">{{ $article->author->name }}</span>
                                <div
                                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ substr($article->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $article->author->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    </section>
</div>
