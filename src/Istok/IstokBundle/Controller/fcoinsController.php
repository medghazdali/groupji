<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\fcoins;
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

class fcoinsController extends Controller
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
        $fcoins=$em->getRepository('IstokIstokBundle:fcoins')->findById($idart);

        if(empty($fcoins)){return new Response(0);}

        $qte=$fcoins[0]->getquantite();
        $prix=$fcoins[0]->getprix();
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
        $fcoins=$em->getRepository('IstokIstokBundle:fcoins')->findById($idart);


        if(empty($fcoins)){return new Response(0);}

        $prix=$fcoins[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $fcoins=$em->getRepository('IstokIstokBundle:fcoins')->findByetab($etab);

        return $this->render('IstokIstokBundle:fcoins:list.html.twig',array('fcoinss'=>$fcoins));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article fcoins';

        $em=$this->getDoctrine()->getManager();
        $fcoins = new fcoins();
        /*$fcoins->setNom('kamal');
        $fcoins->setPrenom('palkamal');
        $fcoins->setDatenaissance(new \DateTime('tomorrow'));*/

        //$fcoins->setdatestock(new \DateTime());
        $fcoins->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'fcoins'));


        $form = $this->createFormBuilder($fcoins)
            ->add('libelle', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
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
  return $this->render('IstokIstokBundle:fcoins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($fcoins);       
                        $em->flush();       
                       // $msg='Add fcoins Success' ;   
                     return $this->redirectToRoute('fcoins');


                }


        return $this->render('IstokIstokBundle:fcoins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier FAUX COIN";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $fcoins = $em->getRepository('IstokIstokBundle:fcoins')->findOneBy(array('etab' => $etab));


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($fcoins)
            
            ->add('libelle', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
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
  return $this->render('IstokIstokBundle:fcoins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($fcoins);       
                        $em->flush();       
                       // $msg='Add fcoins Success' ;   
                        return $this->redirectToRoute('fcoins');


                }


        return $this->render('IstokIstokBundle:fcoins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $fcoins=$em->find('IstokIstokBundle:fcoins',$id);
        
        $etab2 = $fcoins->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('fcoins');
        }


        if(!$fcoins)
        {

            throw $this->createNotFoundException('fcoins not found');
            
        }
        $em->remove($fcoins);       
        $em->flush();   
        //$msg='delete fcoins Succes' ;   
       // return new Response('delete fcoins Success =D') ;   
        return $this->redirectToRoute('fcoins');

    }




}
