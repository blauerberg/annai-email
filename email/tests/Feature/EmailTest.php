<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\SendGridController;
use App\Http\Controllers\SparkPostController;
use App\Http\Controllers\EmailController;

class EmailTest extends TestCase
{
    /** Test Sendgrid send ability
     *  - Populate some test email data.
     *  - Call the sendgrid_send method
     *  - Check that we get a true return value
     *  @test
     */
    public function sendgrid_can_send() {
      $controller = new SendGridController();
      $response = $controller->sendgrid_send(array(
        'from' => 'paul@paulkimphoto.net',
        'to' => 'paul@paulkimphoto.net',
        'subject' => 'PHP Unit Test Subject',
        'body' => 'PHP Unit Test Body'
      ));
      $this->assertEquals(true, $response);
    }


    /** Test Sparkpost send ability
     *  - Populate some test email data.
     *  - Call the sparkpost_send method
     *  - Check that we get a true return value
     *  @test
     */
    public function sparkpost_can_send() {
      $controller = new SparkPostController();
      $response = $controller->sparkpost_send(array(
        'from' => 'paul@paulkimphoto.net',
        'to' => 'paul@paulkimphoto.net',
        'subject' => 'PHP Unit Test Subject',
        'body' => 'PHP Unit Test Body'
      ));
      $this->assertEquals(true, $response);
    }
}
