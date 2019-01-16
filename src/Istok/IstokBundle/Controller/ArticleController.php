<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\article;
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

class ArticleController extends Controller
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
        $article=$em->getRepository('IstokIstokBundle:article')->findById($idart);

        if(empty($article)){return new Response(0);}

        $qte=$article[0]->getquantite();
        $prix=$article[0]->getprix();
        $jsn=array('qte' => $qte,'prix'=>$prix);

        $response = new Response(json_encode($jsn));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
                
   //return new Response($qte);
    }


    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $article=$em->getRepository('IstokIstokBundle:article')->findByetab($etab);

        return $this->render('IstokIstokBundle:Article:list.html.twig',array('articles'=>$article));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter Article';

        $em=$this->getDoctrine()->getManager();
        $Article = new article();
        /*$Article->setNom('kamal');
        $Article->setPrenom('palkamal');
        $Article->setDatenaissance(new \DateTime('tomorrow'));*/

        $Article->setdatestock(new \DateTime());
        $Article->setreference(uniqid());
        $Article->setetab($etab);

        $categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($Article)
            ->add('article', TextType::class)
            ->add('description', TextareaType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('quantite', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('categories',  EntityType::class, array(
            'class' => 'IstokIstokBundle:categories',
                    'choice_label' => 'categorie','multiple'=>false
                    ))


            ->add('categories',  EntityType::class,
             array( 'label' => 'categorie client','class' => 'IstokIstokBundle:categories','choice_label' => 'categorie',
                    'choices' => $listcategorie,
                    ))


            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

    $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:Article:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}


                        $em->persist($Article);       
                        $em->flush();       
                       // $msg='Add Article Success' ;   
                     return $this->redirectToRoute('article');


                }


        return $this->render('IstokIstokBundle:Article:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier L'article";

        $em=$this->getDoctrine()->getManager();
        $Article = $em->getRepository('IstokIstokBundle:article')->find($id);
        $etab=$this->get_identity()->getetab();

        $etab2 = $Article->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('article');
        }







           $Article->setdatestock($Article->getdatestock());
        $Article->setreference($Article->getreference());

        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($Article)
            ->add('article', TextType::class)
            ->add('description', TextareaType::class)
            ->add('prix', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))
            ->add('quantite', NumberType::class, array(
            'attr' => array('min' => 1, 'max' => 100)))

           ->add('categories',  EntityType::class, array(
            'class' => 'IstokIstokBundle:categories',
                    'choice_label' => 'categorie','multiple'=>false
                    ))


            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
    $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:Article:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
        $em->persist($Article);       
                        $em->flush();       
                       // $msg='Add Article Success' ;   
                        return $this->redirectToRoute('article');


                }


        return $this->render('IstokIstokBundle:Article:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $article=$em->find('IstokIstokBundle:article',$id);
        
        $etab2 = $article->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('article');
        }


        if(!$article)
        {

            throw $this->createNotFoundException('article not found');
            
        }
        $em->remove($article);       
        $em->flush();   
        //$msg='delete article Succes' ;   
       // return new Response('delete article Success =D') ;   
        return $this->redirectToRoute('article');

    }




}
