<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendGridController extends Controller
{

    /**
     * Sendgrid send via API request.
     * @param $request is a POST request.
     * @return JSON boolean and status code.
     */
     public static function sendgrid_send_api(Request $request) {
       // Build the email array.
       $email = array(
         'from' => $request->input('email_from'),
         'to' => $request->input('email_to'),
         'subject' => filter_var($request->input('email_subject'), FILTER_SANITIZE_STRING),
         'body' => filter_var($request->input('email_body'), FILTER_SANITIZE_STRING),
       );

       $response = self::sendgrid_send($email);
       return response()->json($response, 200);
     }

    /**
     * Sendgrid send request.
     * @param array $data contains email parameters.
     * @return boolean
     */
    public static function sendgrid_send($data) {
      $success_status_code = array('202');

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom($data['from']);
      $email->setSubject($data['subject']);
      $email->addTo($data['to']);
      $email->addContent(
        "text/plain", $data['body']
      );

      // Init SendGrid class.
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
}
