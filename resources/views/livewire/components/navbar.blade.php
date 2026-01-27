{{-- <div>

</div> --}}

<nav class="bg-white border-b shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                Portal Berita
            </a>
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-indigo-600 {{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : '' }}">
                    Home
                </a>
                @foreach (\App\Models\Category::all() as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="text-gray-700 hover:text-indigo-600 {{ request()->is('category/' . $category->slug) ? 'text-indigo-600 font-semibold' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="md:hidden">
                <button class="text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
