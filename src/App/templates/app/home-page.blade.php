<?php $content = $contentLoader->load('pages.home') ?>
@extends('layout::layout')

@section('content')

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @foreach($content->getArrayOf('carousel-item') as $key => $item)
          <li data-target="#myCarousel" data-slide-to="{{ $key }}" @if ($key == 0) class="active" @endif ></li>
        @endforeach
      </ol>
      <div class="carousel-inner" role="listbox">
        @foreach($content->getArrayOf('carousel-item') as $key => $item)
            <div class="item @if ($key == 0) active @endif" >
              <img class="{{ $key }}" src="{{ $item->hasImage('image') ? asset_file_url($item->getImage('image')) : 'http://placehold.it/500x500' }}" alt="{{ $item->getImageAltText('image') }}">
              <div class="container">
                <div class="carousel-caption">
                  <h1>{{ $item->getText('caption') }}.</h1>
                  <p><a class="btn btn-lg btn-primary" href="/dms" role="button">Go to admin</a></p>
                </div>
              </div>
            </div>
        @endforeach
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">{!! $content->getText('heading1') !!}</h2>
          {!! $content->getHtml('content1') !!}
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="{{ asset_file_url($content->getImage('image1')) }}" alt="{{ $content->getText('caption1') }}">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
          <h2 class="featurette-heading">{!! $content->getText('heading2') !!}</span></h2>
          <p class="lead">{!! $content->getHtml('content2') !!}</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
          <img class="featurette-image img-responsive center-block" src="{{ asset_file_url($content->getImage('image2')) }}" alt="{{ $content->getText('caption2') }}">
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2016 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>

    </div><!-- /.container -->

@endsection
