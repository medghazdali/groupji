<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

class CategoriesController extends Controller
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


    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $Categories=$em->getRepository('IstokIstokBundle:categories')->findByetab($etab);
        return $this->render('IstokIstokBundle:Categories:list.html.twig',array('Categories'=>$Categories));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg='Ajouter Categories Article';

        $em=$this->getDoctrine()->getManager();
        $Categories = new categories();



        $etab=$this->get_identity()->getetab();
        $Categories->setetab($etab);



            $form = $this->createFormBuilder($Categories)
            ->add('categorie', TextType::class)
            ->add('type', ChoiceType::class, array(
            'choices'  => array(
            'Bois'=>'Bois',
            'Banquettes'=>'Banquettes',
            'Tissu'=>'Tissu',
            'Couture'=>'Couture',
            'Garniture'=>'Garniture',
            ),
            ))    

            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($Categories);       
                        $em->flush();       
                       // $msg='Add Categories Success' ;   
                     return $this->redirectToRoute('Categories');


                }


        return $this->render('IstokIstokBundle:Categories:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example
        $msg="Modifier L'Categories";

        $em=$this->getDoctrine()->getManager();
        $Categories = $em->getRepository('IstokIstokBundle:categories')->find($id);
      
        $etab2 = $Categories->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('Categories');
        }


        $form = $this->createFormBuilder($Categories)
            ->add('categorie', TextType::class)
            ->add('type', ChoiceType::class, array(
            'choices'  => array(
            'Bois'=>'Bois',
            'Banquettes'=>'Banquettes',
            'Tissu'=>'Tissu',
            'Couture'=>'Couture',
            'Garniture'=>'Garniture',
            ),
            ))            
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                           $em->persist($Categories);       
                        $em->flush();       
                       // $msg='Add Categories Success' ;   
                     return $this->redirectToRoute('Categories');


                }

        return $this->render('IstokIstokBundle:Categories:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $Categories=$em->find('IstokIstokBundle:Categories',$id);


        $etab2 = $Categories->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('Categories');
        }

        if(!$Categories)
        {

            throw $this->createNotFoundException('Categories not found');
            
        }
        $em->remove($Categories);       
        $em->flush();   
        //$msg='delete Categories Succes' ;   
       // return new Response('delete Categories Success =D') ;   
                        return $this->redirectToRoute('Categories');

    }




    public function getcatsAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $idart=$request->get('id');

        if(empty($idart)){return new Response(0);}
        $bois=$em->getRepository('IstokIstokBundle:bois')->findBy(array('categories'=>$idart));

$tab=[];

foreach ($bois as $key => $value) {

$idd=$value->getId();
$ref=$value->getreference();
$prix=$value->getprix();
$path=$value->getpath();


$ind=["id"=>$idd,"ref"=>$ref,"prix"=>$prix,"path"=>$path];

array_push($tab, $ind);


}

//var_dump($tab);
      
        if(empty($bois)){return new Response(0);}


        $response = new Response(json_encode($tab));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }




}
