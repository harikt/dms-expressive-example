@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        @foreach($articles as $item)
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="{{ $serverUrlHelper->generate($urlHelper->generate('app::blog.view', [ 'slug' => $item->slug ])) }}">{{ $item->title }}</a></h2>
                <p class="blog-post-meta">{{ $item->date->format('F j, Y') }} by <a href="#">{{ $item->author->name }}</a></p>
                <div>
                    <img src="{{ asset_file_url($item->featuredImage) }}" class="responsive pull-left" style="margin-right: 10px; margin-bottom: 10px; width: 140px; height: 140px;" />
                    {!! $item->extract !!}
                </div>
                <div class="clearfix"></div>
            </div>
        @endforeach
    </div>
    <nav aria-label="...">
        <ul class="pager">
            <li
                @if($previous < 1)
                    class="disabled"
                @endif
            ><a href="?page={{ $previous }}">Previous</a></li>
            <li
                @if($next * 10 > $total)
                    class="disabled"
                @endif
            ><a href="?page={{ $next }}">Next</a></li>
        </ul>
    </nav>
@endsection
