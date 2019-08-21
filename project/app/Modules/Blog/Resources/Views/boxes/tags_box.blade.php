@foreach($articles as $article)
    <a class="article"
       href="{{ route('blog.view', ['article_slug' => $article->slug]) }}" title="{{ $article->title }}">
        <div class="contentLeft">
            <h4 class="title">{{ $article->title }}</h4>
            <div class="excerpt">
                {!!  strip_description($article->description, 200)  !!}
            </div>
            <span class="infoBox">
                    <span class="infoCol">
                    <span class="icon"><i class="far fa-calendar"></i></span>
                    {{ simple_uppercase_format($article->created_at) }}
                </span>
                <span class="infoCol">
                    <span class="icon"><i class="far fa-clock"></i></span>
                    <strong>{{$article->estimate_reading_time($article->description)}}. {{ trans('index::front.reading') }}</strong>
                </span>
            </span>
        </div>
        <div class="contentRight">
            <span class="imgContainer">
             @if (!empty($article->getFirstMedia()))
                    <span class="image"
                          style="background-image: url({{ $article->getFirstMedia()->getUrl('thumb') }});"></span>
                @else
                    <span class="image"
                          style="background-image: url({{ asset('images/pic_backup.jpg') }});"></span>
                @endif
            </span>
        </div>
    </a>
@endforeach