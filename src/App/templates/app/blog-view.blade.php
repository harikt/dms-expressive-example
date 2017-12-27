@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        <h1>{{ $article->title }}</h1>
        {!! $article->articleContent->asString() !!}
    </div>
@endsection
