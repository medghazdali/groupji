<?php

namespace GJI\GJIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use GJI\GJIBundle\Entity\Groupe;
use User\UserBundle\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;

class MainController extends Controller
{


    public function indexAction()
    {

        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');


        $em=$this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser(); 

        $setParameter = [];
        $setParameter['user'] = $user->getid();

        $QB = $em->createQueryBuilder();
        $QB->select('gu');
        $QB->from('GJIBundle:Groupe_User', 'gu');
        $QB->innerJoin('gu.Groupe', 'g');
        $QB->innerJoin('gu.User', 'u');
        $QB->innerJoin('gu.UserP', 'up');
        $QB->where('u.id=:user');
        $QB->orwhere('up.id=:user');
        $QB->orderBy('gu.id', 'DESC');
        $QB->groupBy('g.id');

        $QB->setParameters($setParameter);
        $Q = $QB->getQuery();
        $List = $Q->execute();

        $datas=[];

        foreach ($List as $value) {

            $data=[];

            $groupe =$value->getGroupe();
            $User =$value->getUser();
            $userParticipant=$value->getUserP();

            $id=$groupe->getid();
            $title=$groupe->gettitle();
            $enabled=$groupe->getenabled();
            $body=$groupe->getbody();
            $Cat=$groupe->getCat()->getcategorie();
            $dateCreation=$groupe->getdateCreation()->format('d-m-Y H:i:s');           
            $file=$groupe->getpath();
            $UserName =$User->getusername();

            $membergroup=$em->getRepository('GJIBundle:MemberGroup')->findOneBy(array('Groupe'=>$groupe,'User'=>$User));
            $previlige= $membergroup->getprevilige();


            $myGroupe=0;
            if($userParticipant->getid()==$User->getid())
                $myGroupe=1;

            $UserName =$User->getusername();
            $UserId =$User->getid();

            $data['id']=$id;
            $data['groupe_UserId']=$value->getid();
            $data['title']=$title;
            $data['enabled']=$enabled;
            $data['body']=$body;
            $data['Cat']=$Cat;
            $data['dateCreation']=$dateCreation;
            $data['file']=$file;
            $data['UserName']=$UserName;
            $data['myGroupe']=$myGroupe;
            $data['UserName']=$groupe->getUser()->getFname().' '.$groupe->getUser()->getLname();
            $data['path']=$groupe->getUser()->getPath();
            $data['UserId']=$UserId;
            $data['refgroup']=$groupe->getrefgroup();
            $data['previlige']=$previlige;
 
            array_push($datas, $data);


        }
        
        // var_dump($datas);

        return $this->render('GJIBundle:Dash:index.html.twig', array('datas' => $datas ));
    }



