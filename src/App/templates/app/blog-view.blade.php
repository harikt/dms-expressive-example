@extends('layout::layout')

@section('content')

<style>

.titleBox {
    background-color:#fdfdfd;
    padding:10px;
}
.titleBox label{
  color:#444;
  margin:0;
  display:inline-block;
}

.commentBox {
    padding:10px;
    border-top:1px dotted #bbb;
}
.commentBox .form-group:first-child, .actionBox .form-group:first-child {
    width:80%;
}
.commentBox .form-group:nth-child(2), .actionBox .form-group:nth-child(2) {
    width:18%;
}
.actionBox .form-group * {
    width:100%;
}
.taskDescription {
    margin-top:10px 0;
}
.commentList {
    padding:0;
    list-style:none;
    max-height:200px;
    overflow:auto;
}
.commentList li {
    margin:0;
    margin-top:10px;
}
.commentList li > div {
    display:table-cell;
}
.commenterImage {
    width:30px;
    margin-right:5px;
    height:100%;
    float:left;
}
.commenterImage img {
    width:100%;
    border-radius:50%;
}
.commentText p {
    margin:0;
}
.sub-text {
    color:#aaa;
    font-family:verdana;
    font-size:11px;
}
.actionBox {
    border-top:1px dotted #bbb;
    padding:10px;
}
</style>

    <div class="container" style="margin-top: 100px;" >
        <div class="blog-post">
            <h2 class="blog-post-title">{{ $item->title }}</h2>
            <p class="blog-post-meta">{{ $item->date->format('F j, Y') }} by <a href="#">{{ $item->author->name }}</a></p>
            <div>
                <img src="{{ asset_file_url($item->featuredImage) }}" class="responsive pull-left" style="margin-right: 10px; margin-bottom: 10px" />
                {!! $item->articleContent->asString() !!}
            </div>
        </div>

        <div class="clearfix"></div>

        @if (count($item->comments) > 0)
            <ul class="media-list">
                @foreach($item->comments as $comment)
                    <li class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="https://www.gravatar.com/avatar/{{ md5($comment->authorEmail->asString()) }}" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $comment->authorName }} on {{ $comment->postedAt->format('jS F Y') }}</h4>
                            {{ $comment->content }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="comment">Comments</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="Comments"></textarea>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
@endsection
