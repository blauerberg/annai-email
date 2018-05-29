<!DOCTYPE html>
 <html>
 	<head>
 		<meta charset="utf-8">
 		<meta http-equiv="X-UA-Compatible" content="IE=edge">
 		<title>Email Success - Annai Uber Code Challenge</title>
 		<meta name="description" content=" " />
 		<meta name="author" content=" " />
 		<meta name="HandheldFriendly" content="true" />
 		<meta name="MobileOptimized" content="320" />
 		<!-- Use maximum-scale and user-scalable at your own risk. It disables pinch/zoom. Think about usability/accessibility before including.-->
 		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
 		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
 		<link rel="stylesheet" type="text/css" href="{{ asset('css/bulma.css') }}">
 	</head>
 	<body>
    <div class="section">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-four-fifths">
            <h1 class="title is-1 has-text-centered">Annai Uber Code Challenge</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-four-fifths">
            <h2 class="title is-2">Thank you for your email.</h2>
            <strong>From:</strong><br/>
            {{$email_from}}
          </div>
        </div>
        <div class="columns is-centered">
          <div class="column is-four-fifths">
            <strong>To:</strong><br/>
            {{$email_to}}
          </div>
        </div>
        <div class="columns is-centered">
          <div class="column is-four-fifths">
            <strong>Subject:</strong></br>
            {{$email_subject}}
          </div>
        </div>
        <div class="columns is-centered">
          <div class="column is-four-fifths">
            <strong>Message</strong><br/>
            {{$email_body}}
          </div>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-four-fifths">
            <p class="is-size-7">Here's the terms and conditions text for using this email sending application. Use at your own risk!</p>
          </div>
        </div>
      </div>
    </div>
 	<script type="text/javascript" src=" "></script>
 	</body>
 </html>
