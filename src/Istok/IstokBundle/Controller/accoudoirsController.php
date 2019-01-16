<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\accoudoirs;
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

class accoudoirsController extends Controller
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
        $accoudoirs=$em->getRepository('IstokIstokBundle:accoudoirs')->findById($idart);

        if(empty($accoudoirs)){return new Response(0);}

        $qte=$accoudoirs[0]->getquantite();
        $prix=$accoudoirs[0]->getprix();
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
        $accoudoirs=$em->getRepository('IstokIstokBundle:accoudoirs')->findById($idart);


        if(empty($accoudoirs)){return new Response(0);}

        $prix=$accoudoirs[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $accoudoirs=$em->getRepository('IstokIstokBundle:accoudoirs')->findByetab($etab);

        return $this->render('IstokIstokBundle:accoudoirs:list.html.twig',array('accoudoirss'=>$accoudoirs));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article accoudoirs';

        $em=$this->getDoctrine()->getManager();
        $accoudoirs = new accoudoirs();
        /*$accoudoirs->setNom('kamal');
        $accoudoirs->setPrenom('palkamal');
        $accoudoirs->setDatenaissance(new \DateTime('tomorrow'));*/

        //$accoudoirs->setdatestock(new \DateTime());
        $accoudoirs->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'accoudoirs'));


        $form = $this->createFormBuilder($accoudoirs)
            ->add('reference', TextType::class)
            ->add('metrage', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 1000)))
            ->add('file')

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:accoudoirs:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $accoudoirs->upload();

                        $em->persist($accoudoirs);       
                        $em->flush();       
                       // $msg='Add accoudoirs Success' ;   
                     return $this->redirectToRoute('accoudoirs');


                }


        return $this->render('IstokIstokBundle:accoudoirs:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier ACCOUDOIRS";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $accoudoirs = $em->getRepository('IstokIstokBundle:accoudoirs')->find($id);



        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($accoudoirs)
            
            ->add('reference', TextType::class)
            ->add('metrage', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 1000)))
            ->add('file')


            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
   /* $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:accoudoirs:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
                        $accoudoirs->upload();

        $em->persist($accoudoirs);       
                        $em->flush();       
                       // $msg='Add accoudoirs Success' ;   
                        return $this->redirectToRoute('accoudoirs');


                }


        return $this->render('IstokIstokBundle:accoudoirs:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $accoudoirs=$em->find('IstokIstokBundle:accoudoirs',$id);
        
        $etab2 = $accoudoirs->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('accoudoirs');
        }


        if(!$accoudoirs)
        {

            throw $this->createNotFoundException('accoudoirs not found');
            
        }
        $em->remove($accoudoirs);       
        $em->flush();   
        //$msg='delete accoudoirs Succes' ;   
       // return new Response('delete accoudoirs Success =D') ;   
        return $this->redirectToRoute('accoudoirs');

    }




}
