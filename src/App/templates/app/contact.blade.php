<html>
<head>
    <title>Contact title</title>
    <meta name="description" content="Meta title">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<header>
	    <h1>Contact</h1>
	</header>
	<form action="" method="post">
	   {!! csrf_field() !!}

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
</body>
</html>
