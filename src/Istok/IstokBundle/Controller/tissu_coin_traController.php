<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\tissu_coin_tra;
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

class tissu_coin_traController extends Controller
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
        $tissu_coin_tra=$em->getRepository('IstokIstokBundle:tissu_coin_tra')->findById($idart);

        if(empty($tissu_coin_tra)){return new Response(0);}

        $qte=$tissu_coin_tra[0]->getquantite();
        $prix=$tissu_coin_tra[0]->getprix();
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
        $tissu_coin_tra=$em->getRepository('IstokIstokBundle:tissu_coin_tra')->findById($idart);


        if(empty($tissu_coin_tra)){return new Response(0);}

        $prix=$tissu_coin_tra[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $tissu_coin_tra=$em->getRepository('IstokIstokBundle:tissu_coin_tra')->findByetab($etab);

        return $this->render('IstokIstokBundle:tissu_coin_tra:list.html.twig',array('tissu_coin_tras'=>$tissu_coin_tra));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article tissu_coin_tra';

        $em=$this->getDoctrine()->getManager();
        $tissu_coin_tra = new tissu_coin_tra();
        /*$tissu_coin_tra->setNom('kamal');
        $tissu_coin_tra->setPrenom('palkamal');
        $tissu_coin_tra->setDatenaissance(new \DateTime('tomorrow'));*/

        //$tissu_coin_tra->setdatestock(new \DateTime());
        $tissu_coin_tra->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'tissu_coin_tra'));


        $form = $this->createFormBuilder($tissu_coin_tra)
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
  return $this->render('IstokIstokBundle:tissu_coin_tra:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($tissu_coin_tra);       
                        $em->flush();       
                       // $msg='Add tissu_coin_tra Success' ;   
                     return $this->redirectToRoute('tissu_coin_tra');


                }


        return $this->render('IstokIstokBundle:tissu_coin_tra:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier COIN";
      $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $tissu_coin_tra = $em->getRepository('IstokIstokBundle:tissu_coin_tra')->findOneBy(array('etab' => $etab));
          $etab2 = $tissu_coin_tra->getetab();


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($tissu_coin_tra)
            
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
  return $this->render('IstokIstokBundle:tissu_coin_tra:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($tissu_coin_tra);       
                        $em->flush();       
                       // $msg='Add tissu_coin_tra Success' ;   
                        return $this->redirectToRoute('tissu_coin_tra');


                }


        return $this->render('IstokIstokBundle:tissu_coin_tra:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $tissu_coin_tra=$em->find('IstokIstokBundle:tissu_coin_tra',$id);
        
        $etab2 = $tissu_coin_tra->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('tissu_coin_tra');
        }


        if(!$tissu_coin_tra)
        {

            throw $this->createNotFoundException('tissu_coin_tra not found');
            
        }
        $em->remove($tissu_coin_tra);       
        $em->flush();   
        //$msg='delete tissu_coin_tra Succes' ;   
       // return new Response('delete tissu_coin_tra Success =D') ;   
        return $this->redirectToRoute('tissu_coin_tra');

    }




}
