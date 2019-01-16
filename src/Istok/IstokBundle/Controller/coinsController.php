<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\coins;
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

class coinsController extends Controller
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
        $coins=$em->getRepository('IstokIstokBundle:coins')->findById($idart);

        if(empty($coins)){return new Response(0);}

        $qte=$coins[0]->getquantite();
        $prix=$coins[0]->getprix();
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
        $coins=$em->getRepository('IstokIstokBundle:coins')->findById($idart);


        if(empty($coins)){return new Response(0);}

        $prix=$coins[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $coins=$em->getRepository('IstokIstokBundle:coins')->findByetab($etab);

        return $this->render('IstokIstokBundle:coins:list.html.twig',array('coinss'=>$coins));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article coins';

        $em=$this->getDoctrine()->getManager();
        $coins = new coins();
        /*$coins->setNom('kamal');
        $coins->setPrenom('palkamal');
        $coins->setDatenaissance(new \DateTime('tomorrow'));*/

        //$coins->setdatestock(new \DateTime());
        $coins->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'coins'));


        $form = $this->createFormBuilder($coins)
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
  return $this->render('IstokIstokBundle:coins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($coins);       
                        $em->flush();       
                       // $msg='Add coins Success' ;   
                     return $this->redirectToRoute('coins');


                }


        return $this->render('IstokIstokBundle:coins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier COIN";
      $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $coins = $em->getRepository('IstokIstokBundle:coins')->findOneBy(array('etab' => $etab));
          $etab2 = $coins->getetab();


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($coins)
            
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
  return $this->render('IstokIstokBundle:coins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($coins);       
                        $em->flush();       
                       // $msg='Add coins Success' ;   
                        return $this->redirectToRoute('coins');


                }


        return $this->render('IstokIstokBundle:coins:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $coins=$em->find('IstokIstokBundle:coins',$id);
        
        $etab2 = $coins->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('coins');
        }


        if(!$coins)
        {

            throw $this->createNotFoundException('coins not found');
            
        }
        $em->remove($coins);       
        $em->flush();   
        //$msg='delete coins Succes' ;   
       // return new Response('delete coins Success =D') ;   
        return $this->redirectToRoute('coins');

    }




}
