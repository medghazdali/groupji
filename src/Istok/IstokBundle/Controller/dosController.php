<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\dos;
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

class dosController extends Controller
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
        $dos=$em->getRepository('IstokIstokBundle:dos')->findById($idart);

        if(empty($dos)){return new Response(0);}

        $qte=$dos[0]->getquantite();
        $prix=$dos[0]->getprix();
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
        $dos=$em->getRepository('IstokIstokBundle:dos')->findById($idart);


        if(empty($dos)){return new Response(0);}

        $prix=$dos[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $dos=$em->getRepository('IstokIstokBundle:dos')->findByetab($etab);

        return $this->render('IstokIstokBundle:dos:list.html.twig',array('doss'=>$dos));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article dos';

        $em=$this->getDoctrine()->getManager();
        $dos = new dos();
        /*$dos->setNom('kamal');
        $dos->setPrenom('palkamal');
        $dos->setDatenaissance(new \DateTime('tomorrow'));*/

        //$dos->setdatestock(new \DateTime());
        $dos->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'dos'));


        $form = $this->createFormBuilder($dos)
            ->add('libelle', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:dos:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($dos);       
                        $em->flush();       
                       // $msg='Add dos Success' ;   
                     return $this->redirectToRoute('dos');


                }


        return $this->render('IstokIstokBundle:dos:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier DOSSIER";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $dos = $em->getRepository('IstokIstokBundle:dos')->findOneBy(array('etab' => $etab));


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($dos)
            
            ->add('libelle', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
   /* $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:dos:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($dos);       
                        $em->flush();       
                       // $msg='Add dos Success' ;   
                        return $this->redirectToRoute('dos');


                }


        return $this->render('IstokIstokBundle:dos:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $dos=$em->find('IstokIstokBundle:dos',$id);
        
        $etab2 = $dos->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('dos');
        }


        if(!$dos)
        {

            throw $this->createNotFoundException('dos not found');
            
        }
        $em->remove($dos);       
        $em->flush();   
        //$msg='delete dos Succes' ;   
       // return new Response('delete dos Success =D') ;   
        return $this->redirectToRoute('dos');

    }




}
