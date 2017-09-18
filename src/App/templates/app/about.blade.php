<?php $content = $contentLoader->load('pages.about') ?>
@extends('layout::layout')

@section('content')
    <div class="container">
        <h1>{{ $content->getText('title') }}</h1>
        <div class="row">{!! $content->getHtml('content') !!}</div>
    </div>
@endsection
