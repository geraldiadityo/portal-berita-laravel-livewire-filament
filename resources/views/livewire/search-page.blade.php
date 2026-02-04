<div class="space-y-8">
    {{-- Search Header --}}
    <div class="text-center py-8 bg-linear-to-br from-indigo-50 to-purple-50 rounded-2xl">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Cari Berita</h1>
        <div class="max-w-xl mx-auto px-4">
            <div class="relative">
                <input type="text" wire:model.live.debounce.500ms="query"
                    placeholder="Ketik kata kunci untuk mencari..."
                    class="w-full px-5 py-4 pl-12 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-900 placeholder-gray-400 shadow-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <div wire:loading class="absolute right-4 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-indigo-500 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Results --}}
    <div class="container mx-auto px-4">
        @if (strlen($query) < 2)
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-gray-500">Ketik minimal 2 karakter untuk mulai mencari</p>
            </div>
        @elseif($articles instanceof \Illuminate\Pagination\LengthAwarePaginator && $articles->count() > 0)
            <div class="mb-4">
                <p class="text-gray-600">
                    Ditemukan <span class="font-semibold text-indigo-600">{{ $articles->total() }}</span> hasil untuk
                    "<span class="font-semibold">{{ $query }}</span>"
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($articles as $article)
                    <article
                        class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow group">
                        <a href="{{ route('article.show', $article->slug) }}" class="block">
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-5">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 mb-2">
                                    {{ $article->category->name ?? 'Uncategorized' }}
                                </span>
                                <h3
                                    class="text-lg font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors mb-2">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                </p>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span>{{ $article->author->name ?? 'Unknown' }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-400"></span>
                                    <span>{{ $article->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500 text-lg">Tidak ada hasil untuk "<span
                        class="font-semibold">{{ $query }}</span>"</p>
                <p class="text-gray-400 text-sm mt-1">Coba kata kunci lain</p>
            </div>
        @endif
    </div>
</div>
