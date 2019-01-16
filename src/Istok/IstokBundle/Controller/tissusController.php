<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\banquette;
use Istok\IstokBundle\Entity\tissus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class tissusController extends Controller
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



    public function getTissusAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        //$cat_tissusId=$request->get('id');
        $cat_tissusId=$request->get('id');

        if(empty($cat_tissusId)){return new Response(0);}
        $tissus=$em->getRepository('IstokIstokBundle:tissus')->findBy(array('cat_tissus'=>$cat_tissusId));

        $tab=[];

        foreach ($tissus as $key => $value) {

        $idd=$value->getId();
        $ref=$value->getReference();
        $prix=$value->getPrix();
        $path=$value->getpath();



        $ind=["id"=>$idd,"ref"=>$ref,"prix"=>$prix,"path"=>$path];

        array_push($tab, $ind);


        }

        //var_dump($tab);

        if(empty($tissus)){return new Response(0);}


        $response = new Response(json_encode($tab));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }


    public function qteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $idart=$request->get('idart');
        if(empty($idart)){return new Response(0);}
        $banquette=$em->getRepository('IstokIstokBundle:banquette')->findById($idart);

        if(empty($banquette)){return new Response(0);}

        $qte=$banquette[0]->getquantite();
        $prix=$banquette[0]->getprix();
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
        $banquette=$em->getRepository('IstokIstokBundle:banquette')->findById($idart);


        if(empty($banquette)){return new Response(0);}

        $prix=$banquette[0]->getprix();

    return new Response($prix);

    }




    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $tissus=$em->getRepository('IstokIstokBundle:tissus')->findByetab($etab);

        return $this->render('IstokIstokBundle:tissus:list.html.twig',array('tissus'=>$tissus));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter tissu';

        $em=$this->getDoctrine()->getManager();
        $tissus = new tissus();
        $tissus->setetab($etab);
        $cat_tissus = $em->getRepository('IstokIstokBundle:cat_tissus')->findBy(array('etab' => $etab));

        $form = $this->createFormBuilder($tissus)
            ->add('reference', TextType::class)
            ->add('prix', NumberType::class)
            ->add('cat_tissus',  EntityType::class,
             array( 'label' => 'categorie tissus','class' => 'IstokIstokBundle:cat_tissus','choice_label' => 'categorie',
                    'choices' => $cat_tissus,
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
  return $this->render('IstokIstokBundle:tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $tissus->upload();

                        $em->persist($tissus);       
                        $em->flush();       
                       // $msg='Add tissus Success' ;   
                     return $this->redirectToRoute('tissus');


                }


        return $this->render('IstokIstokBundle:tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier tissu";

        $em=$this->getDoctrine()->getManager();
        $tissus = $em->getRepository('IstokIstokBundle:tissus')->find($id);
        $etab=$this->get_identity()->getetab();
        $cat_tissus = $em->getRepository('IstokIstokBundle:cat_tissus')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($tissus)
            ->add('reference', TextType::class)
            ->add('prix', NumberType::class)
            ->add('cat_tissus',  EntityType::class,
             array( 'label' => 'categorie tissus','class' => 'IstokIstokBundle:cat_tissus','choice_label' => 'categorie',
                    'choices' => $cat_tissus,
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
  return $this->render('IstokIstokBundle:tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/

                        $tissus->upload();
                        $em->persist($tissus);       
                        $em->flush();       
                       // $msg='Add tissus Success' ;   
                     return $this->redirectToRoute('tissus');


                }


                


        return $this->render('IstokIstokBundle:tissus:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $banquette=$em->find('IstokIstokBundle:tissus',$id);
        
        $etab2 = $banquette->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('tissus');
        }


        if(!$banquette)
        {

            throw $this->createNotFoundException('tissus not found');
            
        }
        $em->remove($banquette);       
        $em->flush();   
        //$msg='delete banquette Succes' ;   
       // return new Response('delete banquette Success =D') ;   
        return $this->redirectToRoute('tissus');

    }




}
