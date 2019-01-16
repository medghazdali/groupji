<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\etab;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class etabController extends Controller
{

    


    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository('IstokIstokBundle:etab')->findAll();
        
                             return $this->redirectToRoute('home');

//return $this->render('IstokIstokBundle:etab:list.html.twig',array('etabs'=>$etab));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg='Ajouter etab';

        $em=$this->getDoctrine()->getManager();
        $etab = new etab();






        $form = $this->createFormBuilder($etab)
            ->add('etab', TextType::class)
            ->add('signature', TextType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                          // $em->persist($etab);       
                        //$em->flush();       
                       // $msg='Add etab Success' ;   
                     //return $this->redirectToRoute('etab');

                     return $this->redirectToRoute('home');
                }

                     return $this->redirectToRoute('home');

        return $this->render('IstokIstokBundle:etab:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg="Modifier l etablissement";

        $em=$this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();

        $iduser=$user->getid();

        
        $etab = $em->getRepository('IstokIstokBundle:etab')->find($iduser);
      



        $form = $this->createFormBuilder($etab)
            ->add('etab', TextType::class)
            ->add('signature', TextType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($etab);       
                        $em->flush();       
                       // $msg='Add etab Success' ;   
                     return $this->redirectToRoute('home');


                }

        return $this->render('IstokIstokBundle:etab:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $etab=$em->find('IstokIstokBundle:etab',$id);
        if(!$etab)
        {

            throw $this->createNotFoundException('etab not found');
            
        }
        $em->remove($etab);       
        $em->flush();   
        //$msg='delete etab Succes' ;   
       // return new Response('delete etab Success =D') ;   
                        return $this->redirectToRoute('etab');

    }




}
