<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\parametres;
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

class parametresController extends Controller
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
        $parametres=$em->getRepository('IstokIstokBundle:parametres')->findById($idart);

        if(empty($parametres)){return new Response(0);}

        $qte=$parametres[0]->getquantite();
        $prix=$parametres[0]->getprix();
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
        $parametres=$em->getRepository('IstokIstokBundle:parametres')->findById($idart);


        if(empty($parametres)){return new Response(0);}

        $prix=$parametres[0]->getprix();

    return new Response($prix);

    }







    public function listAction()
    {
       
        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $parametres=$em->getRepository('IstokIstokBundle:parametres')->findByetab($etab);

        return $this->render('IstokIstokBundle:parametres:list.html.twig',array('parametress'=>$parametres));

    }



     public function addAction(Request $request)
    {
        // create a task and give it some dummy data for this example

        $etab=$this->get_identity()->getetab();

//        var_dump($etab);    

        $msg='Ajouter remise';

        $em=$this->getDoctrine()->getManager();
        $parametres = new parametres();
        /*$parametres->setNom('kamal');
        $parametres->setPrenom('palkamal');
        $parametres->setDatenaissance(new \DateTime('tomorrow'));*/

        //$parametres->setdatestock(new \DateTime());
        $parametres->setetab($etab);

        //$categories=$em->getRepository('IstokIstokBundle:categories')->findAll();
        //$listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab,'type'=>'parametres'));


        $form = $this->createFormBuilder($parametres)
            ->add('remise', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

  /*  $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:parametres:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}

*/
                        $em->persist($parametres);       
                        $em->flush();       
                       // $msg='Add parametres Success' ;   
                     return $this->redirectToRoute('parametres');


                }


        return $this->render('IstokIstokBundle:parametres:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    


         public function editAction(Request $request)
    {
        // create a task and give it some dummy data for this example


        $msg="Modifier la remise";
        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();
        $parametres = $em->getRepository('IstokIstokBundle:parametres')->findOneBy(array('etab' => $etab));


        $listcategorie = $em->getRepository('IstokIstokBundle:categories')->findBy(array('etab' => $etab));


        $form = $this->createFormBuilder($parametres)
            
            ->add('remise', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();
             $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                
   /* $data = $form->getData();
$prix=$data->getprix();
$qte=$data->getquantite();

if($qte<=0 or $prix<=0){
  return $this->render('IstokIstokBundle:parametres:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg,'errors'=>'erreur de saisie d\'information'
        ));
}
   */
        $em->persist($parametres);       
                        $em->flush();       
                       // $msg='Add parametres Success' ;   
                        return $this->redirectToRoute('remise');


                }


        return $this->render('IstokIstokBundle:parametres:add.html.twig', array(
            'form' => $form->createView(),'msg'=>$msg
        ));
    }
    



 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $parametres=$em->find('IstokIstokBundle:parametres',$id);
        
        $etab2 = $parametres->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('parametres');
        }


        if(!$parametres)
        {

            throw $this->createNotFoundException('parametres not found');
            
        }
        $em->remove($parametres);       
        $em->flush();   
        //$msg='delete parametres Succes' ;   
       // return new Response('delete parametres Success =D') ;   
        return $this->redirectToRoute('parametres');

    }




}
