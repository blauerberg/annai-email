<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Log;

class EmailController extends Controller
{

  /**
   * Show the email form.
   * @return Laravel view with input values for prefilling.
   */
  public function create() {
    return view('email.form', [
      'email_from' => 'paul@paulkimphoto.net',
      'email_to' => 'paul@paulkimphoto.net',
      'email_subject' => 'The Uber Code Challenge',
      'email_body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc cursus vitae orci eget auctor. Pellentesque consectetur lobortis nulla, vel dapibus odio. Vivamus eu ligula et arcu cursus pharetra at vitae velit. Fusce vestibulum diam turpis, iaculis volutpat erat sollicitudin volutpat. Sed vitae sapien vitae justo iaculis rhoncus. Cras placerat magna justo, et elementum quam auctor at. Donec eget nibh purus. Donec sit amet neque vitae magna accumsan iaculis. Curabitur mattis fringilla augue. Pellentesque sed tellus sapien. Duis convallis hendrerit turpis ac tempor. Praesent et nulla diam. Sed iaculis est nec faucibus euismod. Sed mattis ullamcorper arcu, nec commodo mi volutpat imperdiet. Nam sit amet eleifend sapien. Nulla aliquam gravida diam, et elementum erat varius et.',
    ]);
  }

  /**
   * Application send request.
   * @param $request is a post request
   * @return redirect user on success OR return form with error message and input values.
   */
  public function store(Request $request) {
    // Validate the form data. Failure automatically returns the view.
    $validated_data = $request->validate([
      'email_from' => 'required|email',
      'email_to' => 'required|email',
      'email_subject' => 'required|max:255',
      'email_body' => 'required'
    ]);

    // Build email post request array and filter subject and body inputs.
    $email_input = array(
      'from' => $request->input('email_from'),
      'to' => $request->input('email_to'),
      'subject' => filter_var($request->input('email_subject'), FILTER_SANITIZE_STRING),
      'body' => filter_var($request->input('email_body'), FILTER_SANITIZE_STRING),
      'html_body' => nl2br($request->input('email_body'))
    );

    // Set success flag to false.
    $success = false;

    // The commented code below provides working internal methods in case the API methods aren't desired.
    // Create send methods array.
    // $send_methods = array(
    //   array(__NAMESPACE__ .'\SendGridController', 'sendgrid_send'),
    //   array(__NAMESPACE__ .'\SparkPostController', 'sparkpost_send')
    // );
    //
    // // Attempt to send.
    // foreach ($send_methods as $method) {
    //   $success = call_user_func_array($method, array($email_input));
    //   if ($success === true) {
    //     break;
    //   }
    // }

    // Init the API method.
    $client = new Client();
    $api_methods = array(
      '/api/email/sendgrid/',
      '/api/email/sparkpost/'
    );

    // Loop through API methods. Exit when successful.
    foreach ($api_methods as $method) {
      $response = $client->request('POST', getenv('APP_URL') . $method, [
        'http_errors' => false,
        'form_params' => [
          'email_from' => $email_input['from'],
          'email_to' => $email_input['to'],
          'email_subject' => $email_input['subject'],
          'email_body' => $email_input['body']
        ]
      ]);
      $status = $response->getStatusCode();
      if ($status == 200) {
        $success = true;
        break;
      }
    }

    // Set session data and return success tpl on success or return form on failure.
    if ($success === true) {
      $request->session()->put('email_input', $email_input);
      return redirect('email/success');
    }
    else {
      return view('email.form', [
        'send_error' => 'error',
        'email_from' => $email_input['from'],
        'email_to' => $email_input['to'],
        'email_subject' => $email_input['subject'],
        'email_body' => $email_input['body'],
        'email_html_body' => $email_input['html_body']
      ]);
    }
  }

   /**
    * Application send request.
    * @return laravel email success view.
    */
   public function success() {
     // Call session data.
     $email_input = session('email_input');

     // Redirect user if session is empty.
     if ($email_input == null) {
       return redirect('email');
     }
     // Flush session.
     session()->forget('email');

     return view('email.success', [
       'email_from' => $email_input['from'],
       'email_to' => $email_input['to'],
       'email_subject' => $email_input['subject'],
       'email_body' => $email_input['body'],
       'email_html_body' => $email_input['html_body']
     ]);
   }
}
