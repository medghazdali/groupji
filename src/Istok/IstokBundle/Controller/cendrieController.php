<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\cendrie;
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

class cendrieController extends Controller
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
        $cendrie=$em->getRepository('IstokIstokBundle:cendrie')->findById($idart);

        if(empty($cendrie)){return new Response(0);}

        $qte=$cendrie[0]->getquantite();
        $prix=$cendrie[0]->getprix();
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
        $cendrie=$em->getRepository('IstokIstokBundle:cendrie')->findById($idart);


        if(empty($cendrie)){return new Response(0);}

        $prix=$cendrie[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $cendrie=$em->getRepository('IstokIstokBundle:cendrie')->findByetab($etab);

        return $this->render('IstokIstokBundle:cendrie:list.html.twig',array('cendries'=>$cendrie));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article cendrie';

        $em=$this->getDoctrine()->getManager();
        $cendrie = new cendrie();
        /*$cendrie->setNom('kamal');
        $cendrie->setPrenom('palkamal');
        $cendrie->setDatenaissance(new \DateTime('tomorrow'));*/

        //$cendrie->setdatestock(new \DateTime());
        $cendrie->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'cendrie'));


        $form = $this->createFormBuilder($cendrie)
            ->add('ref', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('file')

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:cendrie:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $cendrie->upload();
                        
                        $em->persist($cendrie);       
                        $em->flush();       
                       // $msg='Add cendrie Success' ;   
                     return $this->redirectToRoute('cendrie');


                }


        return $this->render('IstokIstokBundle:cendrie:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier cendrieSIER";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $cendrie = $em->getRepository('IstokIstokBundle:cendrie')->find($id);


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($cendrie)
            
            ->add('ref', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('file')
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
   /* $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:cendrie:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
                        $cendrie->upload();

                        $em->persist($cendrie);       
                        $em->flush();       
                       // $msg='Add cendrie Success' ;   
                        return $this->redirectToRoute('cendrie');


                }


        return $this->render('IstokIstokBundle:cendrie:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $cendrie=$em->find('IstokIstokBundle:cendrie',$id);
        
        $etab2 = $cendrie->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('cendrie');
        }


        if(!$cendrie)
        {

            throw $this->createNotFoundException('cendrie not found');
            
        }
        $em->remove($cendrie);       
        $em->flush();   
        //$msg='delete cendrie Succes' ;   
       // return new Response('delete cendrie Success =D') ;   
        return $this->redirectToRoute('cendrie');

    }




}