    public function MyGroupsAction()
    {


        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');

        $em=$this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser(); 

        $setParameter = [];
        $setParameter['user'] = $user->getid();

        $QB = $em->createQueryBuilder();
        $QB->select('gu');
        $QB->from('GJIBundle:Groupe_User', 'gu');
        $QB->innerJoin('gu.Groupe', 'g');
        $QB->innerJoin('gu.UserP', 'up');
        $QB->orwhere('up.id=:user');
        $QB->orderBy('gu.id', 'DESC');
        $QB->groupBy('g.id');

        $QB->setParameters($setParameter);
        $Q = $QB->getQuery();
        $List = $Q->execute();

        $datas=[];

        foreach ($List as $value) {

            $data=[];

            $groupe =$value->getGroupe();
            $User =$value->getUser();
            $userParticipant=$value->getUserP();

            $id=$groupe->getid();
            $title=$groupe->gettitle();
            $enabled=$groupe->getenabled();
            $body=$groupe->getbody();
            $Cat=$groupe->getCat()->getcategorie();
            $dateCreation=$groupe->getdateCreation()->format('d-m-Y H:i');           
            $file=$groupe->getpath();
            $UserName =$User->getusername();

            $myGroupe=0;
            if($userParticipant->getid()==$User->getid())
                $myGroupe=1;

            $UserName =$User->getusername();
            $UserId =$User->getid();

            $membergroup=$em->getRepository('GJIBundle:MemberGroup')->findOneBy(array('Groupe'=>$groupe,'User'=>$User));
            $previlige= $membergroup->getprevilige();



            $data['groupe_UserId']=$value->getid();
            $data['id']=$id;
            $data['title']=$title;
            $data['enabled']=$enabled;
            $data['body']=$body;
            $data['Cat']=$Cat;
            $data['dateCreation']=$dateCreation;
            $data['file']=$file;
            $data['UserName']=$UserName;
            $data['myGroupe']=$myGroupe;
            $data['UserName']=$groupe->getUser()->getFname().' '.$groupe->getUser()->getLname();
            $data['UserId']=$UserId;
            $data['refgroup']=$groupe->getrefgroup();
            $data['path']=$groupe->getUser()->getPath();
            $data['previlige']=$previlige;

            array_push($datas, $data);


        }
        
        // var_dump($datas);

        return $this->render('GJIBundle:Dash:index.html.twig', array('datas' => $datas ));
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


    public  function get_identity()
    {
        $em=$this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        return $user;
    }

    public  function check_user($id)
    {

        //$etab=$this->get_identity()->getuser();
        $idetab=$this->get_identity()->getid();

        if($id==$idetab)
            return 1;
        else
            return 0;    
    }





   public function InviteFriendAction($id,Request $request)
    {


        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');

        $em=$this->getDoctrine()->getManager();
        $Group = $em->getRepository('GJIBundle:Groupe')->find($id);
        $title=$Group->gettitle();

        $user=$this->container->get('security.token_storage')->getToken()->getUser(); 
        $getId=$user->getId();
        $nameUser=$user->getFname()." ".$user->getLname();
        $refgroup=$Group->getrefgroup();

        return $this->render('GJIBundle:Invite:invite.html.twig', array('user'=>$getId,'title'=>$title,'refgroup'=>$refgroup,'nameUser'=>$nameUser));

    }



   public function ManagerUsersAction($id,Request $request)
    {


        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');

        $em=$this->getDoctrine()->getManager();
        $MemberGroups = $em->getRepository('GJIBundle:MemberGroup')->findBy(array('Groupe'=>$id));

        $Group = $em->getRepository('GJIBundle:Groupe')->find($id);
        $title=$Group->gettitle();


        $datas=[];
        foreach ($MemberGroups as $key => $MemberGroup) {

            if($MemberGroup->getprevilige()>0){

                $user=$MemberGroup->getUser();
                $data['id']=$MemberGroup->getid();
                $data['name']=$user->getFname().' '.$user->getLname();
                $data['avatar']=$user->getpath();
                $data['tel']=$user->getusername();
                $data['email']=$user->getemail();
                $data['previlige']=$MemberGroup->getprevilige();
                $data['active']=$MemberGroup->getactive();
                array_push($datas, $data);

            }
        }


        return $this->render('GJIBundle:Manager:index.html.twig', array('datas'=>$datas,'title'=>$title));

    }

 



   public function EditActiveAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        $id = $request->get('id');        
        $actif = $request->get('actif');        

        $MemberGroup = $em->getRepository('GJIBundle:MemberGroup')->find($id);
        // var_dump($MemberGroup);
        $MemberGroup->setactive($actif);
        
        $em->persist($MemberGroup);       
        $em->flush(); 


        return new Response(0);

    }


   public function EditPreviligeAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        $id = $request->get('id');        
        $previlige = $request->get('previlige');        

        $MemberGroup = $em->getRepository('GJIBundle:MemberGroup')->find($id);


        $MemberGroup->setprevilige($previlige);
        
        $em->persist($MemberGroup);       
        $em->flush(); 


