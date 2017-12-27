@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        @foreach($articles as $item)
            <h1><a href="{{ $serverUrlHelper->generate($urlHelper->generate('app::blog.view', [ 'slug' => $item->slug ])) }}">{{ $item->title }}</a></h1>
            {!! $item->extract !!}
        @endforeach
    </div>
@endsection
