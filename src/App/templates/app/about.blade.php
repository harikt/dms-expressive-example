<?php $content = $contentLoader->load('pages.about') ?>
@extends('layout::layout')

@section('content')
    <div class="container" style="margin-top: 100px;" >
        <h1>{{ $content->getText('title') }}</h1>
        <div class="col-12">{!! $content->getHtml('content') !!}</div>
    </div>
@endsection
