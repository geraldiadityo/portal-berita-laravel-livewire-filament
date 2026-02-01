<nav class="bg-white/95 glass border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-indigo-500/30 transition-shadow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </span>
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    Portal Berita
                </span>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    Home
                </a>
                @foreach (\App\Models\Category::all() as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('category/' . $category->slug) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            {{-- Search & Actions --}}
            <div class="flex items-center gap-3">
                {{-- Search Form --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    
                    {{-- Search Dropdown --}}
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-100 p-3 z-50">
                        <form action="{{ route('search') }}" method="GET">
                            <div class="relative">
                                <input type="text" 
                                       name="q" 
                                       placeholder="Cari berita..."
                                       class="w-full px-4 py-2.5 pl-10 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-sm"
                                       x-ref="searchInput"
                                       @keydown.enter="$el.form.submit()">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <button type="submit" class="w-full mt-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <button x-data x-on:click="$dispatch('toggle-mobile-menu')" 
                        class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div x-data="{ open: false }" 
             x-on:toggle-mobile-menu.window="open = !open"
             x-show="open" 
             x-collapse
             class="md:hidden pb-4">
            <div class="flex flex-col space-y-1 pt-2 border-t border-gray-100">
                <a href="{{ route('home') }}"
                    class="px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    Home
                </a>
                @foreach (\App\Models\Category::all() as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ request()->is('category/' . $category->slug) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>
