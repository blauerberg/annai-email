<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Log;

class EmailController extends Controller
{

  /**
   * Show the email form.
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
   */
  public function store(Request $request) {
    // Form validation.
    $validatedData = $request->validate([
      'email_from' => 'required|email',
      'email_to' => 'required|email',
      'email_subject' => 'required|max:255',
      'email_body' => 'required'
    ]);

    // Build email post request array and filter subject and body inputs.
    $email = array(
      'from' => $request->input('email_from'),
      'to' => $request->input('email_to'),
      'subject' => filter_var($request->input('email_subject'), FILTER_SANITIZE_STRING),
      'body' => filter_var($request->input('email_body'), FILTER_SANITIZE_STRING),
      'html_body' => nl2br($request->input('email_body'))
    );

    // Create send methods array.
    $send_methods = array('sendgrid_send', 'sparkpost_send');

    // Loop through send methods.
    foreach ($send_methods as $val) {
      $success = call_user_func(array($this, $val), $email);
      if ($success == true) {
        break;
      }
    }

    // Return success tpl on success or return form on failure.
    if ($success === true) {
      $request->session()->put('email', $email);
      return redirect('email/success');
    }
    else {
      return view('email.form', [
        'send_error' => 'error',
        'email_from' => $email['from'],
        'email_to' => $email['to'],
        'email_subject' => $email['subject'],
        'email_body' => $email['body'],
        'email_html_body' => $email['html_body']
      ]);
    }
  }

  /**
   * Application send request.
   */
   public function success() {
     $email = session('email');

     // Redirect user if session is empty.
     if ($email == null) {
       return redirect('email');
     }
     // Flush session.
     session()->forget('email');
     
     return view('email.success', [
       'email_from' => $email['from'],
       'email_to' => $email['to'],
       'email_subject' => $email['subject'],
       'email_body' => $email['body'],
       'email_html_body' => $email['html_body']
     ]);
   }

  /**
   * Sendgrid send request.
   */
  protected function sendgrid_send($data) {
    $success_status_code = array('202');

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom($data['from']);
    $email->setSubject($data['subject']);
    $email->addTo($data['to']);
    $email->addContent(
      "text/plain", $data['body']
    );
    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

    // Error handling.
    try {
      $response = $sendgrid->send($email);
      if (in_array($response->statusCode(), $success_status_code)) {
        return true;
      }
      else {
        // Log error and return false.
        Log::error('Error in function sendgrid_send(): ' . $response->statusCode());
        return false;
      }
    }
    catch (Exception $e) {
      // Log error and return false.
      Log::error('Error in function sendgrid_send(): ' . $e->getMessage());
      return false;
    }
  }

  /**
   * Sparkpost send request.
   */
  protected function sparkpost_send($data) {
    $success_status_code = array('200');

    $httpClient = new GuzzleAdapter(new Client());
    $sparky = new SparkPost($httpClient, ["key" => getenv('SPARKPOST_API_KEY')]);
    $promise = $sparky->transmissions->post([
      'content' => [
        'from' => [
          'name' => 'Paulkimphoto',
          'email' => $data['from'],
        ],
        'subject' => $data['subject'],
        'text' => $data['body'],
      ],
      'recipients' => [
        ['address' => ['email' => $data['to']]]
      ],
    ]);

    // Error handling.
    try {
      $response = $promise->wait();
      if (in_array($response->getStatusCode(), $success_status_code)) {
        return true;
      }
      else {
        // Log error and return false.
        Log::error('Error in function sparkpost_send(): ' . $response->getStatusCode());
        return false;
      }
    }
    catch (Exception $e) {
      // Log error and return false.
      Log::error('Error in function sparkpost_send(): ' . $e->getCode() . ' ' . $e->getMessage());
      return false;
    }
  }

}
