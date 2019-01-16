<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\demande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class demandeController extends Controller
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
        $demande=$em->getRepository('IstokIstokBundle:demande')->findByetab($etab);
        return $this->render('IstokIstokBundle:demande:list.html.twig',array('demandes'=>$demande));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg='Ajouter demande';

        $em=$this->getDoctrine()->getManager();
        $demande = new demande();

        $demande->setdate(new \DateTime());
        $demande->setactive('1');


        $etab=$this->get_identity()->getetab();
        $demande->setetab($etab);
        $user=$this->get_identity();

        $demande->setuser($user);


        $form = $this->createFormBuilder($demande)
            ->add('objet', TextType::class)
            ->add('description', TextareaType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($demande);       
                        $em->flush();       
                       // $msg='Add demande Success' ;   
                     return $this->redirectToRoute('demande');


                }


        return $this->render('IstokIstokBundle:demande:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg="Modifier la demande";

        $em=$this->getDoctrine()->getManager();
        $demande = $em->getRepository('IstokIstokBundle:demande')->find($id);
      
        
        $etab2 = $demande->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('demande');
        }


        $demande->setdate(new \DateTime());
        $demande->setactive('1');





        $form = $this->createFormBuilder($demande)
            ->add('objet', TextType::class)
            ->add('description', TextareaType::class)
        
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($demande);       
                        $em->flush();       
                       // $msg='Add demande Success' ;   
                     return $this->redirectToRoute('demande');


                }

        return $this->render('IstokIstokBundle:demande:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $demande=$em->find('IstokIstokBundle:demande',$id);

        $etab2 = $demande->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('demande');
        }


        if(!$demande)
        {

            throw $this->createNotFoundException('demande not found');
            
        }
        $em->remove($demande);       
        $em->flush();   
        //$msg='delete demande Succes' ;   
       // return new Response('delete demande Success =D') ;   
                        return $this->redirectToRoute('demande');

    }


 public function getdmdAction(){

                $em=$this->getDoctrine()->getManager();
$dmds=$em->getRepository('IstokIstokBundle:demande')->findByactive('1');
        $szdmd=sizeof($dmds);
    
    return new Response($szdmd);
    }

}
