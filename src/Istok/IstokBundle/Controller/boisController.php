<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\bois;
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

class boisController extends Controller
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
        $bois=$em->getRepository('IstokIstokBundle:bois')->findById($idart);

        if(empty($bois)){return new Response(0);}

        $qte=$bois[0]->getquantite();
        $prix=$bois[0]->getprix();
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
        $bois=$em->getRepository('IstokIstokBundle:bois')->findById($idart);


        if(empty($bois)){return new Response(0);}

        $prix=$bois[0]->getprix();

    return new Response($prix);

    }




    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $bois=$em->getRepository('IstokIstokBundle:bois')->findByetab($etab);

        return $this->render('IstokIstokBundle:bois:list.html.twig',array('boiss'=>$bois));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article bois';

        $em=$this->getDoctrine()->getManager();
        $bois = new bois();
        /*$bois->setNom('kamal');
        $bois->setPrenom('palkamal');
        $bois->setDatenaissance(new \DateTime('tomorrow'));*/

        $bois->setdatestock(new \DateTime());
        $bois->setetab($etab);

        $categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'bois'));
        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($bois)
            ->add('reference', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('categories',  EntityType::class,
             array( 'label' => 'categorie client','class' => 'IstokIstokBundle:categories','choice_label' => 'categorie',
                    'choices' => $listcategorie,
                    ))

            ->add('file')

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:bois:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $bois->upload();

                        $em->persist($bois);       
                        $em->flush();       
                       // $msg='Add bois Success' ;   
                     return $this->redirectToRoute('bois');


                }


        return $this->render('IstokIstokBundle:bois:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier L'bois";

        $em=$this->getDoctrine()->getManager();
        $bois = $em->getRepository('IstokIstokBundle:bois')->find($id);
        $etab=$this->get_identity()->getetab();

        $etab2 = $bois->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('bois');
        }







           $bois->setdatestock($bois->getdatestock());
        $bois->setreference($bois->getreference());

        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));

     $form = $this->createFormBuilder($bois)
            ->add('reference', TextType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('categories',  EntityType::class,
             array( 'label' => 'categorie client','class' => 'IstokIstokBundle:categories','choice_label' => 'categorie',
                    'choices' => $listcategorie,
                    ))

            ->add('file')

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
   /* $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:bois:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}*/
                        $bois->upload();

        $em->persist($bois);       
                        $em->flush();       
                       // $msg='Add bois Success' ;   
                        return $this->redirectToRoute('bois');


                }


        return $this->render('IstokIstokBundle:bois:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $bois=$em->find('IstokIstokBundle:bois',$id);
        
        $etab2 = $bois->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('bois');
        }


        if(!$bois)
        {

            throw $this->createNotFoundException('bois not found');
            
        }
        $em->remove($bois);       
        $em->flush();   
        //$msg='delete bois Succes' ;   
       // return new Response('delete bois Success =D') ;   
        return $this->redirectToRoute('bois');

    }




}
