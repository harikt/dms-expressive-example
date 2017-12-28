@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        @foreach($articles as $item)
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="{{ $serverUrlHelper->generate($urlHelper->generate('app::blog.view', [ 'slug' => $item->slug ])) }}">{{ $item->title }}</a></h2>
                <p class="blog-post-meta">{{ $item->date->format('F j, Y') }} by <a href="#">{{ $item->author->name }}</a></p>

                {!! $item->extract !!}
            </div>
        @endforeach
    </div>
@endsection
