<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\banquette_coin_mod;
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

class banquette_coin_modController extends Controller
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
        $banquette_coin_mod=$em->getRepository('IstokIstokBundle:banquette_coin_mod')->findById($idart);

        if(empty($banquette_coin_mod)){return new Response(0);}

        $qte=$banquette_coin_mod[0]->getquantite();
        $prix=$banquette_coin_mod[0]->getprix();
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
        $banquette_coin_mod=$em->getRepository('IstokIstokBundle:banquette_coin_mod')->findById($idart);


        if(empty($banquette_coin_mod)){return new Response(0);}

        $prix=$banquette_coin_mod[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $banquette_coin_mod=$em->getRepository('IstokIstokBundle:banquette_coin_mod')->findByetab($etab);

        return $this->render('IstokIstokBundle:banquette_coin_mod:list.html.twig',array('banquette_coin_mods'=>$banquette_coin_mod));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article banquette_coin_mod';

        $em=$this->getDoctrine()->getManager();
        $banquette_coin_mod = new banquette_coin_mod();
        /*$banquette_coin_mod->setNom('kamal');
        $banquette_coin_mod->setPrenom('palkamal');
        $banquette_coin_mod->setDatenaissance(new \DateTime('tomorrow'));*/

        //$banquette_coin_mod->setdatestock(new \DateTime());
        $banquette_coin_mod->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'banquette_coin_mod'));


        $form = $this->createFormBuilder($banquette_coin_mod)
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
  return $this->render('IstokIstokBundle:banquette_coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($banquette_coin_mod);       
                        $em->flush();       
                       // $msg='Add banquette_coin_mod Success' ;   
                     return $this->redirectToRoute('banquette_coin_mod');


                }


        return $this->render('IstokIstokBundle:banquette_coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier COIN";
      $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $banquette_coin_mod = $em->getRepository('IstokIstokBundle:banquette_coin_mod')->findOneBy(array('etab' => $etab));
          $etab2 = $banquette_coin_mod->getetab();


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($banquette_coin_mod)
            
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
  return $this->render('IstokIstokBundle:banquette_coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($banquette_coin_mod);       
                        $em->flush();       
                       // $msg='Add banquette_coin_mod Success' ;   
                        return $this->redirectToRoute('banquette_coin_mod');


                }


        return $this->render('IstokIstokBundle:banquette_coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $banquette_coin_mod=$em->find('IstokIstokBundle:banquette_coin_mod',$id);
        
        $etab2 = $banquette_coin_mod->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('banquette_coin_mod');
        }


        if(!$banquette_coin_mod)
        {

            throw $this->createNotFoundException('banquette_coin_mod not found');
            
        }
        $em->remove($banquette_coin_mod);       
        $em->flush();   
        //$msg='delete banquette_coin_mod Succes' ;   
       // return new Response('delete banquette_coin_mod Success =D') ;   
        return $this->redirectToRoute('banquette_coin_mod');

    }




}
