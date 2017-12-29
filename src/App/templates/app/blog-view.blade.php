@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        <div class="blog-post">
            <h2 class="blog-post-title">{{ $item->title }}</h2>
            <p class="blog-post-meta">{{ $item->date->format('F j, Y') }} by <a href="#">{{ $item->author->name }}</a></p>
            <img src="{{ asset_file_url($item->featuredImage) }}" class="responsive" />
            {!! $item->articleContent->asString() !!}
        </div>
    </div>
@endsection