        return new Response(0);

    }



   public function CheckUserAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();    

        $UserByPhonTeste=1;
        $UserBymailTest=1;
        $username = $request->get('tel');        
        $email = $request->get('email');        

        // $username='0645789621';
        // $email='carlos@gmail.com';
        $UserByPhone = $em->getRepository('UserBundle:User')->findOneByusername($username);
        $UserBymail = $em->getRepository('UserBundle:User')->findOneByemail($email);

        $result=1;

        if($UserByPhone){
            $UserByPhonTeste=0;
            $result=0;
        }

        if($UserBymail){
            $UserBymail=0;
            $result=0;

        }


        return new Response($result);

    }


   // public function getNotificationGroupeAction(Request $request)
   //  {

   //      $em=$this->getDoctrine()->getManager();

   //      $user=$this->container->get('security.token_storage')->getToken()->getUser();

   //       '----'.$iduser = $user->getId(); 
   //      $notifications = $em->getRepository('GJIBundle:notification')->findby(array('User'=>$iduser,'isread'=>0));

   //      $datas=[];

   //      foreach ($notifications as $key => $value) {
   //          # code...
   //          $data=[];

   //          $nameUser=$value->getUserP()->getFname().' '.$value->getUserP()->getLname();
   //          $idPostOrGroupOrComment=$value->getidPostOrGroupOrComment();

   //          if($value->gettype()==0){

   //              $PostOrGroupOrComment = $em->getRepository('GJIBundle:Groupe')->findOneById($idPostOrGroupOrComment);

   //              $Title=$PostOrGroupOrComment->getTitle();

   //              $msg='your are invited by '.$nameUser." to join group - ".$Title;
                
   //              $data['idnot']=$value->getId();
   //              $data['notification']=$msg;
   //              array_push($datas, $data);
   //          }

           


   //      }


   //      $response = new Response(json_encode($datas));
   //      $response->headers->set('Content-Type', 'application/json');
   //      return $response; 
   //  }


   public function getNotificationGroupAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        // $iduser = $request->get('iduser');        
        // $iduser =18;
        
        $iduser=$this->container->get('security.token_storage')->getToken()->getUser()->getId(); 


        $notifications = $em->getRepository('GJIBundle:notification')->findby(array('User'=>$iduser,'isread'=>0,'type'=>0));

        $datas=[];

        foreach ($notifications as $key => $value) {
            # code...
            $data=[];

            $nameUser=$value->getUserP()->getFname().' '.$value->getUserP()->getLname();
            $idPostOrGroupOrComment=$value->getidPostOrGroupOrComment();

            $idUserP=$value->getUserP()->getId();

            if($idUserP != $iduser ){

                $PostOrGroupOrComment = $em->getRepository('GJIBundle:Groupe')->findOneById($idPostOrGroupOrComment);

                $Title=$PostOrGroupOrComment->getTitle();

                $msg='your are invited by '.$nameUser." to join group - ".$Title;
                
                $data['path']=$value->getUserP()->getPath();
                $data['idnot']=$value->getId();
                $data['notification']=$msg;
                $data['nameUser']=$nameUser;
                $data['date']=$value->getdateCreation()->format('d-m-Y H:i:s');           
                array_push($datas, $data);

            }
            

        }

        // var_dump($iduser);

        // $info['datas']=$datas;
        // $info['size']=sizeof($datas);


        header("Content-Type: text/event-stream\n\n");     
        echo 'data: ' . json_encode($datas) . "\n\n";
        flush();
        // sleep(20);

        return new Response(sizeof($datas));

    }

   public function getNotificationAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        // $iduser = $request->get('iduser');        
        // $iduser =18;
        
        $iduser=$this->container->get('security.token_storage')->getToken()->getUser()->getId(); 

        $notificationGroups1 = $em->getRepository('GJIBundle:notification')->findby(array('User'=>$iduser,'type'=>0));
        $notificationGroups2 = $em->getRepository('GJIBundle:notification')->findby(array('UserP'=>$iduser,'type'=>0));

        $notificationGroups=array_merge($notificationGroups1,$notificationGroups2);

        $allNotifications=[];
        $datas=[];


        foreach ($notificationGroups as $key => $groupInfo) {

            $idGroupe=$groupInfo->getGroupe();
            $notificationGroups = $em->getRepository('GJIBundle:notification')->findby(array('Groupe'=>$idGroupe,'isread'=>0));
            foreach ($notificationGroups as $key => $valueNot) {

                array_push($allNotifications, $valueNot);

            }

        }

        // var_dump($allNotifications);


        foreach ($allNotifications as $key => $value) {
            
            $data=[];

            $nameUser=$value->getUserP()->getFname().' '.$value->getUserP()->getLname();
            $idPostOrGroupOrComment=$value->getidPostOrGroupOrComment();

            $idUserP=$value->getUserP()->getId();


            if($value->gettype()==1  and $idUserP != $iduser){

                $PostOrGroupOrComment = $em->getRepository('GJIBundle:Poste')->findOneById($idPostOrGroupOrComment);

                if($PostOrGroupOrComment){

                    $Title=$PostOrGroupOrComment->getGroupe()->getTitle();

                    $msg=" add a post in your group - ".$Title;
                    
                    $data['id']=$PostOrGroupOrComment->getGroupe()->getId();
                    $data['idnot']=$value->getId();
                    $data['nameUser']=$nameUser;
                    $data['date']=$value->getdateCreation()->format('d-m-Y H:i:s');           
                    $data['notification']=$msg;
                    $data['path']=$value->getUserP()->getPath();

                    array_push($datas, $data);                    
                }


            }


            if($value->gettype()==2  and $idUserP != $iduser){

                $PostOrGroupOrComment = $em->getRepository('GJIBundle:Comment')->findOneById($idPostOrGroupOrComment);
                
                if($PostOrGroupOrComment){

                    $Title=$PostOrGroupOrComment->getPoste()->getTitle();

                    $msg=" add a comment in your post - ".$Title;
                    $data['id']=$PostOrGroupOrComment->getPoste()->getGroupe()->getId();                
                    $data['path']=$value->getUserP()->getPath();
                    $data['nameUser']=$nameUser;
                    $data['idnot']=$value->getId();
                    $data['date']=$value->getdateCreation()->format('d-m-Y H:i:s');           
                    $data['notification']=$msg;

                    array_push($datas, $data);
                }

            }
                        


        }

        // var_dump($datas);


      
        $notifications = $em->getRepository('GJIBundle:notification')->findby(array('User'=>$iduser,'isread'=>0,'type'=>0));


        foreach ($notifications as $key => $value) {
            # code...
            $data=[];

            $nameUser=$value->getUserP()->getFname().' '.$value->getUserP()->getLname();
            $idPostOrGroupOrComment=$value->getidPostOrGroupOrComment();

            $idUserP=$value->getUserP()->getId();

            if($idUserP != $iduser ){

                $PostOrGroupOrComment = $em->getRepository('GJIBundle:Groupe')->findOneById($idPostOrGroupOrComment);

                $Title=$PostOrGroupOrComment->getTitle();

                $msg='your are invited by '.$nameUser." to join group - ".$Title;
                $data['id']=$PostOrGroupOrComment->getId();                
                
                $data['path']=$value->getUserP()->getPath();
                $data['path']=$value->getUserP()->getPath();
                $data['idnot']=$value->getId();
                $data['notification']=$msg;
                $data['nameUser']=$nameUser;
                $data['date']=$value->getdateCreation()->format('d-m-Y H:i:s');           
                array_push($datas, $data);

            }
            

        }

        header("Content-Type: text/event-stream\n\n");     
        echo 'data: ' . json_encode($datas) . "\n\n";
        flush();
        // sleep(30);

        return new Response(sizeof($datas));

    }


    public function readNotificationAction(Request $request)
    {
        
        $em=$this->getDoctrine()->getManager();

        $idnot = $request->get('idnot');
        if($idnot){

            $datas=[];
            array_push($datas, $idnot);

        }else{

            $datas = $request->get('datas');
        }

        foreach ($datas as $key => $value) {
            
            $not=$em->getRepository('GJIBundle:notification')->findOneById($value);
            $not->setisread(1);
            $em->persist($not);       
            $em->flush();


        }


    
    return new Response(0);

    }




    public function EditUserAction(Request $request)
    {


        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');

        $em=$this->getDoctrine()->getManager();
        
        $User=$this->container->get('security.token_storage')->getToken()->getUser(); 
        
        $Avatar=$User->getPath();
        $facebook=$User->getfacebook();
        $Twitter=$User->getTwitter();
        $Linkedin=$User->getLinkedin();
        $Google=$User->getGoogle();
        $Skype=$User->getSkype();
        $About=$User->getAbout();
        $Lname=$User->getLname();
        $Fname=$User->getFname();



        //=============ArrayDateofbirthY==============
        $ArrayDateofbirthY=[];
        $ArrayDateofbirthYVal=$User->getDateofbirthY();
        if(! empty($ArrayDateofbirthYVal))
            $ArrayDateofbirthY[$ArrayDateofbirthYVal]=$ArrayDateofbirthYVal;

        for ($i=1910; $i <2014 ; $i++) { 
            # code...
            $ArrayDateofbirthY[$i]=$i;
        }


        //=============ArrayDateofbirthM==============
        $ArrayMoints=array(
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December',
                );

        $ArrayDateofbirthM=[];

        $ArrayDateofbirthMVal=$User->getDateofbirthM();
        if(! empty($ArrayDateofbirthMVal))
            $ArrayDateofbirthM[$ArrayDateofbirthMVal]=$ArrayDateofbirthMVal;

        for ($i=0; $i <sizeof($ArrayMoints) ; $i++) { 
            # code...
            $ArrayDateofbirthM[$ArrayMoints[$i]]=$ArrayMoints[$i];
        }

        //=============ArrayDateofbirthD==============
        $ArrayDateofbirthD=[];
        $ArrayDateofbirthDVal=$User->getDateofbirthD();
        if(! empty($ArrayDateofbirthDVal))
            $ArrayDateofbirthD[$ArrayDateofbirthDVal]=$ArrayDateofbirthDVal;

        for ($i=1; $i <32 ; $i++) { 
            # code...
            $ArrayDateofbirthD[$i]=$i;
        }



        //=============ArrayAnniversaryDateM==============
        $ArrayAnniversaryDateM=[];
        $ArrayAnniversaryDateMVal=$User->getAnniversaryDateM();
        if(! empty($ArrayAnniversaryDateMVal))
            $ArrayAnniversaryDateM[$ArrayAnniversaryDateMVal]=$ArrayAnniversaryDateMVal;


        for ($i=0; $i <sizeof($ArrayMoints) ; $i++) { 
            # code...
            $ArrayAnniversaryDateM[$ArrayMoints[$i]]=$ArrayMoints[$i];
        }


        //=============ArrayAnniversaryDateD==============
        $ArrayAnniversaryDateD=[];
        $ArrayAnniversaryDateDVal=$User->getAnniversaryDateD();
        if(! empty($ArrayAnniversaryDateDVal))
            $ArrayAnniversaryDateD[$ArrayAnniversaryDateDVal]=$ArrayAnniversaryDateDVal;

        for ($i=1; $i <32 ; $i++) { 
            # code...
            $ArrayAnniversaryDateD[$i]=$i;
        }


        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");


        //=============ArrayCountry==============
        $ArrayCountry=[];
        $ArrayCountryVal=$User->getCountrie();
        if(! empty($ArrayCountryVal))
            $ArrayCountry[$ArrayCountryVal]=$ArrayCountryVal;


        for ($i=0; $i <sizeof($countries) ; $i++) { 
            # code...
            $ArrayCountry[$countries[$i]]=$countries[$i];
        }




        $form = $this->createFormBuilder($User)
        ->add('Lname', TextType::class)
        ->add('Fname', TextType::class)
        ->add('Email', TextType::class)
        ->add('file')
        ->add('address', TextareaType::class)
        ->add('City', TextType::class)
        ->add('facebook', TextType::class)
        ->add('Twitter', TextType::class)
        ->add('Linkedin', TextType::class)
        ->add('Google', TextType::class)
        ->add('Skype', TextType::class)
        ->add('About', TextareaType::class)

        ->add('DateofbirthY', ChoiceType::class, array(
            'choices' =>$ArrayDateofbirthY
        ))

        ->add('DateofbirthM', ChoiceType::class, array(
            'choices' =>$ArrayDateofbirthM
        ))

        ->add('DateofbirthD', ChoiceType::class, array(
            'choices' =>$ArrayDateofbirthD
        ))

        ->add('AnniversaryDateM', ChoiceType::class, array(
            'choices' =>$ArrayAnniversaryDateM
        ))
        ->add('AnniversaryDateD', ChoiceType::class, array(
            'choices' =>$ArrayAnniversaryDateD
        ))

        ->add('Countrie', ChoiceType::class, array(
            'choices' =>$ArrayCountry
        ))

        ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $User->upload();

            $em->persist($User);       
            $em->flush();   

            return $this->redirectToRoute('Profile');

        }




    return $this->render('GJIBundle:Users:index.html.twig',array('form'=>$form->createView(),'Avatar'=>$Avatar,'facebook'=>$facebook,'Twitter'=>$Twitter,'Linkedin'=>$Linkedin,'Google'=>$Google,'Skype'=>$Skype,'About'=>$About,'Avatar'=>$Avatar,'Lname'=>$Lname,'Fname'=>$Fname));
    }

       



    public function ForgetPasswordAction(Request $request)
    {


        return $this->render('GJIBundle:ForgetPassword:index.html.twig');
    }


    public function RenderPassAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $idU = $request->get('idU');
        // $idU = 11;

        return $this->render('GJIBundle:ForgetPassword:render.html.twig', array('idU' => $idU ));
    }

    public function GauthAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();



        $CLIENT_ID=$this->container->getParameter('CLIENT_ID');
        $CLIENT_REDIRECT_URL=$this->container->getParameter('CLIENT_REDIRECT_URL');
        $CLIENT_SECRET=$this->container->getParameter('CLIENT_SECRET');


                // '<pre> email : '.$email = 'mede'.uniqid().'@gmail'.'.com';
                // '<pre> fname : '.$fname = 'Kamme';
                // '<pre> lname : '.$lname = 'familyName';
                // '<pre> urlgoogle : '.$urlgoogle ='urlgoogle';
                // '<pre> image : '.$image = 'image';
                // '<pre> pass : '.$pass  = mt_rand(10, 999999);
                // '<pre> UserName : '.$UserName  = $fname.$lname.uniqid();




        if(isset($_GET['code'])) {
            try {
                // $gapi = new GoogleLoginApi();


                $gapi = $this->container->get('GoogleLoginApi');

                // Get the access token 
                $data = $gapi->GetAccessToken($CLIENT_ID, $CLIENT_REDIRECT_URL, $CLIENT_SECRET, $_GET['code']);
                
                // Get user information
                $user_info = $gapi->GetUserProfileInfo($data['access_token']);

                // echo '<pre>';print_r($user_info); echo '</pre>';
                 '<pre> email : '.$email = $user_info['emails'][0]['value'];
                 '<pre> fname : '.$fname = $user_info['name']['givenName'];
                 '<pre> lname : '.$lname = $user_info['name']['familyName'];
                 '<pre> urlgoogle : '.$urlgoogle = $user_info['url'];
                 '<pre> image : '.$image = $user_info['image']['url'];
                 '<pre> pass : '.$pass  = mt_rand(10, 999999);
                 '<pre> UserName : '.$UserName  = $fname.$lname.uniqid();



                // Now that the user is logged in you may want to start some session variables
                $_SESSION['logged_in'] = 1;

                // You may now want to redirect the user to the home page of your website
                // header('Location: home.php');
            }
            catch(Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }


        // $datas=[];
        // $response = new Response(json_encode($datas));
        // $response->headers->set('Content-Type', 'application/json');
        // return $response; 

        return $this->render('GJIBundle:Media:index.html.twig',array('email'=>$email,'fname'=>$fname,'lname'=>$lname,'urlgoogle'=>$urlgoogle,'image'=>$image,'pass'=>$pass,'UserName'=>$UserName));

    }



    public function GauthFacebookAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        $email = $request->get('email');
        $fname = $request->get('fname');
        $lname = $request->get('lname');
        $urlgoogle = $request->get('urlgoogle');
        $image = $request->get('image');

        '<pre> pass : '.$pass  = mt_rand(10, 999999);
        '<pre> UserName : '.$UserName  = $fname.$lname.uniqid();


        return $this->render('GJIBundle:Media:index.html.twig',array('email'=>$email,'fname'=>$fname,'lname'=>$lname,'urlgoogle'=>$urlgoogle,'image'=>$image,'pass'=>$pass,'UserName'=>$UserName));

    }

    public function LoginFAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        return $this->render('GJIBundle:FakeLogin:index.html.twig');

    }



}
