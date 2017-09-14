<?php $content = $contentLoader->load('pages.home') ?>
<html>
<head>
    <title>{{ $content->getMetadata('title') }}</title>
    <meta name="description" content="{{ $content->getMetadata('title') }}">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <h1>{{ $content->getText('title') }}</h1>
</header>
<article>
    {!! $content->getHtml('content') !!}
</article>
<ul class="carousel">
    @foreach($content->getArrayOf('carousel-item') as $item)
        <li>
            <img src="{{ $item->hasImage('image') ? asset_file_url($item->getImage('image')) : 'http://placehold.it/500x500' }}" />
            <span>{{ $item->getText('caption') }}</span>
        </li>
    @endforeach
</ul>
</body>
</html>
