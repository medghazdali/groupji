<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\banquette;
use Istok\IstokBundle\Entity\cat_banquettes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class cat_banquettesController extends Controller
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
        $banquette=$em->getRepository('IstokIstokBundle:banquette')->findById($idart);

        if(empty($banquette)){return new Response(0);}

        $qte=$banquette[0]->getquantite();
        $prix=$banquette[0]->getprix();
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
        $banquette=$em->getRepository('IstokIstokBundle:banquette')->findById($idart);


        if(empty($banquette)){return new Response(0);}

        $prix=$banquette[0]->getprix();

    return new Response($prix);

    }




    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $cat_banquettes=$em->getRepository('IstokIstokBundle:cat_banquettes')->findByetab($etab);

        return $this->render('IstokIstokBundle:cat_banquettes:list.html.twig',array('cat_banquettes'=>$cat_banquettes));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter catégorie banquette';

        $em=$this->getDoctrine()->getManager();
        $cat_banquettes = new cat_banquettes();
        $cat_banquettes->setetab($etab);

        $form = $this->createFormBuilder($cat_banquettes)
            ->add('categorie', TextType::class)
           
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:cat_banquettes:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/

                        $em->persist($cat_banquettes);       
                        $em->flush();       
                       // $msg='Add cat_banquettes Success' ;   
                     return $this->redirectToRoute('cat_banquettes');


                }


        return $this->render('IstokIstokBundle:cat_banquettes:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier L'banquette";

        $em=$this->getDoctrine()->getManager();
        $cat_banquettes = $em->getRepository('IstokIstokBundle:cat_banquettes')->find($id);
        $etab=$this->get_identity()->getetab();


  $form = $this->createFormBuilder($cat_banquettes)
            ->add('categorie', TextType::class)
           
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:cat_banquettes:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/

                        $em->persist($cat_banquettes);       
                        $em->flush();       
                       // $msg='Add cat_banquettes Success' ;   
                     return $this->redirectToRoute('cat_banquettes');


                }

                


        return $this->render('IstokIstokBundle:cat_banquettes:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $banquette=$em->find('IstokIstokBundle:cat_banquettes',$id);
        
        $etab2 = $banquette->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('cat_banquettes');
        }


        if(!$banquette)
        {

            throw $this->createNotFoundException('cat_banquettes not found');
            
        }
        $em->remove($banquette);       
        $em->flush();   
        //$msg='delete banquette Succes' ;   
       // return new Response('delete banquette Success =D') ;   
        return $this->redirectToRoute('cat_banquettes');

    }




}
