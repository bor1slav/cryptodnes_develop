
@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    {{--&lsaquo;--}}
                    <i class="fas fa-long-arrow-alt-left"></i>
                    Предишните 100
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        {{--@foreach ($elements as $element)
            --}}{{-- "Three Dots" Separator --}}{{--
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            --}}{{-- Array Of Links --}}{{--
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach--}}

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    {{--&rsaquo;--}}
                    Следващите 100
                    <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </li>
        @endif

{{--        @if (!$paginator->onFirstPage())--}}
{{--            <li class="page-item">--}}
{{--                <a class="page-link" href="{{ route('coins.index') }}" title="@lang('pagination.next')">--}}
{{--                    View All--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endif--}}
    </ul>
@endif
