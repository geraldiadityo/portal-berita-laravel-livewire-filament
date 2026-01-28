<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    {{-- Main Content --}}
    <article class="lg:col-span-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center text-sm text-gray-500 mb-6 flex-wrap gap-1">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Home
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('category.show', $article->category->slug) }}" class="hover:text-indigo-600 transition-colors">
                {{ $article->category->name }}
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">{{ Str::limit($article->title, 30) }}</span>
        </nav>

        {{-- Category Badge --}}
        <div class="mb-4">
            <a href="{{ route('category.show', $article->category->slug) }}" 
               class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors">
                {{ $article->category->name }}
            </a>
        </div>

        {{-- Title --}}
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
            {{ $article->title }}
        </h1>

        {{-- Meta Info --}}
        <div class="flex items-center gap-4 text-gray-600 mb-8 flex-wrap">
            <time class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $article->created_at->format('d F Y, H:i') }}
            </time>
            <span class="w-1 h-1 rounded-full bg-gray-400"></span>
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                {{ number_format($article->views ?? 0) }} views
            </span>
        </div>

        {{-- Featured Image - Fixed Aspect Ratio (16:9) --}}
        <figure class="mb-10 rounded-2xl overflow-hidden shadow-xl">
            <div class="aspect-video bg-gray-100">
                <img src="{{ Storage::url($article->featured_image) }}" 
                     alt="{{ $article->title }}"
                     class="w-full h-full object-cover">
            </div>
        </figure>

        {{-- Article Content --}}
        <div class="prose prose-lg prose-indigo max-w-none mb-10
                    prose-headings:font-bold prose-headings:text-gray-900
                    prose-p:text-gray-700 prose-p:leading-relaxed
                    prose-a:text-indigo-600 prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-xl prose-img:shadow-lg
                    prose-blockquote:border-l-indigo-500 prose-blockquote:bg-indigo-50 prose-blockquote:py-1 prose-blockquote:px-4 prose-blockquote:rounded-r-lg">
            {!! $article->content !!}
        </div>

        {{-- Tags --}}
        @if ($article->tags->count() > 0)
            <div class="border-t border-gray-200 pt-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Tags
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($article->tags as $tag)
                        <span class="tag-pill inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition-colors cursor-pointer">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Author Box --}}
        <div class="bg-gradient-to-br from-slate-50 to-indigo-50 rounded-2xl p-6 mt-10 border border-slate-200">
            <div class="flex items-start gap-5">
                {{-- Author Avatar --}}
                <div class="shrink-0">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ strtoupper(substr($article->author->name, 0, 2)) }}
                    </div>
                </div>
                
                {{-- Author Info --}}
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Penulis</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $article->author->name }}</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        {{ $article->author->bio ?? 'Penulis dan kontributor di Portal Berita. Tertarik dengan berbagai topik dan selalu berusaha menyajikan informasi yang akurat dan bermanfaat.' }}
                    </p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $article->author->email }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Share Buttons --}}
        <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <span class="text-sm font-semibold text-gray-700">Bagikan:</span>
            <div class="flex gap-2">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('article.show', $article->slug)) }}&text={{ urlencode($article->title) }}" 
                   target="_blank"
                   class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center hover:opacity-80 transition-opacity">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('article.show', $article->slug)) }}" 
                   target="_blank"
                   class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:opacity-80 transition-opacity">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                </a>
                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . route('article.show', $article->slug)) }}" 
                   target="_blank"
                   class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:opacity-80 transition-opacity">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </a>
                <button onclick="navigator.clipboard.writeText('{{ route('article.show', $article->slug) }}')" 
                        class="w-10 h-10 rounded-full bg-gray-600 text-white flex items-center justify-center hover:bg-gray-700 transition-colors"
                        title="Copy link">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                    </svg>
                </button>
            </div>
        </div>
    </article>

    {{-- Sidebar - Related Articles --}}
    <aside class="lg:col-span-4">
        <div class="sticky top-24 space-y-6">
            {{-- Related Articles Widget --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Artikel Terkait
                </h3>

                @if($relatedArticles->count() > 0)
                    <div class="space-y-4">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('article.show', $related->slug) }}" class="group flex gap-4">
                                {{-- Thumbnail --}}
                                <div class="shrink-0 w-24 h-16 rounded-lg overflow-hidden bg-gray-100">
                                    <img src="{{ Storage::url($related->featured_image) }}" 
                                         alt="{{ $related->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $related->title }}
                                    </h4>
                                    <span class="text-xs text-gray-500 mt-1 inline-block">
                                        {{ $related->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </a>
                            @if(!$loop->last)
                                <hr class="border-gray-100">
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Tidak ada artikel terkait.</p>
                @endif
            </div>

            {{-- Category Widget --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Kategori
                </h3>
                <div class="space-y-2">
                    @foreach(\App\Models\Category::withCount(['articles' => fn($q) => $q->where('status', 'publish')])->get() as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" 
                           class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-indigo-50 transition-colors group {{ $cat->id == $article->category_id ? 'bg-indigo-50' : '' }}">
                            <span class="text-sm {{ $cat->id == $article->category_id ? 'text-indigo-700 font-semibold' : 'text-gray-700 group-hover:text-indigo-700' }}">
                                {{ $cat->name }}
                            </span>
                            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                                {{ $cat->articles_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Ad Placeholder --}}
            <div class="bg-gray-100 rounded-xl shadow-md p-6 text-center">
                <span class="text-gray-400 text-sm">Advertisement</span>
                <div class="h-64 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg mt-2">
                    <span class="text-gray-400 text-sm">300 x 250</span>
                </div>
            </div>
        </div>
    </aside>
</div>
