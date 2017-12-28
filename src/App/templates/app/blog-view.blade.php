@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        <div class="blog-post">
            <h2 class="blog-post-title">{{ $item->title }}</h2>
            <p class="blog-post-meta">{{ $item->date->format('F j, Y') }} by <a href="#">{{ $item->author->name }}</a></p>

            {!! $item->articleContent->asString() !!}
        </div>
    </div>
@endsection
