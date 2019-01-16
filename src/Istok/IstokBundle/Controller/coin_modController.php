<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\coin_mod;
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

class coin_modController extends Controller
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
        $coin_mod=$em->getRepository('IstokIstokBundle:coin_mod')->findById($idart);

        if(empty($coin_mod)){return new Response(0);}

        $qte=$coin_mod[0]->getquantite();
        $prix=$coin_mod[0]->getprix();
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
        $coin_mod=$em->getRepository('IstokIstokBundle:coin_mod')->findById($idart);


        if(empty($coin_mod)){return new Response(0);}

        $prix=$coin_mod[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $coin_mod=$em->getRepository('IstokIstokBundle:coin_mod')->findByetab($etab);

        return $this->render('IstokIstokBundle:coin_mod:list.html.twig',array('coin_mods'=>$coin_mod));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article coin_mod';

        $em=$this->getDoctrine()->getManager();
        $coin_mod = new coin_mod();
        /*$coin_mod->setNom('kamal');
        $coin_mod->setPrenom('palkamal');
        $coin_mod->setDatenaissance(new \DateTime('tomorrow'));*/

        //$coin_mod->setdatestock(new \DateTime());
        $coin_mod->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'coin_mod'));


        $form = $this->createFormBuilder($coin_mod)
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
  return $this->render('IstokIstokBundle:coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($coin_mod);       
                        $em->flush();       
                       // $msg='Add coin_mod Success' ;   
                     return $this->redirectToRoute('coin_mod');


                }


        return $this->render('IstokIstokBundle:coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier COIN";
      $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $coin_mod = $em->getRepository('IstokIstokBundle:coin_mod')->findOneBy(array('etab' => $etab));
          $etab2 = $coin_mod->getetab();


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($coin_mod)
            
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
  return $this->render('IstokIstokBundle:coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($coin_mod);       
                        $em->flush();       
                       // $msg='Add coin_mod Success' ;   
                        return $this->redirectToRoute('coin_mod');


                }


        return $this->render('IstokIstokBundle:coin_mod:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $coin_mod=$em->find('IstokIstokBundle:coin_mod',$id);
        
        $etab2 = $coin_mod->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('coin_mod');
        }


        if(!$coin_mod)
        {

            throw $this->createNotFoundException('coin_mod not found');
            
        }
        $em->remove($coin_mod);       
        $em->flush();   
        //$msg='delete coin_mod Succes' ;   
       // return new Response('delete coin_mod Success =D') ;   
        return $this->redirectToRoute('coin_mod');

    }




}
