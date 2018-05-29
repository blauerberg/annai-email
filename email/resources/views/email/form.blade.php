<!DOCTYPE html>
 <html>
 	<head>
 		<meta charset="utf-8">
 		<meta http-equiv="X-UA-Compatible" content="IE=edge">
 		<title>Send Email - Annai Uber Code Challenge</title>
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
    @isset($send_error)
    <div class="section">
      <div class="container">
        <div class="notification">
          <div class="columns is-centered">
            <div class="column is-four-fifths">
              <h2 class="title is-2">We're sorry, there was an error sending your email</h2>
              <p>Please try again later.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endisset
    @if ($errors->any())
    <div class="section">
      <div class="container">
        <div class="notification">
          <div class="columns is-centered">
            <div class="column is-four-fifths">
              <ul>
                @foreach ($errors->all() as $error)
                  <li class="has-text-danger">{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="section">
      <div class="container">
        <form action="{{URL::to('/email')}}" method="post">
          <div class="columns is-centered">
            <div class="column is-four-fifths">
              <div class="field">
                <label for="email_from">Email From:<sup class="has-text-danger">*</sup></label>
                <div class="control">
                  <input type="email" class="input{{$errors->has('email_from') ? ' is-danger' :''}}" name="email_from" id="email_from" placeholder="from@email.com" value="{{$email_from}}"/>
                </div>
              </div>
              <div class="field">
                <label for="email_to">Email To:<sup class="has-text-danger">*</sup></label>
                <div class="control">
                  <input type="email" class="input{{$errors->has('email_to') ? ' is-danger' :''}}" name="email_to" id="email_to" placeholder="to@email.com" value="{{$email_to}}"/>
                </div>
              </div>
              <div class="field">
                <label for="email_subject">Email Subject:<sup class="has-text-danger">*</sup></label>
                <div class="control">
                  <input type="text" class="input{{$errors->has('email_subject') ? ' is-danger' :''}}" name="email_subject" id="email_subject" placeholder="Subject" value="{{$email_subject}}"/>
                </div>
              </div>
              <div class="field">
                <label for="email_body">Email Message:<sup class="has-text-danger">*</sup></label>
                <div class="control">
                  <textarea class="textarea{{$errors->has('email_body') ? ' is-danger' :''}}" name="email_body" id="email_body" rows="8" placeholder="Enter your email message.">{{$email_body}}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="columns is-centered">
            <div class="column is-four-fifths">
              {{csrf_field()}}
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link" name="email_submit">Send Email</button>
                </div>
              </div>
            </div>
          </div>
        </form>
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
