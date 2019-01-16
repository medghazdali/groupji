<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\mida;
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

class midaController extends Controller
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
        $mida=$em->getRepository('IstokIstokBundle:mida')->findById($idart);

        if(empty($mida)){return new Response(0);}

        $qte=$mida[0]->getquantite();
        $prix=$mida[0]->getprix();
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
        $mida=$em->getRepository('IstokIstokBundle:mida')->findById($idart);


        if(empty($mida)){return new Response(0);}

        $prix=$mida[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $mida=$em->getRepository('IstokIstokBundle:mida')->findByetab($etab);

        return $this->render('IstokIstokBundle:mida:list.html.twig',array('midas'=>$mida));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter article mida';

        $em=$this->getDoctrine()->getManager();
        $mida = new mida();
        /*$mida->setNom('kamal');
        $mida->setPrenom('palkamal');
        $mida->setDatenaissance(new \DateTime('tomorrow'));*/

        //$mida->setdatestock(new \DateTime());
        $mida->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'mida'));


        $form = $this->createFormBuilder($mida)
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
  return $this->render('IstokIstokBundle:mida:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $mida->upload();
                        
                        $em->persist($mida);       
                        $em->flush();       
                       // $msg='Add mida Success' ;   
                     return $this->redirectToRoute('mida');


                }


        return $this->render('IstokIstokBundle:mida:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction($id,Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier midaSIER";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $mida = $em->getRepository('IstokIstokBundle:mida')->find($id);



//var_dump($mida);
        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($mida)
            
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
  return $this->render('IstokIstokBundle:mida:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
                        $mida->upload();

                        $em->persist($mida);       
                        $em->flush();       
                       // $msg='Add mida Success' ;   
                        return $this->redirectToRoute('mida');


                }


        return $this->render('IstokIstokBundle:mida:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $mida=$em->find('IstokIstokBundle:mida',$id);
        
        $etab2 = $mida->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('mida');
        }


        if(!$mida)
        {

            throw $this->createNotFoundException('mida not found');
            
        }
        $em->remove($mida);       
        $em->flush();   
        //$msg='delete mida Succes' ;   
       // return new Response('delete mida Success =D') ;   
        return $this->redirectToRoute('mida');

    }




}
