<div class="space-y-8">
    {{-- Breaking News Ticker --}}
    @if($breakingNews->count() > 0)
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg overflow-hidden">
        <div class="flex items-center">
            <div class="bg-white/20 px-4 py-3 flex items-center gap-2 shrink-0">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
                <span class="text-white font-bold text-sm uppercase tracking-wider">Breaking</span>
            </div>
            <div class="ticker-wrapper flex-1 py-3 px-4">
                <div class="ticker-content gap-8">
                    @foreach($breakingNews as $news)
                        <a href="{{ route('article.show', $news->slug) }}" 
                           class="text-white hover:text-indigo-200 transition-colors inline-flex items-center gap-2 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-white/60"></span>
                            {{ $news->title }}
                        </a>
                    @endforeach
                    {{-- Duplicate for seamless loop --}}
                    @foreach($breakingNews as $news)
                        <a href="{{ route('article.show', $news->slug) }}" 
                           class="text-white hover:text-indigo-200 transition-colors inline-flex items-center gap-2 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-white/60"></span>
                            {{ $news->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Hero Section: Main Headline + Secondary Headlines --}}
    @if($headline)
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Main Headline (Large Card) --}}
        <div class="lg:col-span-8">
            <a href="{{ route('article.show', $headline->slug) }}" 
               class="group block relative rounded-2xl overflow-hidden shadow-xl h-[450px] card-hover">
                <img src="{{ Storage::url($headline->featured_image) }}" 
                     alt="{{ $headline->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 gradient-overlay"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500 text-white mb-4">
                        {{ $headline->category->name }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-3 line-clamp-2 group-hover:text-indigo-200 transition-colors">
                        {{ $headline->title }}
                    </h1>
                    <p class="text-gray-200 line-clamp-2 text-lg mb-4">
                        {{ Str::limit(strip_tags($headline->content), 150) }}
                    </p>
                    <div class="flex items-center gap-4 text-sm text-gray-300">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-indigo-400 flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($headline->author->name, 0, 1) }}
                            </div>
                            <span>{{ $headline->author->name }}</span>
                        </div>
                        <span class="w-1 h-1 rounded-full bg-gray-400"></span>
                        <span>{{ $headline->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Secondary Headlines (3 Small Cards) --}}
        <div class="lg:col-span-4 flex flex-col gap-4">
            @foreach($secondaryHeadlines as $article)
            <a href="{{ route('article.show', $article->slug) }}" 
               class="group relative rounded-xl overflow-hidden shadow-lg flex-1 min-h-[130px] card-hover">
                <img src="{{ Storage::url($article->featured_image) }}" 
                     alt="{{ $article->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 gradient-overlay"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-500/80 text-white mb-2">
                        {{ $article->category->name }}
                    </span>
                    <h3 class="text-white font-semibold line-clamp-2 group-hover:text-indigo-200 transition-colors">
                        {{ $article->title }}
                    </h3>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Main Content + Sidebar --}}
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Latest Articles (Main Content) --}}
        <div class="lg:col-span-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="w-1 h-8 bg-indigo-600 rounded-full"></span>
                    Berita Terbaru
                </h2>
            </div>

            {{-- Loading Skeleton --}}
            <div wire:loading.delay class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @for($i = 0; $i < 4; $i++)
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
            <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($articles as $article)
                    @if($loop->iteration <= 4 && $articles->currentPage() == 1)
                        @continue
                    @endif
                    <article class="bg-white rounded-xl overflow-hidden shadow-md card-hover group">
                        <a href="{{ route('article.show', $article->slug) }}" class="block">
                            <div class="relative overflow-hidden h-48">
                                <img src="{{ Storage::url($article->featured_image) }}" 
                                     alt="{{ $article->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-600 text-white shadow-lg">
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $article->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('article.show', $article->slug) }}" class="block">
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors mb-2">
                                    {{ $article->title }}
                                </h3>
                            </a>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
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
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">
                {{-- Trending Articles Widget --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.66 11.2c-.23-.3-.51-.56-.77-.82-.67-.6-1.43-1.03-2.07-1.66C13.33 7.26 13 4.85 13.95 3c-.95.23-1.78.75-2.49 1.32-2.59 2.08-3.61 5.75-2.39 8.9.04.1.08.2.08.33 0 .22-.15.42-.35.5-.23.1-.47.04-.66-.12a.58.58 0 01-.14-.17c-1.13-1.43-1.31-3.48-.55-5.12C5.78 10 4.87 12.3 5 14.47c.06.5.12 1 .29 1.5.14.6.41 1.2.71 1.73 1.08 1.73 2.95 2.97 4.96 3.22 2.14.27 4.43-.12 6.07-1.6 1.83-1.66 2.47-4.32 1.53-6.6l-.13-.26c-.21-.46-.77-1.26-.77-1.26zm-3.16 6.3c-.28.24-.74.5-1.1.6-1.12.4-2.24-.16-2.9-.82 1.19-.28 1.9-1.16 2.11-2.05.17-.8-.15-1.46-.28-2.23-.12-.74-.1-1.37.17-2.06.19.38.39.76.63 1.06.77 1 1.98 1.44 2.24 2.8.04.14.06.28.06.43.03.82-.33 1.72-.93 2.27z"/>
                        </svg>
                        Trending
                    </h3>
                    <div class="space-y-4">
                        @foreach($trendingArticles as $index => $trending)
                        <a href="{{ route('article.show', $trending->slug) }}" 
                           class="flex items-start gap-4 group">
                            <span class="text-3xl font-bold {{ $index < 3 ? 'text-indigo-600' : 'text-gray-300' }}">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $trending->title }}
                                </h4>
                                <span class="text-xs text-gray-500 mt-1 inline-block">
                                    {{ $trending->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>
                        </a>
                        @if(!$loop->last)
                        <hr class="border-gray-100">
                        @endif
                        @endforeach
                    </div>
                </div>

                {{-- Tags Widget --}}
                @if($popularTags->count() > 0)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Explore Tags
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularTags as $tag)
                        <span class="tag-pill inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 cursor-pointer transition-colors">
                            #{{ $tag->name }}
                            <span class="ml-1.5 text-xs text-gray-400">({{ $tag->articles_count }})</span>
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Newsletter Widget --}}
                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-md p-6 text-white">
                    <h3 class="text-lg font-bold mb-2">Newsletter</h3>
                    <p class="text-indigo-100 text-sm mb-4">
                        Dapatkan berita terbaru langsung di inbox Anda
                    </p>
                    <form class="space-y-3">
                        <input type="email" 
                               placeholder="Email address" 
                               class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white/50 text-sm">
                        <button type="button" 
                                class="w-full px-4 py-3 rounded-lg bg-white text-indigo-600 font-semibold hover:bg-indigo-50 transition-colors text-sm">
                            Subscribe
                        </button>
                    </form>
                </div>

                {{-- Ad Placeholder --}}
                <div class="bg-gray-100 rounded-xl shadow-md p-6 text-center">
                    <span class="text-gray-400 text-sm">Advertisement</span>
                    <div class="h-48 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg mt-2">
                        <span class="text-gray-400 text-sm">300 x 250</span>
                    </div>
                </div>
            </div>
        </aside>
    </section>
</div>
