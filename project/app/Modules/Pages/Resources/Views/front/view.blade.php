@extends('layouts.app')
@section('content')
    <section id="coins">
        <div class="container">
            <div class="page-view">
            <h1 style="font-size: 29px">
                {{ $page->title }}
            </h1>
            <div class="content">
                {!! $page->description !!}
            </div>
            </div>
        </div>
    </section>
@endsection