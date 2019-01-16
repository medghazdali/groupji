<?php

namespace GJI\GJIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use GJI\GJIBundle\Entity\Groupe;
use GJI\GJIBundle\Entity\Groupe_User;
use GJI\GJIBundle\Entity\Poste;
use GJI\GJIBundle\Entity\MemberGroup;
use GJI\GJIBundle\Entity\Comment;
use GJI\GJIBundle\Entity\notification;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;

class GroupeController extends Controller
{



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


    public function AddGroupAction(Request $request)
    {


        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');


        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();

        $Group = new Groupe();
        $Groupe_User = new Groupe_User();
        $MemberGroup = new MemberGroup();

        $Groupe_User->setGroupe($Group);
        $dataa=date('Y-m-d H:i:s');

        $Groupe_User->setdateCreation(new \DateTime($dataa));
        $Groupe_User->setUser($user);
        $Groupe_User->setUserP($user);

        $MemberGroup->setUser($user);
        $MemberGroup->setGroupe($Group);
        $MemberGroup->setprevilige(0);
        $MemberGroup->setActive(1);

        $Group->setDateCreation(new \DateTime($dataa));
        $Group->setUser($user);
        $Group->setenabled(1);
        $refgroup=uniqid().uniqid();
        $Group->setrefgroup($refgroup);

        $cats = $em->getRepository('GJIBundle:Cat')->findAll();

        $form = $this->createFormBuilder($Group)
        ->add('title', TextType::class)
        ->add('body', TextareaType::class , array('required' => false)) 
        ->add('file')

        ->add('Cat',  EntityType::class,
        array( 'label' => 'Categories','class' => 'GJIBundle:Cat','choice_label' => 'categorie',
        'choices' => $cats,'choices_as_values' => true,'multiple'=>false,'expanded'=>true
        ))

        ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Group->upload();
            $em->persist($Group);       
            $em->flush();

            $em->persist($Groupe_User);       
            $em->flush();  

            $em->persist($MemberGroup);       
            $em->flush();             
            return $this->redirectToRoute('home');

        }


