<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\type;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TypeController extends Controller
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

                               $etab=$this->get_identity()->getetab();

       
        $em=$this->getDoctrine()->getManager();
        $type=$em->getRepository('IstokIstokBundle:type')->findByetab($etab);
        return $this->render('IstokIstokBundle:type:list.html.twig',array('types'=>$type));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg='Ajouter type Client';

        $em=$this->getDoctrine()->getManager();
        $type = new type();



        $etab=$this->get_identity()->getetab();
        $type->setetab($etab);



        $form = $this->createFormBuilder($type)
            ->add('type', TextType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($type);       
                        $em->flush();       
                       // $msg='Add type Success' ;   
                     return $this->redirectToRoute('type');


                }


        return $this->render('IstokIstokBundle:type:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg="Modifier type client";

        $em=$this->getDoctrine()->getManager();
        $type = $em->getRepository('IstokIstokBundle:type')->find($id);
       
        
        $etab2 = $type->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('type');
        }

        $form = $this->createFormBuilder($type)
            ->add('type', TextType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                

        $em->persist($type);       
                        $em->flush();       
                       // $msg='Add type Success' ;   
                        return $this->redirectToRoute('type');


                }


        return $this->render('IstokIstokBundle:type:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $type=$em->find('IstokIstokBundle:type',$id);

        $etab2 = $type->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('type');
        }
        
        if(!$type)
        {

            throw $this->createNotFoundException('type not found');
            
        }
        $em->remove($type);       
        $em->flush();   
        //$msg='delete type Succes' ;   
       // return new Response('delete type Success =D') ;   
                        return $this->redirectToRoute('type');

    }




}
