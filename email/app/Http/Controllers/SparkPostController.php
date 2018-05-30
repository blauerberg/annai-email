<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class SparkPostController extends Controller
{

  /**
   * Sparkpost send via API request.
   */
   public static function sparkpost_send_api(Request $request) {
     $email = array(
       'from' => $request->input('email_from'),
       'to' => $request->input('email_to'),
       'subject' => filter_var($request->input('email_subject'), FILTER_SANITIZE_STRING),
       'body' => filter_var($request->input('email_body'), FILTER_SANITIZE_STRING),
     );

     $response = self::sparkpost_send($email);
     return response()->json($response, 200);
   }

  /**
   * Sparkpost send request.
   */
  public static function sparkpost_send($data) {
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
