<a class="m-l-10 m-r-10 action-btn" href="{{ $link }}" @if (!empty($attr['title'])) title="{{ $attr['title'] }}" @endif>
    <i class="fa  @if (!empty($attr['icon'])) {{$attr['icon']}} @endif @if (!empty($attr['color'])) {{$attr['color']}} @endif"></i>
</a>