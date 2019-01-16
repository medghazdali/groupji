<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\tissus;
use Istok\IstokBundle\Entity\cat_tissus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class cat_tissusController extends Controller
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



    public function qteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $idart=$request->get('idart');
        if(empty($idart)){return new Response(0);}
        $tissus=$em->getRepository('IstokIstokBundle:tissus')->findById($idart);

        if(empty($tissus)){return new Response(0);}

        $qte=$tissus[0]->getquantite();
        $prix=$tissus[0]->getprix();
        $jsn=array('qte' => $qte,'prix'=>$prix);

        $response = new Response(json_encode($jsn));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
                
   //return new Response($qte);
    }


    public function getprixAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $idart=$request->get('id');

        if(empty($idart)){return new Response(0);}
        $tissus=$em->getRepository('IstokIstokBundle:tissus')->findById($idart);


        if(empty($tissus)){return new Response(0);}

        $prix=$tissus[0]->getprix();

    return new Response($prix);

    }




    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $cat_tissus=$em->getRepository('IstokIstokBundle:cat_tissus')->findByetab($etab);

        return $this->render('IstokIstokBundle:cat_tissus:list.html.twig',array('cat_tissus'=>$cat_tissus));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter catégorie tissus';

        $em=$this->getDoctrine()->getManager();
        $cat_tissus = new cat_tissus();
        $cat_tissus->setetab($etab);

        $form = $this->createFormBuilder($cat_tissus)
            ->add('categorie', TextType::class)
           
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:cat_tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/

                        $em->persist($cat_tissus);       
                        $em->flush();       
                       // $msg='Add cat_tissus Success' ;   
                     return $this->redirectToRoute('cat_tissus');


                }


        return $this->render('IstokIstokBundle:cat_tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier L'tissus";

        $em=$this->getDoctrine()->getManager();
        $cat_tissus = $em->getRepository('IstokIstokBundle:cat_tissus')->find($id);
        $etab=$this->get_identity()->getetab();


  $form = $this->createFormBuilder($cat_tissus)
            ->add('categorie', TextType::class)
           
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:cat_tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/

                        $em->persist($cat_tissus);       
                        $em->flush();       
                       // $msg='Add cat_tissus Success' ;   
                     return $this->redirectToRoute('cat_tissus');


                }

                


        return $this->render('IstokIstokBundle:cat_tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $tissus=$em->find('IstokIstokBundle:cat_tissus',$id);
        
        $etab2 = $tissus->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('cat_tissus');
        }


        if(!$tissus)
        {

            throw $this->createNotFoundException('cat_tissus not found');
            
        }
        $em->remove($tissus);       
        $em->flush();   
        //$msg='delete tissus Succes' ;   
       // return new Response('delete tissus Success =D') ;   
        return $this->redirectToRoute('cat_tissus');

    }




}
