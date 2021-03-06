<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\vente;
use Istok\IstokBundle\Entity\client;
use Istok\IstokBundle\Entity\facilite;
use Istok\IstokBundle\Entity\ligne_cmd;
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
use JMS\SecurityExtraBundle\Annotation\Secure;

class VenteController extends Controller
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
        $ventes=$em->getRepository('IstokIstokBundle:vente')->findBy(array('etab'=>$etab,'type'=>0));
        return $this->render('IstokIstokBundle:Vente:list.html.twig',array('ventes'=>$ventes));

    }

    public function vente_detailAction(Request $request)
    {
        $id=$request->get('id');

        $em=$this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();

        $vente=$em->getRepository('IstokIstokBundle:vente')->findOneById($id);
        $etab=$em->getRepository('IstokIstokBundle:etab')->findById($etab->getid());
        $etab=$etab[0]->getetab();
        $idcmd=$vente->getid();
        $ligne_cmds=$em->getRepository('IstokIstokBundle:ligne_cmd')->findByVente($vente);
        $art = array();


        return $this->render('IstokIstokBundle:Vente:detail.html.twig',array('etab'=>$etab,'vente'=>$vente,'ligne_cmds'=>$ligne_cmds));

    }

    /**
 * @Route("/vente/edit", name="home") 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 */
     public function editAction($id,Request $request)
    {
      
        $etab=$this->get_identity()->getetab();
        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('IstokIstokBundle:article')->findByetab($etab);
       // $vente=$em->getRepository('IstokIstokBundle:vente')->findByetab($etab);
        //$idv=end($vente);
        $faciliteid="";

        $vente=$em->getRepository('IstokIstokBundle:vente')->find($id);
        $idv=$vente->getid();
        $idvente=$vente->getid();

        $client=$vente->getclient();
        $facilite=$vente->getfacilite();
        if(!is_null($facilite)){

        $faciliteid=$vente->getfacilite()->getid();

        }



        $ligne_cmd=$em->getRepository('IstokIstokBundle:ligne_cmd')->findByVente($idvente);

        $qtes=[];
        $prices=[];
        $listId=[];
        $articles2=[];

        foreach ($ligne_cmd as $value) {
            # code...
            //var_dump($value);
            array_push($qtes, $value->getquantite());
            array_push($prices, $value->getprix());
            array_push($listId, $value->getidcmd());
            array_push($articles2, $value->getarticle()->getid());


        }

        $listtype = $em->getRepository('IstokIstokBundle:type')->findBy(array('etab' => $etab));
        $facilites=$em->getRepository('IstokIstokBundle:facilite')->findByetab($etab);


         $form = $this->createFormBuilder($client)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('tel', TextType::class)
            ->add('cin', TextType::class)
            ->add('type',  EntityType::class,
             array( 'label' => 'Type de client','class' => 'IstokIstokBundle:type','choice_label' => 'type',
                    'choices' => $listtype,
                    ))
            ->getForm();


        return $this->render('IstokIstokBundle:Vente:edit.html.twig',array('articles'=>$articles,'form'=>$form->createView(),'facilites'=>$facilites,'idv'=>$idv,'faciliteid'=>$faciliteid,'vente'=>$vente,'ligne_cmds'=>$ligne_cmd,'qtes'=>$qtes,'prices'=>$prices,'listId'=>$listId,'articles2'=>$articles2));

    }








    
    public function dessinAction(){    


        $etab=$this->get_identity()->getetab();

        $em=$this->getDoctrine()->getManager();

        $bois=$em->getRepository('IstokIstokBundle:bois')->findByetab($etab);
        $coin_metrage=$em->getRepository('IstokIstokBundle:coins')->findOneByetab($etab)->getmetrage();
        $face_metrage=$em->getRepository('IstokIstokBundle:face')->findOneByetab($etab)->getmetrage();
        $accoudoirs_metrage=$em->getRepository('IstokIstokBundle:accoudoirs')->findOneByetab($etab)->getmetrage();
        $dos_prix=$em->getRepository('IstokIstokBundle:dos')->findOneByetab($etab)->getprix();
        $fo_mertage=$em->getRepository('IstokIstokBundle:fcoins')->findOneByetab($etab)->getmetrage();
        $fo_prix=$em->getRepository('IstokIstokBundle:fcoins')->findOneByetab($etab)->getprix();
        $coin_tra=$em->getRepository('IstokIstokBundle:coin_tra')->findOneByetab($etab)->getmetrage();
        $coin_mod=$em->getRepository('IstokIstokBundle:coin_mod')->findOneByetab($etab)->getmetrage();
        $mida=$em->getRepository('IstokIstokBundle:mida')->findByetab($etab);
        $cendrie=$em->getRepository('IstokIstokBundle:cendrie')->findByetab($etab);
        $categories=$em->getRepository('IstokIstokBundle:categories')->findByetab($etab);
        $accoudoirs=$em->getRepository('IstokIstokBundle:accoudoirs')->findByetab($etab);
        $color=$em->getRepository('IstokIstokBundle:color')->findByetab($etab);
        $remise=$em->getRepository('IstokIstokBundle:parametres')->findOneByetab($etab)->getremise();
        $cat_banquettes=$em->getRepository('IstokIstokBundle:cat_banquettes')->findByetab($etab);
//        $banquettes=$em->getRepository('IstokIstokBundle:banquettes')->findByetab($etab);
        $banquette_coin_tra=$em->getRepository('IstokIstokBundle:banquette_coin_tra')->findOneByetab($etab)->getMetrage();
        $banquette_coin_mod=$em->getRepository('IstokIstokBundle:banquette_coin_mod')->findOneByetab($etab)->getMetrage();

        $cat_tissus=$em->getRepository('IstokIstokBundle:cat_tissus')->findByetab($etab);

        $Metrage_tissu_coin_mod=$em->getRepository('IstokIstokBundle:tissu_coin_mod')->findOneByetab($etab)->getMetrage();

        $Metrage_tissu_coin_tra=$em->getRepository('IstokIstokBundle:tissu_coin_tra')->findOneByetab($etab)->getMetrage();



     return $this->render('IstokIstokBundle:Vente:dessin.html.twig',array('remise'=>$remise,'colors'=>$color,'fo_prix'=>$fo_prix,'accoudoirs'=>$accoudoirs,'categories'=>$categories,'cendries'=>$cendrie,'midas'=>$mida,'coin_tra'=>$coin_tra,'coin_mod'=>$coin_mod,'fo_mertage'=>$fo_mertage,'dos_prix'=>$dos_prix,'bois'=>$bois,'coin_metrage'=>$coin_metrage,'face_metrage'=>$face_metrage,'accoudoirs_metrage'=>$accoudoirs_metrage,'cat_banquettes'=>$cat_banquettes,'banquette_coin_tra'=>$banquette_coin_tra,'banquette_coin_mod'=>$banquette_coin_mod,'cat_tissus'=>$cat_tissus,'Metrage_tissu_coin_mod'=>$Metrage_tissu_coin_mod,'Metrage_tissu_coin_tra'=>$Metrage_tissu_coin_tra));
    

    }






     public function addAction(Request $request)
    {
       
        $etab=$this->get_identity()->getetab();
        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('IstokIstokBundle:article')->findByetab($etab);
        $vente=$em->getRepository('IstokIstokBundle:vente')->findByetab($etab);
        $idv=end($vente);



        if(empty($idv))
            $idv=1;
        else{
              $idv=$idv->getid();
              $idv=$idv+1;
        }

        $facilites=$em->getRepository('IstokIstokBundle:facilite')->findByetab($etab);
        $listtype = $em->getRepository('IstokIstokBundle:type')->findBy(array('etab' => $etab));

        $client = new client();

         $form = $this->createFormBuilder($client)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('tel', TextType::class)
            ->add('cin', TextType::class)
            ->add('type',  EntityType::class,
             array( 'label' => 'Type de client','class' => 'IstokIstokBundle:type','choice_label' => 'type',
                    'choices' => $listtype,
                    ))

            ->getForm();





        return $this->render('IstokIstokBundle:Vente:add.html.twig',array('articles'=>$articles,'form'=>$form->createView(),'facilites'=>$facilites,'idv'=>$idv));

    }


     public function insertAction(Request $request)
    {
       
        $em=$this->getDoctrine()->getManager();

        $etab=$this->get_identity()->getetab();
        $user=$this->get_identity();
    
        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        $cin=$request->get('cin');
        $tel=$request->get('tel');
        $articles=$request->get('articles');
        $listId=$request->get('listId');
        $qtes=$request->get('qtes');
        $isavance=$request->get('isavance');
        $idv=$request->get('idv');
        $typeid=$request->get('type');

        //var_dump($listId);

        if($isavance==1){
        $avance=$request->get('avance');
        $facilite=$request->get('facilite');
        }else{
        $avance=0;
        $isavance=0;
        $facilite=null;
        }

        $remarque=$request->get('remarque');

        $facilite=$em->getRepository('IstokIstokBundle:facilite')->findOneById($facilite);
        $type=$em->getRepository('IstokIstokBundle:type')->findOneById($typeid);
        $client=$em->getRepository('IstokIstokBundle:client')->findOneBycin($cin);


    if(!isset($client)){
        $client = new client();
        $client->setnom($nom);
        $client->setprenom($prenom);
        $client->setcin($cin);
        $client->setetab($etab);
        $client->settype($type);

        $client->settel($tel);
//        $client->setreference("ref1");
        $client->setdate(new \DateTime());
    }

        $vente = new vente();
        $vente->setdate(new \DateTime());
        $vente->setisavance($isavance);
        $vente->setavance($avance);
        $vente->setclient($client);
        $vente->setfacilite($facilite);
        $vente->setremarque($remarque);
        $vente->setnum($idv);
        $vente->settype(0);
        $vente->setuser($user);
 
$totals=0;
$i=0;

        foreach ($articles as $articleID) {    


            $article=$em->getRepository('IstokIstokBundle:article')->findById($articleID);
            $article=$article[0];
            $qtestok=$article->getquantite();
            $totals=$totals+$article->getprix()*$qtes[$i];

            if($qtestok<$qtes[$i]){ return new Response('0'); }


            $article->setquantite($qtestok-$qtes[$i]);


            $ligne_cmd = new ligne_cmd();
            $ligne_cmd->setquantite($qtes[$i]);
            $ligne_cmd->setprix($article->getprix());
            $ligne_cmd->settotal($article->getprix()*$qtes[$i]);
            $ligne_cmd->setdate(new \DateTime());
            $ligne_cmd->setvente($vente);
            $ligne_cmd->setarticle($article);
            $ligne_cmd->setidcmd($listId[$i]);
            $ligne_cmd->setuser($user);
            $ligne_cmd->setetab($etab);

    //var_dump($article);
    //var_dump($ligne_cmd);

            $em->persist($ligne_cmd);

            $i++;

        }

        $vente->settotal($totals);

        if($isavance!=1){

        $avance=$totals;
        $isavance=0;
        $facilite=null;
        }
        $vente->setavance($avance);

        $vente->setetab($etab);


            $em->persist($client);
            $em->persist($vente);
            $em->flush();




return new Response("1");

    }



     public function updateAction(Request $request)
    {
       
        $em=$this->getDoctrine()->getManager();

        $etab=$this->get_identity()->getetab();

    
        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        $cin=$request->get('cin');
        $tel=$request->get('tel');
        $articles=$request->get('articles');
        $listId=$request->get('listId');
        $qtes=$request->get('qtes');
        $isavance=$request->get('isavance');
        $idv=$request->get('idv');

        $dejavente=$em->getRepository('IstokIstokBundle:vente')->findOneById($idv);
        $dejaclient=$dejavente->getclient();
        $dejafacilite=$dejavente->getfacilite();
        //var_dump($listId);

        if($isavance==1){
        $avance=$request->get('avance');
        $facilite=$request->get('facilite');
        }else{
        $avance=0;
        $isavance=0;
        $facilite=null;
        }

        $remarque=$request->get('remarque');

        $facilite=$em->getRepository('IstokIstokBundle:facilite')->findOneById($facilite);
        $client=$em->getRepository('IstokIstokBundle:client')->findOneBycin($cin);

    if(!isset($client)){
        $client = $dejaclient;
        $client->setnom($nom);
        $client->setprenom($prenom);
        $client->setcin($cin);
        $client->settel($tel);
        $client->setetab($etab);

        
//        $client->setreference("ref1");
        $client->setdate(new \DateTime());
    }

        $vente = $dejavente;
        $vente->setdate(new \DateTime());
        $vente->setisavance($isavance);
        $vente->setavance($avance);
        $vente->setclient($client);
        $vente->setfacilite($facilite);
        $vente->setremarque($remarque);
        $vente->setetab($etab);

       //$vente->setnum($idv);

        $totals=0;
        $i=0;


        $ligne_cmds=$em->getRepository('IstokIstokBundle:ligne_cmd')->findByvente($vente);

        foreach ($ligne_cmds as $ligne_cmd) {
            # code...

            $myarticle=$ligne_cmd->getarticle();
            //var_dump($myarticle->getquantite());
            $myarticleqte=$myarticle->getquantite();
            $myarticle->setquantite($myarticleqte+$ligne_cmd->getquantite());

           // var_dump($ligne_cmd->getarticle()->getquantite());
            //var_dump($myarticle->getquantite());
    
            $em->persist($myarticle);
            $em->remove($ligne_cmd);       
            $em->flush();


        }
        
    /*    foreach ($articles as $articleID) {

            $article=$em->getRepository('IstokIstokBundle:article')->findById($articleID);
            $article=$article[0];
            $qtestok=$article->getarticle();
            //var_dump($qtestok);

        }

*/


//var_dump($ligne_cmd);//

        foreach ($articles as $articleID) {    


        $article=$em->getRepository('IstokIstokBundle:article')->findById($articleID);
 $article=$article[0];
        $qtestok=$article->getquantite();
        $totals=$totals+$article->getprix()*$qtes[$i];

        if($qtestok<=$qtes[$i]){ return new Response('0'); }


        $article->setquantite($qtestok-$qtes[$i]);


        $ligne_cmd = new ligne_cmd();
        $ligne_cmd->setquantite($qtes[$i]);
        $ligne_cmd->setprix($article->getprix());
        $ligne_cmd->settotal($article->getprix()*$qtes[$i]);
        $ligne_cmd->setdate(new \DateTime());
        $ligne_cmd->setvente($vente);
        $ligne_cmd->setarticle($article);
        $ligne_cmd->setidcmd($listId[$i]);
        $ligne_cmd->setetab($etab);

//var_dump($article);
//var_dump($ligne_cmd);

        $em->persist($ligne_cmd);

        $i++;

        }

        $vente->settotal($totals);

        if($isavance!=1){

        $avance=$totals;
        $isavance=0;
        $facilite=null;
        }
        $vente->setavance($avance);
        $vente->setetab($etab);

        $em->persist($client);
        $em->persist($vente);
        $em->flush();




        return new Response("1");

    }





 public function deleteAction($id){


        $em=$this->getDoctrine()->getManager();
        $vente=$em->find('IstokIstokBundle:vente',$id);


        $etab2 = $vente->getetab();
        $idetab2=$etab2->getid();
        $iduser=$this->get_identity()->getid();
        if($this->check_user($iduser)==0){
            return $this->redirectToRoute('vente');
        }
        
        if(!$vente)
        {

            throw $this->createNotFoundException('vente not found');
            
        }
        $em->remove($vente);       
        $em->flush();   
        //$msg='delete vente Succes' ;   
       // return new Response('delete vente Success =D') ;   
                        return $this->redirectToRoute('vente');

    }




}
