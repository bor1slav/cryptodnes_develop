@extends('administration::layouts.administration-master')
@section('content')
    @if (!empty($boxes))
        <div class="row">
            {!! $boxes !!}
        </div>
    @endif
    @if (!empty($form))
        <div class="row">
            @include('administration::boxes.form_fields')
        </div>
    @endif
    @if (!empty($table))
        <div class="row">
            @include('administration::boxes.data_table')
        </div>
    @endif

@endsection

