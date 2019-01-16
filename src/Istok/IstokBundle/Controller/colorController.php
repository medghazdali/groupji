<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\color;
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

class colorController extends Controller
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
        $color=$em->getRepository('IstokIstokBundle:color')->findById($idart);

        if(empty($color)){return new Response(0);}

        $qte=$color[0]->getquantite();
        $prix=$color[0]->getprix();
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
        $color=$em->getRepository('IstokIstokBundle:color')->findById($idart);


        if(empty($color)){return new Response(0);}

        $prix=$color[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $color=$em->getRepository('IstokIstokBundle:color')->findByetab($etab);

        return $this->render('IstokIstokBundle:color:list.html.twig',array('colors'=>$color));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter couleur';

        $em=$this->getDoctrine()->getManager();
        $color = new color();
        /*$color->setNom('kamal');
        $color->setPrenom('palkamal');
        $color->setDatenaissance(new \DateTime('tomorrow'));*/

        //$color->setdatestock(new \DateTime());
        $color->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'color'));


        $form = $this->createFormBuilder($color)
            ->add('couleur', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:color:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($color);       
                        $em->flush();       
                       // $msg='Add color Success' ;   
                     return $this->redirectToRoute('color');


                }


        return $this->render('IstokIstokBundle:color:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier colorSIER";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $color = $em->getRepository('IstokIstokBundle:color')->findOneBy(array('etab' => $etab));


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($color)
            
            ->add('couleur', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
   /* $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:color:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($color);       
                        $em->flush();       
                       // $msg='Add color Success' ;   
                        return $this->redirectToRoute('color');


                }


        return $this->render('IstokIstokBundle:color:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $color=$em->find('IstokIstokBundle:color',$id);
        
        $etab2 = $color->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('color');
        }


        if(!$color)
        {

            throw $this->createNotFoundException('color not found');
            
        }
        $em->remove($color);       
        $em->flush();   
        //$msg='delete color Succes' ;   
       // return new Response('delete color Success =D') ;   
        return $this->redirectToRoute('color');

    }




}
