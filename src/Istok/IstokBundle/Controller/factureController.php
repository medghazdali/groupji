<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\facture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class factureController extends Controller
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
                       $etab=$this->get_identity()->getetab();
                       
        $em=$this->getDoctrine()->getManager();
        $facture=$em->getRepository('IstokIstokBundle:facture')->findByetab($etab);
        return $this->render('IstokIstokBundle:facture:list.html.twig',array('factures'=>$facture));

    }



     public function addAction(Request $request)
    {


        $em=$this->getDoctrine()->getManager();
        $facture = new facture();
        $id=$request->get('id');
        $nfac=$request->get('nfac');

        $vente=$em->getRepository('IstokIstokBundle:vente')->findOneById($id);

        $etab=$this->get_identity()->getetab();
        $facture->setetab($etab);
        $user=$this->get_identity();

        $facture->setuser($user);



        $facture->setreference($nfac);
        $facture->setdatestock(new \DateTime('today'));
        $facture->setvente($vente);


        $em->persist($facture);       
        $em->flush();


        return $this->redirectToRoute('facture');


    }


    


}
