<?php

namespace GJI\GJIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use GJI\GJIBundle\Controller\OTP\Twilio\Rest\Client;



class TwilioController extends Controller
{


   public function TwilioCallAction()
    {

        $account_sid = 'ACc3e4428795322d4fd9150e95f4abe2bb';
        $auth_token = '105004f62e7fe1235de44e37f4e8fec8';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]
        // A Twilio number you own with SMS capabilities
        $twilio_number = "+12817139429";
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            '+212658744775',
            array(
                'from' => $twilio_number,
                'body' => 'AZE1111'
            )
        );


        return new Response(1);
    }



}
