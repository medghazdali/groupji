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
 



         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg="Modifier l etablissement";

        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();

        
        $etab = $em->getRepository('IstokIstokBundle:etab')->findOneById($etab);
      ///var_dump($etab);



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
                     return $this->redirectToRoute('etab_edit');


                }

        return $this->render('IstokIstokBundle:etab:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    






}
