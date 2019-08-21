@extends('layouts.app')
@section('content')
    <section class="get-in-touch">
        <h1 class="title">Свържи се с нас</h1>
        <span class="grayLineS"></span>
        <span class="col-md-12 subtitle">Не се колебайте да се свържете с нас, а ние ще ви отговорим в рамките на 24 часа.</span>
        @if (!empty($errors))
            @foreach ($errors->all() as $error)
                <div class="alert alert-dark" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        @if (Session::has('success'))
            @foreach (Session::get('success') as $success)
                <div class="alert alert-success" role="alert">
                    {{ $success }}
                </div>
            @endforeach
        @endif
        <form method="post" action="{{ route('contacts.store') }}" class="contact-form row">
            {{ csrf_field() }}
            <div class="form-field col-md-6">
                <input id="first_name" class="input-text js-input" name="first_name" type="text" required>
                <label class="label" for="first_name">Име</label>
            </div>
            <div class="form-field col-md-6">
                <input id="last_name" name="last_name" class="input-text js-input" type="text" required>
                <label class="label" for="name">Фамилия</label>
            </div>
            <div class="form-field col-md-6">
                <input id="email" name="email" class="input-text js-input" type="email" required>
                <label class="label" for="email">Имейл</label>
            </div>
            <div class="form-field col-md-6">
                <input id="phone" name="phone" class="input-text js-input" type="phone" required>
                <label class="label" for="phone">Телефон</label>
            </div>
            <div class="form-field col-md-12">
                <textarea id="message" name="message" class="input-text js-input textarea-input" type="text"
                          required></textarea>
                <label class="label textarea-label" for="message">Съобщение</label>
            </div>
{{--            @if ( !empty($_COOKIE['darkTheme']) && $_COOKIE['darkTheme'] == 'true' )--}}
{{--                <div class="form-field col-md-6" style="margin: 0 auto;">--}}
{{--                    {!! NoCaptcha::display(['data-theme' => 'dark', 'style' => 'margin: 0 auto;']) !!}--}}
{{--                </div>--}}
{{--            @else--}}
{{--                <div class="form-field col-md-6" style="margin: 0 auto;">--}}
{{--                    {!! NoCaptcha::display(['data-theme' => 'light', 'style' => 'margin: 0 auto;', 'required']) !!}--}}
{{--                </div>--}}
{{--            @endif--}}
            <div class="form-field col-md-12 align-center">
                <input class="submit-btn" type="submit" value="Изпрати">
            </div>

        </form>
    </section>
@endsection

@section('js')
    <script>
        $('.js-input').keyup(function () {
            if ($(this).val()) {
                $(this).addClass('not-empty');
            } else {
                $(this).removeClass('not-empty');
            }
        });
    </script>
@endsection