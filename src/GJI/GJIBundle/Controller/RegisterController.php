<?php

namespace GJI\GJIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use GJI\GJIBundle\Entity\notification;
use GJI\GJIBundle\Entity\MemberGroup;
use GJI\GJIBundle\Entity\Groupe_User;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use GJI\GJIBundle\Controller\OTP\Twilio\Rest\Client;



class RegisterController extends Controller
{


   public function TwilioCallAction()
    {

        $nbrPhone = '+2120658744775 ';       
        $six_digit_random_number = mt_rand(10000, 99999);

        $account_sid = 'AC4a98ee0b371694bfcde05ea7470bebd7';
        $auth_token = 'f040e986a25d9ec78f1bd791dcfe265e';

        $twilio_number = "+12244343641";
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $nbrPhone,
            array(
                'from' => $twilio_number,
                'body' => 'Your code verification  '.$six_digit_random_number
            )
        );

        return new Response(1);
    }


   // public function TwilioCallAction()
   //  {

   //      $nbrPhone = '+212619360314';       
   //      $six_digit_random_number = mt_rand(10000, 99999);

   //      $account_sid = 'AC4a98ee0b371694bfcde05ea7470bebd7';
   //      $auth_token = 'f040e986a25d9ec78f1bd791dcfe265e';

   //      $twilio_number = "+12244343641";
   //      $client = new Client($account_sid, $auth_token);
   //      $client->messages->create(
   //          // Where to send a text message (your cell phone?)
   //          $nbrPhone,
   //          array(
   //              'from' => $twilio_number,
   //              'body' => 'Your code verification  '.$six_digit_random_number
   //          )
   //      );

   //      return new Response(1);
   //  }



   public function SendMsgAction(Request $request)
    {


        $nbrPhone = $request->get('tel');       
        // $nbrPhone = '+212658744775';       
        $six_digit_random_number = mt_rand(10000, 99999);

        $account_sid = 'AC4a98ee0b371694bfcde05ea7470bebd7';
        $auth_token = 'f040e986a25d9ec78f1bd791dcfe265e';

        $twilio_number = "+12244343641";
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $nbrPhone,
            array(
                'from' => $twilio_number,
                'body' => 'Your code verification  '.$six_digit_random_number
            )
        );


        return new Response($six_digit_random_number);

    }



    public function SignUpAction()
    {


        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');
            
        $em=$this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser(); 
        $tokenProvider = $this->get('security.csrf.token_manager');
        $token = $tokenProvider->getToken('example')->getValue();

        $datas=[];



        return $this->render('GJIBundle:SignUp:index.html.twig', array('datas' => $datas,'csrf'=>$token ));
    }




    public  function ifSessionExist()
    {
        $em=$this->getDoctrine()->getManager();
        $userAD=$this->container->get('security.token_storage')->getToken()->getUser(); 

        if(is_string ($userAD)){

            return 0;

        }else{

            return 1;
     
        }

        
    }



  public function SendInvitationAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        $nameUser = $request->get('nameUser');       
        $refgroup = $request->get('refgroup');       
        $nbrPhone = $request->get('tel');
        $countrys = $request->get('countrys');

        $nbrPhone =trim($nbrPhone);
        $countrys =trim($countrys);

        $telNbr='+'.$countrys.$nbrPhone;

        $UserByPhone = $em->getRepository('UserBundle:User')->findOneByusername($nbrPhone);

        if($UserByPhone){

          $Group = $em->getRepository('GJIBundle:Groupe')->findOneBy(array('refgroup' => $refgroup));
          $GroupId=$Group->getId();
          $UserP=$Group->getUser();
          $Title=$Group->getTitle();
          
          $msgB='your invited by '.$nameUser." to join group ".$Title;

          //=========create notification =============
          $dataa=date('Y-m-d H:i:s');


          $Groupe_User = new Groupe_User();

          $Groupe_User->setGroupe($Group);
          $dataa=date('Y-m-d H:i:s');

          $Groupe_User->setdateCreation(new \DateTime($dataa));
          $Groupe_User->setUser($UserByPhone);
          $Groupe_User->setUserP($Group->getUser());
          
          $em->persist($Groupe_User);       
          $em->flush();

          $notification= new notification();
          $notification->setdateCreation(new \DateTime($dataa));
          $notification->setUser($UserByPhone);
          $notification->setUserP($UserP);
          $notification->setidPostOrGroupOrComment($GroupId);
          $notification->setisread(0);
          $notification->setType(0);
          $notification->setGroupe($Group);

          $em->persist($notification);       
          $em->flush();


          $MemberGroup = new MemberGroup();
          
          $MemberGroup->setUser($UserByPhone);
          $MemberGroup->setGroupe($Group);
          $MemberGroup->setprevilige(2);
          $MemberGroup->setActive(1);
        
          $em->persist($MemberGroup);       
          $em->flush();



        }else{

          $msgB='your invited by '.$nameUser." to join go to this link :https://groupji.com/register?link=".$refgroup;

        }



        // $nbrPhone = '+212658744775';       
        $six_digit_random_number = mt_rand(10000, 99999);

        $account_sid = 'AC4a98ee0b371694bfcde05ea7470bebd7';
        $auth_token = 'f040e986a25d9ec78f1bd791dcfe265e';

        $twilio_number = "+12244343641";
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $telNbr,
            array(
                'from' => $twilio_number,
                'body' => $msgB
            )
        );


        return new Response(1);

    }



    public function SendByMailAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $to = $request->get('emailS');
        $code=0;

        $User = $em->getRepository('UserBundle:User')->findOneByEmail($to);
        if($User){


          $password=$User->getpassReserve();
          $subject = "Password compte GROUPJI";
          $txt = "Your recovred password is : ".$password;
          $headers = "From: GROUPJI" . "\r\n";
          $testMail=mail($to,$subject,$txt,$headers);
          $code=1;


        }

        return  new Response($code);


    }


    public function InviteByMailAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $to = $request->get('emailS');
        $code=0;
        $nameUser = $request->get('nameUser');       
        $refgroup = $request->get('refgroup');       
        $title = $request->get('title');       


          $Group = $em->getRepository('GJIBundle:Groupe')->findOneBy(array('refgroup' => $refgroup));
          $GroupId=$Group->getId();
          $UserP=$Group->getUser();
          $Title=$Group->getTitle();
          
          $msgB=' You are invited by '.$nameUser." to join group ".$Title;



          $msgg="Share Link :https://groupji.com/register?link=".$refgroup;
          $subject = "GROUPJI Invitation";

          $txt=$msgB.' : '.$msgg;
          $headers = "From: GROUPJI" . "\r\n";
          $testMail=mail($to,$subject,$txt,$headers);
          
          if($testMail)
            $code=1;

        

        return  new Response($code);


    }


    public function SendByOTPAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $code=0;

        $nbrPhonSearchBy = $request->get('nbrPhone');       
        $countrys = $request->get('countrys');       

        $nbrPhone= '+'.$countrys.$nbrPhonSearchBy;     
        // $nbrPhone = '+212658744775';

        $User = $em->getRepository('UserBundle:User')->findOneByusername($nbrPhonSearchBy);
        if($User){

          $password=$User->getpassReserve();

          $account_sid = 'AC4a98ee0b371694bfcde05ea7470bebd7';
          $auth_token = 'f040e986a25d9ec78f1bd791dcfe265e';

          $twilio_number = "+12244343641";
          $client = new Client($account_sid, $auth_token);
          $client->messages->create(
              // Where to send a text message (your cell phone?)
              $nbrPhone,
              array(
                  'from' => $twilio_number,
                  'body' => 'Your Password is :  '.$password
              )
          );

          $code=1;
        }
        
        return  new Response($code);

    }


}
