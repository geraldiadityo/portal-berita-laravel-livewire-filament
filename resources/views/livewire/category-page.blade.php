<div>
    {{-- Page Header --}}
    <div class="mb-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center text-sm text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Home
            </a>
            <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">{{ $category->name }}</span>
        </nav>

        {{-- Category Title --}}
        <div class="flex items-center gap-4">
            <div class="w-1.5 h-12 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full"></div>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-gray-600 mt-1">{{ $category->description }}</p>
                @endif
            </div>
        </div>

        {{-- Article Count --}}
        <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <span>{{ $articles->total() }} artikel ditemukan</span>
        </div>
    </div>

    {{-- Loading Skeleton --}}
    <div wire:loading.delay class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @for($i = 0; $i < 6; $i++)
            <div class="bg-white rounded-xl overflow-hidden shadow-md">
                <div class="skeleton h-48 w-full"></div>
                <div class="p-5 space-y-3">
                    <div class="skeleton h-4 w-1/3 rounded"></div>
                    <div class="skeleton h-6 w-full rounded"></div>
                    <div class="skeleton h-4 w-2/3 rounded"></div>
                </div>
            </div>
        @endfor
    </div>

    {{-- Articles Grid --}}
    <div wire:loading.remove>
        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <article class="bg-white rounded-xl overflow-hidden shadow-md card-hover group">
                        <a href="{{ route('article.show', $article->slug) }}" class="block">
                            <div class="relative overflow-hidden aspect-video bg-gray-100">
                                <img src="{{ Storage::url($article->featured_image) }}" 
                                     alt="{{ $article->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        </a>
                        <div class="p-5">
                            {{-- Date --}}
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $article->created_at->diffForHumans() }}</span>
                            </div>

                            {{-- Title --}}
                            <a href="{{ route('article.show', $article->slug) }}" class="block">
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors mb-2">
                                    {{ $article->title }}
                                </h3>
                            </a>

                            {{-- Excerpt --}}
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>

                            {{-- Author & Read More --}}
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($article->author->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $article->author->name }}</span>
                                </div>
                                <a href="{{ route('article.show', $article->slug) }}" 
                                   class="text-indigo-600 text-sm font-medium hover:text-indigo-800 transition-colors flex items-center gap-1">
                                    Baca
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $articles->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada artikel</h3>
                <p class="text-gray-600 mb-6">Kategori ini belum memiliki artikel yang dipublikasikan.</p>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Home
                </a>
            </div>
        @endif
    </div>
</div>
