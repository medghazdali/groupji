<?php

namespace Istok\IstokBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Istok\IstokBundle\Entity\vente;
use Istok\IstokBundle\Entity\etab;
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
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{


    public  function get_identity()
    {
       // return $this->redirectToRoute('fos_user_security_logout');
      //  var_dump($this);

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




    public  function listuserAction()
    {

        $etab=$this->get_identity()->getetab();
                       
        $em=$this->getDoctrine()->getManager();
        $User=$em->getRepository('UserBundle:User')->findByetab($etab);
        
        return $this->render('IstokIstokBundle:user:list.html.twig',array('users'=>$User));

    }



    public  function statistiqueAction(Request $request)
    {

        $etab=$this->get_identity()->getetab();
        $em=$this->getDoctrine()->getManager();
        $user=$this->get_identity();

        $params = array();
        $etab=$this->get_identity()->getetab();
        $idetab=$etab->getid();
        //$datev1=date('Y-m-d');
        $datev1=date('2017-02-02');
        $datev2 = date('Y-m-d', strtotime($datev1 . " +120 days"));

        $date=$request->get('date');
        $date2=$request->get('date2'); 




if(!is_null($date) and !is_null($date2) ){


        $date = date('d-m-Y', strtotime($date));
        $date2 = date('d-m-Y', strtotime($date2));


        $datev1 = date('Y-m-d', strtotime($date));
        $datev2 = date('Y-m-d', strtotime($date2));

    }

        $datev1_ = date('d-m-Y', strtotime($datev1));
        $datev2_ = date('d-m-Y', strtotime($datev2));


//--------------------rendement par user

        $setParameter=array('idetab'=>"$idetab",'datev1'=>"$datev1",'datev2'=>"$datev2",'type'=>"0");

$query= $em->createQueryBuilder()
        ->select('u.username as username,sum(v.total) as total')
        ->from('IstokIstokBundle:vente', 'v')
        ->innerJoin('v.user','u')
        ->innerJoin('v.etab','e')
        ->Where('e.id=:idetab')
        ->andWhere('v.date>=:datev1')
        ->andWhere('v.date<:datev2')
        ->andWhere('v.type=:type')
        ->groupby('u.id')
        ->setParameters($setParameter)
        ->getQuery()
        ->getScalarResult();

$rdvuser=[];
$totals=0;



foreach ($query as $key => $value) {
   // $vtot=($value['total']*100)/$totals;
   // $value['total']=$vtot;
array_push($rdvuser, $value);
}


//--------------------rendement par mois


$ydat=date('Y');
$listMount=array();

for ($i=1; $i <13 ; $i++) {
if($i<10)
$i="0".$i; 
$mdat1=$ydat."-".$i."-".'01';

$mdat2 = date('Y-m-d', strtotime($mdat1 . " +1 month"));



$setParameter=array('idetab'=>"$idetab",'datev1'=>"$mdat1",'datev2'=>"$mdat2",'type'=>"0");

$query= $em->createQueryBuilder()
        ->select('sum(v.total) as total')
        ->from('IstokIstokBundle:vente', 'v')
        ->innerJoin('v.etab','e')
        ->Where('e.id=:idetab')
        ->andWhere('v.date>=:datev1')
        ->andWhere('v.date<:datev2')
        ->andWhere('v.type=:type')
        ->groupby('e.id')
        ->setParameters($setParameter)
        ->getQuery()
        ->getScalarResult();



if(sizeof($query)>0)
array_push($listMount, $query[0]['total']);
else
array_push($listMount, 0);


}

//--------------------rendement par article

        $setParameter=array('idetab'=>"$idetab",'datev1'=>"$datev1",'datev2'=>"$datev2",'type'=>"0");


$rdvarticles= $em->createQueryBuilder()
        ->select('count(a.id)*l.quantite as total , l.total as totals , a.article')
        ->from('IstokIstokBundle:ligne_cmd', 'l')
        ->innerJoin('l.etab','e')
        ->innerJoin('l.vente','v')
        ->innerJoin('l.article','a')
        ->Where('e.id=:idetab')
        ->andWhere('l.date>=:datev1')
        ->andWhere('l.date<:datev2')
        ->andWhere('v.type=:type')
        ->groupby('a.id')
        ->setParameters($setParameter)
        ->getQuery()
        ->getScalarResult();




//var_dump($rdvarticles);


//--------------------rendement par type article

        $setParameter=array('idetab'=>"$idetab",'datev1'=>"$datev1",'datev2'=>"$datev2",'type'=>"0");


$rdvtypeclient= $em->createQueryBuilder()
        ->select('count(a.id)*l.quantite as total , l.total as totals , c.categorie')
        ->from('IstokIstokBundle:ligne_cmd', 'l')
        ->innerJoin('l.etab','e')
        ->innerJoin('l.vente','v')
        ->innerJoin('l.article','a')
        ->innerJoin('a.categories','c')
        ->Where('e.id=:idetab')
        ->andWhere('l.date>=:datev1')
        ->andWhere('l.date<:datev2')
        ->andWhere('v.type=:type')
        ->groupby('c.id')
        ->setParameters($setParameter)
        ->getQuery()
        ->getScalarResult();







//--------------------rendement par type client

        $setParameter=array('idetab'=>"$idetab",'datev1'=>"$datev1",'datev2'=>"$datev2",'type'=>"0");



$rdvtypeart= $em->createQueryBuilder()
        ->select('count(c.id) as total, v.total as totals , t.type')
        ->from('IstokIstokBundle:vente', 'v')
        ->innerJoin('v.etab','e')
        ->innerJoin('v.client','c')
        ->innerJoin('c.type','t')
        ->Where('e.id=:idetab')
        ->andWhere('v.date>=:datev1')
        ->andWhere('v.date<:datev2')
        ->andWhere('v.type=:type')
        ->groupby('t.id')
        ->setParameters($setParameter)
        ->getQuery()
        ->getScalarResult();




//--------------------rendement moyen par jour 

        $setParameter=array('idetab'=>"$idetab",'datev1'=>"$datev1",'datev2'=>"$datev2",'type'=>"0");


  $datdf= round(abs(strtotime($datev2)-strtotime($datev1))/86400);
if(!$datdf)
    $datdf=1;


$queryz= $em->createQueryBuilder()
        ->select('sum(v.total) as total')
        ->from('IstokIstokBundle:vente', 'v')
        ->innerJoin('v.etab','e')
        ->Where('e.id=:idetab')
        ->andWhere('v.date>=:datev1')
        ->andWhere('v.date<:datev2')
        ->andWhere('v.type=:type')
        ->groupby('e.id')
        ->setParameters($setParameter)
        ->getQuery()
        ->getScalarResult();

$rdvmoy=0;
if(sizeof($queryz))
$rdvmoy=round(abs($queryz[0]['total'])/$datdf);

$rdvmoy= number_format($rdvmoy,2,",",".");





//-------home stat----------------------

$params = array();
//----------total cv this day



$etab=$this->get_identity()->getetab();
$idetab=$etab->getid();


$datev1=date('2017-04-28');
$datev2 = date('Y-m-d', strtotime($datev1 . " +10 days"));

$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT SUM(v.total)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and v.etab=e.id and e.id=:idetab and v.date>=:datev1 and  v.date<:datev2'
)->setParameter('idetab', $idetab)
->setParameter('datev1', $datev1)
->setParameter('type', 0)
->setParameter('datev2', $datev2);

$date = $query->getSingleScalarResult();
$total= number_format($date,2,",",".");
//var_dump($query);
array_push($params, $total);

//----------nbr cmd day
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
  FROM IstokIstokBundle:vente v
    JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab and  v.date>=:datev1 and  v.date<:datev2'
)->setParameter('idetab', $idetab)
->setParameter('datev1', $datev1)
->setParameter('type', 0)
->setParameter('datev2', $datev2);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");
array_push($params, $total);


//----------nbr article day
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.total)
    FROM IstokIstokBundle:ligne_cmd v
    JOIN IstokIstokBundle:etab e WHERE v.etab=e.id and e.id=:idetab and  v.date>=:datev1 and  v.date<:datev2'
)->setParameter('idetab', $idetab)
->setParameter('datev1', $datev1)
->setParameter('datev2', $datev2);
$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);

