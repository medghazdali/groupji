<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\facilite;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class faciliteController extends Controller
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
 


    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
                $etab=$this->get_identity()->getetab();
        $facilite=$em->getRepository('IstokIstokBundle:facilite')->findByetab($etab);
        return $this->render('IstokIstokBundle:facilite:list.html.twig',array('facilites'=>$facilite));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg='Ajouter facilite';

        $em=$this->getDoctrine()->getManager();
        $facilite = new facilite();

        $etab=$this->get_identity()->getetab();
        $facilite->setetab($etab);




        $form = $this->createFormBuilder($facilite)
            ->add('facilite', TextType::class)
            ->add('description', TextType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($facilite);       
                        $em->flush();       
                       // $msg='Add facilite Success' ;   
                     return $this->redirectToRoute('facilite');


                }


        return $this->render('IstokIstokBundle:facilite:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg="Modifier la facilite";

        $em=$this->getDoctrine()->getManager();
        $facilite = $em->getRepository('IstokIstokBundle:facilite')->find($id);
      
        
        $etab2 = $facilite->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('facilite');
        }


        $form = $this->createFormBuilder($facilite)
            ->add('facilite', TextType::class)
            ->add('description', TextType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($facilite);       
                        $em->flush();       
                       // $msg='Add facilite Success' ;   
                     return $this->redirectToRoute('facilite');


                }

        return $this->render('IstokIstokBundle:facilite:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $facilite=$em->find('IstokIstokBundle:facilite',$id);

        $etab2 = $facilite->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('facilite');
        }


        if(!$facilite)
        {

            throw $this->createNotFoundException('facilite not found');
            
        }
        $em->remove($facilite);       
        $em->flush();   
        //$msg='delete facilite Succes' ;   
       // return new Response('delete facilite Success =D') ;   
                        return $this->redirectToRoute('facilite');

    }




}
