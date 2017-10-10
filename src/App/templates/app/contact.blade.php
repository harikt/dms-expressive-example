@extends('layout::layout')

@section('content')
    <div class="container">
    	<header>
    	    <h1>Contact</h1>
    	</header>
    	<form action="" method="post">
    	   <input type="hidden" name="_token" value="{!! csrf_token() !!}">

           <div class="form-group">
    	       <label>Your Name</label>
    	       <input type="text" class="form-control" required name="name">
    	   </div>
    	   <div class="form-group">
    	       <label>Email</label>
    	       <input type="email" class="form-control" required name="email">
    	   </div>
    	   <div class="form-group">
    	       <label>Subject</label>
    	       <input type="text" class="form-control" required name="subject">
    	   </div>
    	   <div class="form-group">
    	       <label>Your Message</label>
    	       <textarea name="message" class="form-control" required></textarea>
    	   </div>

    	   <button type="submit" class="btn btn-primary">Submit Enquiry</button>
    	</form>
    </div>
@endsection