//----------nbr dmd
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
    FROM IstokIstokBundle:demande v JOIN IstokIstokBundle:etab e WHERE v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");
array_push($params, $total);


//----------total cv
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT SUM(v.total)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 0);

$total = $query->getSingleScalarResult();
$total0 =$total;
$total= number_format($total,2,",",".");
array_push($params, $total);


//----------total credit
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT SUM(v.total-v.avance)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 0);

$total = $query->getSingleScalarResult();
$totalc=$total;
$total=$total0-$total;
$total= number_format($total,2,",",".");
$totalc= number_format($totalc,2,",",".");

array_push($params, $total);
array_push($params, $totalc);



//----------nbr cmd
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 0);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);




//----------nbr article
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.total)
    FROM IstokIstokBundle:ligne_cmd v JOIN IstokIstokBundle:etab e WHERE v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);


//----------nbr devis
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 1);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);



//var_dump($listMount);
        return $this->render('IstokIstokBundle:statistique:list.html.twig',array('rdvusers' =>$rdvuser,'listMount' =>$listMount,'params'=>$params,'rdvarticles'=>$rdvarticles ,'rdvtypeclients'=>$rdvtypeclient,'rdvtypearts'=>$rdvtypeart,'rdvmoy'=>$rdvmoy,"datev1_"=>$datev1_,"datev2_"=>$datev2_));

    }







    public function indexAction()
    {
$params = array();
//----------total cv this day



$etab=$this->get_identity()->getetab();
$idetab=$etab->getid();


$datev1=date('2017-03-27');
$datev2 = date('Y-m-d', strtotime($datev1 . " +10 days"));

$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT SUM(v.total)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and v.etab=e.id and e.id=:idetab and v.date>=:datev1 and  v.date<:datev2'
)->setParameter('idetab', $idetab)
->setParameter('datev1', $datev1)
->setParameter('type', 0)
->setParameter('datev2', $datev2);

