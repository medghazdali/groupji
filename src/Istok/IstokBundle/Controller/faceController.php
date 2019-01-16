<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\face;
use Istok\IstokBundle\Entity\categories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class faceController extends Controller
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
        $face=$em->getRepository('IstokIstokBundle:face')->findById($idart);

        if(empty($face)){return new Response(0);}

        $qte=$face[0]->getquantite();
        $prix=$face[0]->getprix();
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
        $face=$em->getRepository('IstokIstokBundle:face')->findById($idart);


        if(empty($face)){return new Response(0);}

        $prix=$face[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $face=$em->getRepository('IstokIstokBundle:face')->findByetab($etab);

        return $this->render('IstokIstokBundle:face:list.html.twig',array('faces'=>$face));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article face';

        $em=$this->getDoctrine()->getManager();
        $face = new face();
        /*$face->setNom('kamal');
        $face->setPrenom('palkamal');
        $face->setDatenaissance(new \DateTime('tomorrow'));*/

        //$face->setdatestock(new \DateTime());
        $face->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'face'));


        $form = $this->createFormBuilder($face)
            ->add('libelle', TextType::class)
            ->add('metrage', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 1000)))

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:face:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($face);       
                        $em->flush();       
                       // $msg='Add face Success' ;   
                     return $this->redirectToRoute('face');


                }


        return $this->render('IstokIstokBundle:face:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier FACE";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $face = $em->getRepository('IstokIstokBundle:face')->findOneBy(array('etab' => $etab));


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($face)
            
            ->add('libelle', TextType::class)
            ->add('metrage', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 1000)))

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
   /* $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:face:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($face);       
                        $em->flush();       
                       // $msg='Add face Success' ;   
                        return $this->redirectToRoute('face');


                }


        return $this->render('IstokIstokBundle:face:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $face=$em->find('IstokIstokBundle:face',$id);
        
        $etab2 = $face->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('face');
        }


        if(!$face)
        {

            throw $this->createNotFoundException('face not found');
            
        }
        $em->remove($face);       
        $em->flush();   
        //$msg='delete face Succes' ;   
       // return new Response('delete face Success =D') ;   
        return $this->redirectToRoute('face');

    }




}