        return $this->render('GJIBundle:Group:add.html.twig',array('form'=>$form->createView()));

    }



    public function EnableThisGroupAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();

        $idP = $request->get('idP');        

        $Group = $em->getRepository('GJIBundle:Groupe')->findOneById($idP);
        $Group->setenabled(1);

        $em->persist($Group);       
        $em->flush(); 

        
        return  new Response (1);     
    }



    public function EnableGroupAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();

        $idP = $request->get('idP');        

        $Group = $em->getRepository('GJIBundle:Groupe')->findOneById($idP);
        $Group->setenabled(0);

        $em->persist($Group);       
        $em->flush(); 

        
        return  new Response (1);     
    }



    public function LeaveGroupAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();

        $idP = $request->get('idP');        
        $Groupe_User=$em->find('GJIBundle:Groupe_User',$idP);

        $em->remove($Groupe_User);       
        $em->flush(); 

        
        return  new Response (1);     
    }



    public function EditGroupAction($id,Request $request)
    {


        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');


        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();



        $Group = $em->getRepository('GJIBundle:Groupe')->find($id);
        if(!$Group)
            return $this->redirectToRoute('home');



        $img=$Group->getpath();

        $cats = $em->getRepository('GJIBundle:Cat')->findAll();

        $form = $this->createFormBuilder($Group)
        ->add('title', TextType::class)
        ->add('body', TextareaType::class , array('required' => false)) 

        ->add('file')

        ->add('Cat',  EntityType::class,
        array( 'label' => 'Categories','class' => 'GJIBundle:Cat','choice_label' => 'categorie',
        'choices' => $cats,'choices_as_values' => true,'multiple'=>false,'expanded'=>true
        ))

        ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Group->upload();
            $em->persist($Group);       
            $em->flush(); 
            return $this->redirectToRoute('home');

        }


        return $this->render('GJIBundle:Group:add.html.twig',array('form'=>$form->createView(),'test'=>'edit','img'=>$img));

    }





    public function EditPosteAction($id,Request $request)
    {

        

        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');

        $em=$this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();

        $Poste=$em->getRepository('GJIBundle:Poste')->findOneById($id);
        if(!$Poste)
            return $this->redirectToRoute('home');



        
        // $Poste->setDateCreation($Poste->getDateCreation());
        // $Poste->setUser($user);
        // $Poste->setGroupe($Groupe);
        // $Poste->setNbrComments(0);

        $form = $this->createFormBuilder($Poste)
        ->add('title', TextType::class)
        ->add('file')
        ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Poste->upload();
            $em->persist($Poste);       
            $em->flush();

            // $this->redirect($this->generateUrl('GetGroup', array('id' => $post->getGroupe()->getId())));

        }

        return $this->render('GJIBundle:Poste:add.html.twig', array('form'=>$form->createView(),'img'=>$Poste->getPath(),'idg'=>$Poste->getGroupe()->getId() ));

        
    }




    public function deleteCommentAction(Request $request){


        $em=$this->getDoctrine()->getManager();
        $idPost = $request->get('idPost');        

        $Comment=$em->find('GJIBundle:Comment',$idPost);
        $Poste=$Comment->getPoste();

        $Poste->setNbrComments($Poste->getNbrComments()-1);      

        if(!$Comment)
        {
            throw $this->createNotFoundException('Comment not found');            
        }

        $em->remove($Comment);       
        $em->flush();   
        
        $em->persist($Poste);       
        $em->flush();
  
        return  new Response (1);     

    }


    public function deletePostAction(Request $request){


        $em=$this->getDoctrine()->getManager();
        $idPost = $request->get('idPost');        

        $Poste=$em->find('GJIBundle:Poste',$idPost);
        

        if(!$Poste)
        {
            throw $this->createNotFoundException('article not found');            
        }

        $em->remove($Poste);       
        $em->flush();   
  
        return  new Response (1);     

    }


    public function GetGroupAction($id,Request $request)
    {



        if(self::ifSessionExist()==0)
            return $this->redirectToRoute('fos_user_security_logout');


        $em=$this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();

        $datas=[];
        // $id=10;

        $idnot = $request->get('idnot');

        if($idnot){
            
            $not=$em->getRepository('GJIBundle:notification')->findOneById($idnot);
            $not->setisread(1);
            $em->persist($not);       
            $em->flush();

        }

        $Groupe=$em->getRepository('GJIBundle:Groupe')->findOneById($id);
        $membergroup=$em->getRepository('GJIBundle:MemberGroup')->findOneBy(array('Groupe'=>$id,'User'=>$user));
        $previlige= $membergroup->getprevilige();

        if(!$membergroup)
            return $this->redirectToRoute('home');





        $active= $membergroup->getactive();
        // var_dump($active);
        // var_dump($previlige);

        $Poste = new Poste();
        $dataa=date('Y-m-d H:i:s');

        $Poste->setDateCreation(new \DateTime($dataa));
        $Poste->setUser($user);
        $Poste->setGroupe($Groupe);
        $Poste->setNbrComments(0);



        $form = $this->createFormBuilder($Poste)
        ->add('title', TextType::class)
        ->add('file')  
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()){

            $getImages=$Poste->getImages();
            $files = $form->getData()->getImages();
            $file = $request->files->all();
            $getImages=$file['form']['images'];
        }


        if ($form->isSubmitted() && $form->isValid()) {

            $getImages=$Poste->getImages();
            $files = $form->getData()->getImages();
            $file = $request->files->all();
            // var_dump($getImages);
            // var_dump($files[0]->getPathName());
            // var_dump($files[0]->getClientOriginalName());
            // var_dump($files[0]->getfileName());

            var_dump($getImages);

            foreach ($getImages as $key => $getImage) {


                $target_dir = "uploads/Poste/";
                $imgName=basename($getImage->getClientOriginalName());

                $exst='';
                if (strrpos($imgName, '.') !== false) {
                    // $imgName=str_replace('.', uniqid().'.', $imgName);
                    $pos=strrpos($imgName, '.');
                    $exst=substr($imgName, $pos,strlen($imgName));
                }
               
                $imgNameNex=uniqid().$exst;
                $target_file = $target_dir .$imgNameNex;
                move_uploaded_file($getImage->getFileName(), $target_file);


            }

            $Poste->setImages('0');


            $Poste->upload();
            $em->persist($Poste);       
            $em->flush();

            $dataa=date('Y-m-d H:i:s');

            $notification= new notification();
            $notification->setdateCreation(new \DateTime($dataa));
            $notification->setUser($user);
            $notification->setUserP($user);
            $notification->setidPostOrGroupOrComment($id);
            $notification->setisread(0);
            $notification->setType(1);
            $notification->setGroupe($Groupe);

            $em->persist($notification);       
            $em->flush();

            // return $this->redirect($request->getUri());


        }
        
        $Poste = new Poste();            

        $Postes=$em->getRepository('GJIBundle:Poste')->findBy(array('Groupe' => $Groupe), array('id' => 'DESC'));
    
        return $this->render('GJIBundle:Group:getGroupe.html.twig', array('previlige' => $previlige,'active' => $active,'Postes' => $Postes,'Groupe' => $Groupe,'form'=>$form->createView() ));
    }
 




    // public function AddPostAction(Request $request)
    // {

    //     $em=$this->getDoctrine()->getManager();
    //     $user=$this->get_identity();

    //     $idP = $request->get('idP');        
    //     $title = $request->get('title');        
    //     $file = $request->get('file');        

    //     $Groupe = $em->getRepository('GJIBundle:Groupe')->findOneById($idG);
    //     $dataa=date('Y-m-d H:i:s');

    //     $Poste = new Poste();
    //     $Poste->setDateCreation(new \DateTime($dataa));
    //     $Poste->setUser($user);
    //     $Poste->setGroupe($Groupe);
    //     $Poste->setNbrComments(0);

    //     $em->persist($Poste);       
    //     $em->flush();

    //     return $this->render('GJIBundle:Poste:add.html.twig',array('form'=>$form->createView()));

    // }







    public function AddCommentAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();

        $idP = $request->get('idP');        
        $commentaire = $request->get('comment');        
        $Poste = $em->getRepository('GJIBundle:Poste')->findOneById($idP);
        $Poste->SetNbrComments($Poste->getNbrComments()+1);

        $Comment = new Comment();
        $dataa=date('Y-m-d H:i:s');

        $Comment->setDateCreation(new \DateTime($dataa));
        $Comment->setUser($user);
        $Comment->setComment($commentaire);
        $Comment->setPoste($Poste);

        $em->persist($Comment);       
        $em->flush();
        
        $em->persist($Poste);       
        $em->flush();
        
        $dataa=date('Y-m-d H:i:s');

        $notification= new notification();
        $notification->setdateCreation(new \DateTime($dataa));
        $notification->setUser($user);
        $notification->setUserP($user);
        $notification->setidPostOrGroupOrComment($Comment->getId());
        $notification->setisread(0);
        $notification->setType(2);
        $notification->setGroupe($Poste->getGroupe());

        $em->persist($notification);       
        $em->flush();


        return  new Response (1);       

    }



    public function GetCommentsAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();

        $idP = $request->get('idP');        
        // $idP = 2;        
        $NbrComments = $em->getRepository('GJIBundle:Poste')->findOneById($idP)->getNbrComments();

        $Comments = $em->getRepository('GJIBundle:Comment')->findBy(array('Poste' => $idP), array('id' => 'DESC'));
        // var_dump($Comments);

        $datas=[];
        $data1=[];

        foreach ($Comments as $key => $value) {
            # code...
            $data=[];

            $data['id']=$value->getid();
            $data['dateCreation']=$value->getdateCreation()->format('d-m-Y H:i:s');
            $data['UserName']=$value->getUser()->getLName().' '.$value->getUser()->getLName();
            $data['UserId']=$value->getUser()->getId();
            $data['Comment']=$value->getComment();
            $data['path']=$value->getUser()->getPath();

            array_push($data1, $data);

        }
        
        array_push($datas, $data1);

        array_push($datas, $NbrComments);


        $response = new Response(json_encode($datas));
        $response->headers->set('Content-Type', 'application/json');
        return $response;       

    }







}
