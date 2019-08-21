<div class="{{ $class }}">
    <div class="white-box" style="height: 164px">
        <div class="link-box-cont">
            <a href="{{$link}}">
                <div class="link-box-t">
                    <h3 class="box-title">{{ $title }}</h3>
                    <ul class="list-inline two-part">
                        <li><i class="fa {{ $icon }} {{ $color }}"></i></li>
                        <li class="text-right text-inverse"><span class="counter">{{ $value }}</span></li>

                    </ul>
                </div>

                <div class="link-box-link">
                    <h1 class="text-muted"><i class="fa fa-external-link"></i></h1>
                </div>

            </a>
        </div>
    </div>
</div>
