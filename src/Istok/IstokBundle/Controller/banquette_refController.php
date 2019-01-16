<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\banquettes_ref;
use Istok\IstokBundle\Entity\sous_banquettes;
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

class banquette_refController extends Controller
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
        $banquettes_ref=$em->getRepository('IstokIstokBundle:banquettes_ref')->findById($idart);

        if(empty($banquettes_ref)){return new Response(0);}

        $qte=$banquettes_ref[0]->getquantite();
        $prix=$banquettes_ref[0]->getprix();
        $jsn=array('qte' => $qte,'prix'=>$prix);

        $response = new Response(json_encode($jsn));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
                
   //return new Response($qte);
    }




    public function getRefBanqAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        //$cat_banquettesId=$request->get('id');
        $sous_banquettesId=$request->get('id');

        if(empty($sous_banquettesId)){return new Response(0);}

    $banquettes_ref=$em->getRepository('IstokIstokBundle:banquettes_ref')->findBy(array('sous_banquettes'=>$sous_banquettesId));

        $tab=[];

        foreach ($banquettes_ref as $key => $value) {

        $idd=$value->getId();
        $ref=$value->getreference();
        $pri=$value->getprix();



        $ind=["id"=>$idd,"ref"=>$ref,"prix"=>$pri];

        array_push($tab, $ind);


        }

        //var_dump($tab);

        if(empty($banquettes_ref)){return new Response(0);}


        $response = new Response(json_encode($tab));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }




    public function getprixAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $idart=$request->get('id');

        if(empty($idart)){return new Response(0);}
        $banquettes_ref=$em->getRepository('IstokIstokBundle:banquettes_ref')->findById($idart);


        if(empty($banquettes_ref)){return new Response(0);}

        $prix=$banquettes_ref[0]->getprix();

    return new Response($prix);

    }




    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $banquettes_ref=$em->getRepository('IstokIstokBundle:banquettes_ref')->findByetab($etab);

        return $this->render('IstokIstokBundle:banquettes_ref:list.html.twig',array('banquettes_refs'=>$banquettes_ref));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter referenece banquette';

        $em=$this->getDoctrine()->getManager();
        $banquettes_ref = new banquettes_ref();
        $banquettes_ref->setetab($etab);
    //    $banquettes = $em->getRepository('IstokIstokBundle:banquettes')->findBy(array('etab' => $etab));
        $sous_banquette = $em->getRepository('IstokIstokBundle:sous_banquettes')->findBy(array('etab' => $etab));

        $form = $this->createFormBuilder($banquettes_ref)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))

            ->add('reference', TextType::class)

            ->add('sous_banquettes',  EntityType::class,
             array( 'label' => 'sous categorie banquettes ','class' => 'IstokIstokBundle:sous_banquettes','choice_label' => 'sous_categorie',
                    'choices' => $sous_banquette,
                    ))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                        $em->persist($banquettes_ref);       
                        $em->flush();       
                       // $msg='Add banquettes_ref Success' ;   
                     return $this->redirectToRoute('banquette_ref');


                }


        return $this->render('IstokIstokBundle:banquettes_ref:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier L'banquettes_ref";

        $em=$this->getDoctrine()->getManager();
        $banquettes_ref = $em->getRepository('IstokIstokBundle:banquettes_ref')->find($id);
        $etab=$this->get_identity()->getetab();
        $banquettes_ref->setetab($etab);
        $banquettes = $em->getRepository('IstokIstokBundle:banquettes')->findBy(array('etab' => $etab));
        $sous_banquette = $em->getRepository('IstokIstokBundle:sous_banquettes')->findBy(array('etab' => $etab));

   $form = $this->createFormBuilder($banquettes_ref)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('banquettes',  EntityType::class,
             array( 'label' => 'banquette','class' => 'IstokIstokBundle:banquettes','choice_label' => 'reference',
                    'choices' => $banquettes,
                    ))
            ->add('sous_banquettes',  EntityType::class,
             array( 'label' => 'sous categorie banquettes ','class' => 'IstokIstokBundle:sous_banquettes','choice_label' => 'sous_categorie',
                    'choices' => $sous_banquette,
                    ))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                        $em->persist($banquettes_ref);       
                        $em->flush();       
                       // $msg='Add banquettes_ref Success' ;   
                     return $this->redirectToRoute('banquette_ref');


                }

                


        return $this->render('IstokIstokBundle:banquettes_ref:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $banquettes_ref=$em->find('IstokIstokBundle:banquettes_ref',$id);
        
        $etab2 = $banquettes_ref->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('banquettes_ref');
        }


        if(!$banquettes_ref)
        {

            throw $this->createNotFoundException('banquettes_ref not found');
            
        }
        $em->remove($banquettes_ref);       
        $em->flush();   
        //$msg='delete banquettes_ref Succes' ;   
       // return new Response('delete banquettes_ref Success =D') ;   
        return $this->redirectToRoute('banquettes_ref');

    }




}
