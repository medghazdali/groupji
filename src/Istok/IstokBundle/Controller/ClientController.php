<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\client;
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

class ClientController extends Controller
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
        $client=$em->getRepository('IstokIstokBundle:client')->findByetab($etab);
        return $this->render('IstokIstokBundle:client:list.html.twig',array('clients'=>$client));

    }


    private $date;
   private $reference;

     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg='Ajouter client';

        $em=$this->getDoctrine()->getManager();
        $client = new client();
        /*$client->setNom('kamal');
        $client->setPrenom('palkamal');
        $client->setDatenaissance(new \DateTime('tomorrow'));*/

        $client->setdate(new \DateTime('today'));
        $client->setreference(uniqid());

        $etab=$this->get_identity()->getetab();
        $client->setetab($etab);
        $listtype = $em->getRepository('IstokIstokBundle:type')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($client)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('tel', TextType::class)
            ->add('cin', TextType::class)

            ->add('type',  EntityType::class,
             array( 'label' => 'Type de client','class' => 'IstokIstokBundle:type','choice_label' => 'type',
                    'choices' => $listtype,
                    ))


            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                        $em->persist($client);       
                        $em->flush();       
                       // $msg='Add client Success' ;   
                        return $this->redirectToRoute('client');


                }


        return $this->render('IstokIstokBundle:client:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg="Modifier L'client";

        $em=$this->getDoctrine()->getManager();
        $client = $em->getRepository('IstokIstokBundle:client')->find($id);
        /*$client->setNom('kamal');
        $client->setPrenom('palkamal');
        $client->setSexe('M');
        $client->setDatenaissance(new \DateTime('tomorrow'));*/

        
        $etab2 = $client->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('client');
        }


                  $client->setdate(new \DateTime('today'));
        $client->setreference(uniqid());

        $listtype = $em->getRepository('IstokIstokBundle:type')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($client)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('tel', TextType::class)
            ->add('cin', TextType::class)

            ->add('type',  EntityType::class,
             array( 'label' => 'Type de client','class' => 'IstokIstokBundle:type','choice_label' => 'type',
                    'choices' => $listtype,
                    ))

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                        $em->persist($client);       
                        $em->flush();       
                       // $msg='Add client Success' ;   
                        return $this->redirectToRoute('client');


                }


        return $this->render('IstokIstokBundle:client:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $client=$em->find('IstokIstokBundle:client',$id);


        $etab2 = $client->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('client');
        }


        if(!$client)
        {

            throw $this->createNotFoundException('client not found');
            
        }
        $em->remove($client);       
        $em->flush();   
        //$msg='delete client Succes' ;   
       // return new Response('delete client Success =D') ;   
                        return $this->redirectToRoute('client');

    }




}