$date = $query->getSingleScalarResult();
$total= number_format($date,2,",",".");
//var_dump($query);
array_push($params, $total);

//----------nbr cmd day
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
  FROM IstokIstokBundle:vente v
    JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab and  v.date>=:datev1 and  v.date<:datev2'
)->setParameter('idetab', $idetab)
->setParameter('datev1', $datev1)
->setParameter('type', 0)
->setParameter('datev2', $datev2);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");
array_push($params, $total);


//----------nbr article day
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.total)
    FROM IstokIstokBundle:ligne_cmd v
    JOIN IstokIstokBundle:etab e WHERE v.etab=e.id and e.id=:idetab and  v.date>=:datev1 and  v.date<:datev2'
)->setParameter('idetab', $idetab)
->setParameter('datev1', $datev1)
->setParameter('datev2', $datev2);
$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);

//----------nbr dmd
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
    FROM IstokIstokBundle:demande v JOIN IstokIstokBundle:etab e WHERE v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");
array_push($params, $total);


//----------total cv
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT SUM(v.total)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 0);

$total = $query->getSingleScalarResult();
$total0 =$total;
$total= number_format($total,2,",",".");
array_push($params, $total);


//----------total credit
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT SUM(v.avance)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 0);

$total = $query->getSingleScalarResult();
$totalc=$total;
$total=$total0-$total;
$total= number_format($total,2,",",".");
$totalc= number_format($totalc,2,",",".");

array_push($params, $total);
array_push($params, $totalc);



//----------nbr cmd
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 0);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);




//----------nbr article
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.total)
    FROM IstokIstokBundle:ligne_cmd v JOIN IstokIstokBundle:etab e WHERE v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);


//----------nbr devis
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT count(v.id)
    FROM IstokIstokBundle:vente v JOIN IstokIstokBundle:etab e WHERE v.type=:type and  v.etab=e.id and e.id=:idetab '
)->setParameter('idetab', $idetab)
->setParameter('type', 1);

$total = $query->getSingleScalarResult();
//$total= number_format($total,2,",",".");

array_push($params, $total);



//----------list cmd day

        $ventes=$em->getRepository('IstokIstokBundle:vente')->findBy(array('etab'=>$etab,'type'=>0));



        return $this->render('IstokIstokBundle::index.html.twig',array('params'=>$params,'ventes'=>$ventes));
    }


    public function getetabAction()
    {

        $em = $this->getDoctrine()->getManager();
        $etab=$this->get_identity()->getetab();
        $idetab=$etab->getid();

        $etab=$em->getRepository('IstokIstokBundle:etab')->findById($idetab);
        $etabn=$etab[0]->getetab();
        $etabref=$etab[0]->getref();

        $rep=$etabn.' (# '.$etabref.' )';

        return new Response($rep);

    }

  
 
    public  function taskAction()
    {

        $etab=$this->get_identity()->getetab();
                       
        $em=$this->getDoctrine()->getManager();
        $idetab=$etab->getid();



        $setParameter=array('idetab'=>"$idetab");

$task= $em->createQueryBuilder()
        ->select('a.id,a.article,a.quantite')
        ->from('IstokIstokBundle:article', 'a')
        ->innerJoin('a.etab','e')
        ->Where('e.id=:idetab')
        ->andWhere('a.quantite<4')
        ->setParameters($setParameter)
        ->getQuery()
        ->getScalarResult();
        //var_dump($task);

    return new JsonResponse($task);


    }
 

}