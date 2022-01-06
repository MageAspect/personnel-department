@if ($paginator->hasPages())
    <div role="navigation" class="flex items-center justify-center">
        @if ($paginator->onFirstPage())
            <div class="p-2 text-gray-dark text-sm font-medium">
                <i class="fa-solid fa-angles-left"></i>
            </div>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="p-2 text-gray-lighter text-sm font-medium">
                <i class="fa-solid fa-angles-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="mx-1 text-sm font-medium p-2 px-3 text-gray-lighter bg-oceanic-light">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="mx-1 p-2 px-3 text-white bg-blue text-sm font-medium">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="mx-1 p-2 px-3 text-gray-lighter bg-oceanic-light text-sm font-medium">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="p-2 text-gray-lighter text-sm font-medium">
                <i class="fa-solid fa-angles-right"></i>
            </a>
        @else
            <div class="p-2 text-gray-dark text-sm font-medium">
                <i class="fa-solid fa-angles-right"></i>
            </div>
        @endif
    </div>
@endif
