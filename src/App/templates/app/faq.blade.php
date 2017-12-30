@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        @foreach($faqs as $faq)
        <div>
            <strong>{{ $faq->question }}</strong>
            <div>{!! $faq->answer->asString() !!}</div>
        </div>
        @endforeach
    </div>
@endsection
