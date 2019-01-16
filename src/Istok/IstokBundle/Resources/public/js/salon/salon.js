
////////////////////////////////////////variables globales//////////////////////////////////////
 var dialogOptions, dialogOptionsPilier, dialogConfirm,dialogOptions_c,dialogOptions_c2;
 var SB=null;
 var PILIER=null;
 var toDelete=null;
 var pilier_count=0; 
 var SB_count=0;
 var CN_count=0;
 
 //////////////////////changement des select//////////////////////
 

 var selectlB_changed=false;
 
///////////////////////////////////////////////////////////////////////////////////////////////// 
 var prix_total_salon=0;
 //************************** Bois **************************//
  
 var sb_nombre;   	 var sb_metrage_bois;      var sb_prix_bois; 
 var acc_nombre;  	 var acc_metrage_bois;     var acc_prix_bois; 
 var face_nombre; 	 var face_metrage_bois;    var face_prix_bois; 
 var coin_nombre; 	 var coin_metrage_bois;    var coin_prix_bois;
 var fcoin_nombre;
 var dossier_nombre; var dossier_metrage_bois; var dossier_prix_bois;

 var prixFC;
 var metrageBois;  var prixBois;
 var prixTotalBois=0;
 
 //************************** Tissu **************************//

 var lB;
 var lsB;
 var metrageBanquettes=0;
 var lCV;
 var metrageTissuSupplementaireCV=0;
 var prixTissuSupplementaireCV=0;
 
 var nbrCoussinCoin;
 
 var metrageTissuCV=0;
 var nbr_CV=0;
 var prixTissuCV=0;
 //----------
 //var metrageTissuCT;
 var metrageTissuT1;
 var metrageTissuT2;
 var metrageTissuBoudin;
 var metrageTissuCigarette;
 var prixTissuT1;
 var prixTissuT2;
 var prixTissuBoudin;
 var prixTissuCigarette;
 //----------
 var metrageTissuCS;
 var prixTissuCS;
 
 var prix_total_tissu=0; 
/////////////////////////////////////////////////////////////////////////////////////////////////	

 function collision(div1, div2) {
	 
     var x1 = div1.offset().left;
     var y1 = div1.offset().top;
     var h1 = div1.outerHeight(true);
     var w1 = div1.outerWidth(true);
     
     var b1 = y1 + h1;
     var r1 = x1 + w1;
     
     var x2 = div2.offset().left;
     var y2 = div2.offset().top;
     var h2 = div2.outerHeight(true);
     var w2 = div2.outerWidth(true);

     var b2 = y2 + h2;
     var r2 = x2 + w2;
     
     var nbrEgalite=0;
     if (Math.round(b1, 2) == Math.round(y2, 2)) nbrEgalite++;
     if (Math.round(y1, 2) == Math.round(b2, 2))nbrEgalite++;
     if (Math.round(r1, 2) == Math.round(x2, 2))nbrEgalite++;
     if (Math.round(x1, 2) == Math.round(r2, 2))nbrEgalite++;
     
     if (
    	(Math.round(b1, 2) < Math.round(y2, 2) || Math.round(y1, 2) > Math.round(b2, 2) || Math.round(r1, 2) < Math.round(x2, 2) || Math.round(x1, 2) > Math.round(r2, 2)) 
		|| (nbrEgalite>=2) ) {   
    	// alert("false" + b1.toFixed(2) +"<" + y2.toFixed(2) + "  ||  " +y1.toFixed(2) +">"+ b2.toFixed(2) +"  ||  "+ r1.toFixed(2) +"<"+ x2.toFixed(2) +"  ||  "+ x1.toFixed(2) +">"+ r2.toFixed(2)) ;
    	 return false;}
     else {
       //  alert("true" +b1.toFixed(2) +"<" + y2.toFixed(2) + "  ||  " +y1.toFixed(2) +">"+ b2.toFixed(2) +"  ||  "+ r1.toFixed(2) +"<"+ x2.toFixed(2) +"  ||  "+ x1.toFixed(2) +">"+ r2.toFixed(2)) ;
    	 return true;
     }
    
   } 
 




 function collisionWith(div1, div2) {
	 
     var x1 = div1.offset().left;
     var y1 = div1.offset().top;
     var h1 = div1.outerHeight(true);
     var w1 = div1.outerWidth(true);
     
     var b1 = y1 + h1;
     var r1 = x1 + w1;
     
     var x2 = div2.offset().left;
     var y2 = div2.offset().top;
     var h2 = div2.outerHeight(true);
     var w2 = div2.outerWidth(true);



     var b2 = y2 + h2;
     var r2 = x2 + w2;
     
     var nbrEgalite=0;
     if (Math.round(b1, 2) == Math.round(y2, 2)) nbrEgalite++;
     if (Math.round(y1, 2) == Math.round(b2, 2))nbrEgalite++;
     if (Math.round(r1, 2) == Math.round(x2, 2))nbrEgalite++;
     if (Math.round(x1, 2) == Math.round(r2, 2))nbrEgalite++;
     
     if (
    	(Math.round(b1, 2) < Math.round(y2, 2) || Math.round(y1, 2) > Math.round(b2, 2) || Math.round(r1, 2) < Math.round(x2, 2) || Math.round(x1, 2) > Math.round(r2, 2)) 
		|| (nbrEgalite>=2) ) {   
    	// alert("false" + b1.toFixed(2) +"<" + y2.toFixed(2) + "  ||  " +y1.toFixed(2) +">"+ b2.toFixed(2) +"  ||  "+ r1.toFixed(2) +"<"+ x2.toFixed(2) +"  ||  "+ x1.toFixed(2) +">"+ r2.toFixed(2)) ;
    	 return  div2.attr("data-id");

    	}else {
       //  alert("true" +b1.toFixed(2) +"<" + y2.toFixed(2) + "  ||  " +y1.toFixed(2) +">"+ b2.toFixed(2) +"  ||  "+ r1.toFixed(2) +"<"+ x2.toFixed(2) +"  ||  "+ x1.toFixed(2) +">"+ r2.toFixed(2)) ;
    	  console.log('---------------data-id ***---------------')
     		console.log(div2.attr("data-id"))
     		console.log(div2)

    	 	return div2.attr("data-id")
    


     }
    
   } 
 


 function nbrCoinCollision(SB){
	 
	 var nbrCoinCollision=0; 
	 collisionWithInput=0;
	 
	  $("#droppableSalon .coin").each(function(){
		  
		 if( collision($(this),SB) ){

			 nbrCoinCollision++;

		 }
	  });

	  
	  
	  SB.find("input.nbrCoinCollision").val(nbrCoinCollision);
	 

//------fauxCoin -------ListAdh
	 var nbrFauxCoinCollision=0; 
	 var nbrFauxCoinWithCollision=""; 
	 
	  $("#droppableSalon .fauxCoin ").each(function(){
		  
		 if( collision($(this),SB) ){

			 nbrFauxCoinCollision++;
			 //nbrFauxCoinWithCollision=nbrFauxCoinWithCollision+" "+collisionWith($(this),SB)
			 nbrFauxCoinWithCollision=collisionWith($(this),SB)
			 $(this).find("input#ListAdh").addClass(""+nbrFauxCoinWithCollision);

		 }else{

			 $(this).find("input#ListAdh").removeClass(SB.attr("data-id"));

		 }


	  });
	  

	    SB.find("input.nbrFauxCoinCollision").val(nbrFauxCoinCollision);
	  //SB.find("input.collisionWithInput").val(collisionWithInput);

	  //SB.className += " "+collisionWithInput;

	    SB.find("input#collisionWithInput").removeClass();
		SB.find("input#collisionWithInput").addClass(""+nbrFauxCoinWithCollision);

	  if(nbrCoinCollision!=0)
		  SB.css({"backgroundColor":"#944f21"});
	  else
		  SB.css({"backgroundColor":"#944f21"});
 }
 
 function collision_sbv_sbh() {
	 
	 nbrCoussinCoin=0;
	 var sbv;
	 $("#droppableSalon .sbv").each(function(){
 		  sbv=$(this);
		  $("#droppableSalon .sbh").each(function(){
			  if( collision($(this),sbv) ) {
				  nbrCoussinCoin++; 	  
			  }
				  
		  }); 
	 });    
	 //alert(nbrCoussinCoin);
	 //$("#coussins select#coussinCoin").select2("val", nbrCoussinCoin);
  }
 
 function collision_couverture_sb(couverture) {  
	 var sb;
	 var nbrB=0;  
	 var liste_sb="";
	 
	 if(couverture.hasClass("couvertureh")) sb="sbh";
	 else if(couverture.hasClass("couverturev")) sb="sbv";
		 
		 $("#droppableSalon ."+sb).each(function(){
			  
			 if( collision($(this),couverture) ) {
				 nbrB++; 
				 liste_sb+="<option value = "+$(this).attr("data-id")+" ></option>";
			  }
			  
		  });
		 couverture.find(".nbSupport_couverture").val(nbrB);
		 couverture.find(".liste_sb").html(liste_sb);
 }
 
 function collision_coin_sb(element) {  
	 
   var SB=null;
   if(element.hasClass("sb")){
	   
	   SB=element;
	   nbrCoinCollision(SB); 
	   collision_sbv_sbh();
	   
	   var couverture;
	   if(element.hasClass("sbh")) couverture="couvertureh";
		 else if(element.hasClass("sbv")) couverture="couverturev";
	  
		   $("#droppableSalon ."+couverture).each(function(){
			   collision_couverture_sb($(this));
		   });
	   
    } else if(element.hasClass("coin")) {	
	 
	  $("#droppableSalon .sb").each(function(){
		  
		  SB=$(this);
		  nbrCoinCollision(SB);
		  
	  });
    }else if(element.hasClass("fauxCoin")) {	
	 
	  $("#droppableSalon .sb").each(function(){
		  
		  SB=$(this);
		  nbrCoinCollision(SB);
		  
	  });
    }



    
 } 
 
 function edit_WH_SB_largeur(){
	 
	 var echelle=$("#echelle").val();
	 var largeur=$("#largeurSalon").val();
	 var w_h = (largeur * 60/echelle) + "px";
	 //alert(largeur)
	 
	 $("#droppableSalon .sbh").each(function(){
		 $(this).css("height",w_h);
	 });
	 
	 $("#droppableSalon .sbv").each(function(){
		 $(this).css("width",w_h);
	 }); 
	 
	 $("#droppableSalon .coin, #droppableSalon .fauxCoin").each(function(){	       	  
         $(this).css({
             "height" : w_h,
             "width" : w_h
         }); 
       });


	 $("#droppableSalon .can").each(function(){	     

			    		  var aj=0.47*parseInt(w_h);
			    		  var  vop  = parseInt(w_h)+parseInt(aj);

         $(this).css({
             "height" : vop,
             "width" : vop
         }); 
       });	


			    		  var aj2=0.47*parseInt(largeur);
			    		  var  vop2  = parseInt(largeur)+parseInt(aj2);


			add=largeur-70
			add=parseInt(add)+90

			$(".coint .dimens2").val(largeur)
			$(".coint .dimens3").val(largeur)
			$(".coint .dimens1").val(add)
			$(".coint .dimens5").val(add)

			add2=largeur-70
			add2=parseInt(add2)+35

			$(".can2 .dimens2").val(largeur)
			$(".can2 .dimens3").val(largeur)
			$(".can2 .dimens6").val(add2)
			$(".can2 .dimens7").val(add2)



	}
 
 $("#largeurSalon").change(function(){ edit_WH_SB_largeur(); }); 
  
 function edit_WH_SB_echelle(){
	 
     var echelle=$("#echelle").val(); 
     
     $("#droppableSalon .sbh").each(function(){	       	 
      var w = (($(this).find(".dp-numberPicker-input").val().split(" ")[0])*60/echelle) + "px";
      $(this).css("width",w);
     }); 
     
     $("#droppableSalon .sbv").each(function(){	       	 
         var h = (($(this).find(".dp-numberPicker-input").val().split(" ")[0])*60/echelle) + "px";
         $(this).css("height",h);
       });
     
     edit_WH_SB_largeur();
  }
 
 function validateNumber(event) {	 
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode == 8 || event.keyCode == 46
     || event.keyCode == 37 || event.keyCode == 39) {
        return true;
    }else if ( event.keyCode == 13 ) { 
    	edit_WH_SB_echelle(); 	
    }
    else if ( key < 48 || key > 57 ) {
        return false;
    }
    else return true; 
 }
 
 function toMetre(d){
	 return d.toFixed(2)+" m";
 }
 
 function toDH(d){
	 return d.toFixed(2)+" DH";
 }
 
 $("#echelle").keypress(validateNumber); 

 function editOptions() { 
	 	 
	 $("#dialog-options input.check:checked").each(function(){
	  var name = $(this).attr("id");  	
	  SB.find("input.check[name='"+name+"']").val("1"); 	         	 		        		      
     }); 
     
	 $("#dialog-options input.check:not(:checked)").each(function(){
	  var name = $(this).attr("id");  	
	  SB.find("input.check[name='"+name+"']").val("0");  			        	 		        		      
	 });  
/*
	 if($('#dialog-options input#coinGauche').is(":checked")){
	     if(SB.hasClass("sbh"))
			  SB.css("border-right","2px dashed #595959");
	     else if(SB.hasClass("sbv"))
		  	  SB.css("border-top","2px dashed #595959");
	  } else {		
		  if(SB.hasClass("sbh"))
			  SB.css("border-right","2px solid");
	     else if(SB.hasClass("sbv"))
		  	  SB.css("border-top","2px solid");
	  }

	 if($('#dialog-options input#coinDroite').is(":checked")){
	     if(SB.hasClass("sbh"))
			  SB.css("border-left","2px dashed #595959");
	     else if(SB.hasClass("sbv"))
		  	  SB.css("border-bottom","2px dashed #595959");
	  } else {		
		  if(SB.hasClass("sbh"))
			  SB.css("border-left","2px solid");
	     else if(SB.hasClass("sbv"))
		  	  SB.css("border-bottom","2px solid");
	  } 
*/





	 if($('#dialog-options input#accoudoirGauche').is(":checked"))
		  SB.find(".divAccoudoirGauche").css("display","block");  
	  else
          SB.find(".divAccoudoirGauche").css("display","none");  
	  
	 if($('#dialog-options input#accoudoirDroite').is(":checked")) 
		  SB.find(".divAccoudoirDroite").css("display","block");  
	  else 
		  SB.find(".divAccoudoirDroite").css("display","none");  
	//////////////////////////// faces///////////////////////////////////////
	 if($('#dialog-options input#faceGauche').is(":checked"))
		  SB.find(".divFaceGauche").css("display","block");  
	  else
         SB.find(".divFaceGauche").css("display","none");  
	  
	 if($('#dialog-options input#faceDroite').is(":checked")) 
		  SB.find(".divFaceDroite").css("display","block");  
	  else 
		  SB.find(".divFaceDroite").css("display","none");
	 ///////////////////////////////////////////////////////////////////////////
	 if( $('#dialog-options input#accoudoirGauche').is(":checked") || $('#dialog-options input#accoudoirDroite').is(":checked") )
		 SB.find(".largeurAccoudoir").val($("#dialog-options select#largeurAccoudoir").val());
	  else 
		 SB.find(".largeurAccoudoir").val("0");
	 
	 /////////////////////////////////////////// dossiers////////////////////////////////////////////////////
	 var dossierArriere=$("#dialog-options select#dossierArriere").val(); 
	 var dossierArriere2=$("#dialog-options select#dossierArriere2").val(); 
	 SB.find("input[name=dossierArriere]").val(dossierArriere);
	 SB.find("input[name=dossierArriere2]").val(dossierArriere2);
	 SB.css("border","2px solid");
     if(dossierArriere==1 || dossierArriere==2 || dossierArriere2==1 || dossierArriere2==2){
    	 SB.find(".largeurDossier").val($("#dialog-options select#largeurDossier").val());
		 SB.find(".hauteurDossier").val($("#dialog-options select#hauteurDossier").val()); 
		 
			 if(SB.hasClass("sbh"))
         { 
			 if(dossierArriere==1){
				 SB.css("border-top","6px double");
			 }else if(dossierArriere==2){
				 SB.css("border-bottom","6px double");				 
			 }
			
			if(dossierArriere2==1){
				 SB.css("border-left","6px double");
			 }else if(dossierArriere2==2){
				 SB.css("border-right","6px double");				 
			 }
			 
         }if(SB.hasClass("sbv"))
         { 
			 if(dossierArriere2==1){
				 SB.css("border-top","6px double");
			 }else if(dossierArriere2==2){
				 SB.css("border-bottom","6px double");				 
			 }
			
			if(dossierArriere==1){
				 SB.css("border-left","6px double");
			 }else if(dossierArriere==2){
				 SB.css("border-right","6px double");				 
			 }	
         }
     } else{
    	 SB.find(".largeurDossier").val("0");
		 SB.find(".hauteurDossier").val("0"); 
     }
 

   SB=null; 
   dialogOptions.dialog( "close" );   
 } 
 






 function editOptions_c() { 
	 	 
	


	 
	 /////////////////////////////////////////// dossiers////////////////////////////////////////////////////
	 var dossierArriere=$("#dialog-options_c select#dossierArriere").val(); 
	 //alert(dossierArriere)
	 SB.find("input[name=dossierArriere]").val(dossierArriere);
	 SB.css("border","2px solid");
     if(dossierArriere==1 || dossierArriere==2 || dossierArriere==3 || dossierArriere==4){
    	 SB.find(".largeurDossier").val($("#dialog-options_c select#largeurDossier").val());
		 SB.find(".hauteurDossier").val($("#dialog-options_c select#hauteurDossier").val()); 
		 
		  if(SB.hasClass("coina1"))
         { 
			 if(dossierArriere==1)
				 SB.css("border-left","6px double");
			 else if(dossierArriere==2)
				 SB.css("border-right","6px double");	
		   			 else if(dossierArriere==3)
				 SB.css("border-top","6px double");	
				 			 else if(dossierArriere==4)
				 SB.css("border-bottom","6px double");				 
         }


		
        
     } else{
    	 SB.find(".largeurDossier").val("0");
		 SB.find(".hauteurDossier").val("0"); 
     }
     
   SB=null; 
   dialogOptions_c.dialog( "close" );  

    
 } 
 





 function editOptions_c2() { 
	 	 
	


	 
	 /////////////////////////////////////////// dossiers////////////////////////////////////////////////////
	 var dossierArriere=$("#dialog-options_c2 select#dossierArriere").val(); 
	 var dossierArriere2=$("#dialog-options_c2 select#dossierArriere2").val(); 
	 //alert(dossierArriere)
	 SB.find("input[name=dossierArriere]").val(dossierArriere);
	 SB.css("border-top","0px solid");
	 SB.css("border-left","0px solid");
	 SB.css("border-right","0px solid");
	 SB.css("border-bottom","0px solid");

     if(dossierArriere==1 || dossierArriere==2 || dossierArriere==3 || dossierArriere==4){
    	 SB.find(".largeurDossier").val($("#dialog-options_c2 select#largeurDossier").val());
		 SB.find(".hauteurDossier").val($("#dialog-options_c2 select#hauteurDossier").val()); 
		 
		  if(SB.hasClass("can"))
         { 
			 if(dossierArriere==1){
				 SB.css("border-top","6px double");
			 }else if(dossierArriere==2){
				 SB.css("border-left","6px double");	
			 }else if(dossierArriere==3){
				 SB.css("border-top","6px double");	
				 SB.css("border-left","6px double");	
			 }
				 
 
         }


		
        
     } else{
    	 SB.find(".largeurDossier").val("0");
		 SB.find(".hauteurDossier").val("0"); 
     }
     
   SB=null; 
   dialogOptions_c2.dialog( "close" );  

    
 } 
 













 function editOptions_pilier() {  
	 
 }
 
 function prixTotalSalon() {
	    prix_total_salon = prixTotalBois + prix_total_tissu;
		$("#prixTotalSalon").html(toDH(prix_total_salon));
 }
 function refBoisChanged() { 
	 
	 var prix=200; 
	 
	 sb_prix_bois=sb_metrage_bois * prix;
	 acc_prix_bois=acc_metrage_bois * prix;
	 face_prix_bois=face_metrage_bois * prix;
	 coin_prix_bois=coin_metrage_bois * prix; 
	 prixFC=$("#bois select#prixFC").val();
	 fcoin_prix_bois=fcoin_nombre * prixFC;
	 dossier_prix_bois=dossier_metrage_bois * prix;
	 
	// $("#bois #tableBois tr:eq(1) td:eq(3)").text(toDH(sb_prix_bois));
	// $("#bois #tableBois tr:eq(2) td:eq(3)").text(toDH(acc_prix_bois));
	 //$("#bois #tableBois tr:eq(3) td:eq(3)").text(toDH(face_prix_bois));
	 //$("#bois #tableBois tr:eq(4) td:eq(3)").text(toDH(coin_prix_bois));
	// $("#bois #tableBois tr:eq(5) td:eq(3)").text(toDH(fcoin_prix_bois));
	// $("#bois #tableBois tr:eq(6) td:eq(3)").text(toDH(dossier_prix_bois));
	 
	 prixTotalBois = sb_prix_bois + acc_prix_bois + face_prix_bois + coin_prix_bois + fcoin_prix_bois + dossier_prix_bois;
 	 //$("#bois #totalBois tr:eq(1) td:eq(1)").text(toDH(prixTotalBois));	
 	 
 	prixTotalSalon();
}  
 

  function refBoisChanged2() { 
	 
	 var prix=200; 
	 
	 sb_prix_bois=sb_metrage_bois * prix;
	 acc_prix_bois=acc_metrage_bois * prix;
	 face_prix_bois=face_metrage_bois * prix;
	 coin_prix_bois=coin_metrage_bois * prix; 
	 prixFC=$("#bois select#prixFC").val();
	 fcoin_prix_bois=fcoin_nombre * prixFC;
	 dossier_prix_bois=dossier_metrage_bois * prix;
	 
//alert(sb_prix_bois)
 	prixTotalSalon();
}  
 




 function metrageTotalBois() { 
    metrageBois=sb_metrage_bois + acc_metrage_bois + face_metrage_bois + coin_metrage_bois + dossier_metrage_bois;
	$("#bois #totalBois tr:eq(1) td:eq(0)").text(toMetre(metrageBois));	
	refBoisChanged();
}
 

 //----bois funvtion ---------------
 function bois(){
	 
	   largeurSalon=$("#largeurSalon").val()

		////////support de banquettes   
	    sb_nombre=$("#droppableSalon .sb").size(); 	
		//$("#bois_ #tableBois_ tr:eq(1) td:eq(1)").text(sb_nombre);  

		    //Métrage 
		sb_metrage_bois=0;
		var l;
		$("#droppableSalon .sb").each(function(){
			   l = parseInt($(this).find(".dp-numberPicker-input").val().split(" ")[0])/100;
			   sb_metrage_bois+=l; 
		});			     
		//$("#bois_ #tableBois_ tr:eq(1) td:eq(2)").text(toMetre(sb_metrage_bois)); 	
		
		if(sb_nombre==0){  
			$("#boisdiv").hide();
			$("#alertarticle").show();
		 }else{
		  $("#boisdiv").show();
			$("#alertarticle").hide();

		}
		


		//////// Accoudoirs   
		acc_nombre=$("#droppableSalon input[type='hidden'][name='accoudoirGauche'][value=1]").size() + $("#droppableSalon input[type='hidden'][name='accoudoirDroite'][value=1]").size();			 	 	      
		//$("#bois #tableBois tr:eq(2) td:eq(1)").text(acc_nombre); 
		//acc_metrage_bois=acc_nombre*1.5; // ou bien *2
		//$("#bois #tableBois tr:eq(2) td:eq(2)").text(toMetre(acc_metrage_bois));
		if(acc_nombre==0){  
			$("#bois #tableBois tr:eq(4)").hide();
            //$("#tableBanq tr:eq(4)").hide();  

			$(".accod").hide();
		 }else{ 

		 	$("#bois #tableBois tr:eq(4)").show();
            //$("#tableBanq tr:eq(4)").show();  

			$(".accod").show();

		}

		////////Faces   
		face_nombre=$("#droppableSalon input[type='hidden'][name='faceGauche'][value=1]").size() + $("#droppableSalon input[type='hidden'][name='faceDroite'][value=1]").size();			 	 	      
		//$("#bois #tableBois tr:eq(3) td:eq(1)").text(face_nombre); 
		//face_metrage_bois=face_nombre*0.5; // 
		//$("#bois #tableBois tr:eq(3) td:eq(2)").text(toMetre(face_metrage_bois));
		if(face_nombre==0)  
			$("#bois #tableBois tr:eq(3)").hide();
		 else $("#bois #tableBois tr:eq(3)").show();
		




		//////// Coins
		coin_nombre=$("#droppableSalon .coin").size(); 


		coin_metrage_bois=coin_nombre*3; 
		if(coin_nombre==0) { 

			$("#bois #tableBois tr:eq(2)").hide();
				//$("#tableBanq tr:eq(2)").hide(); 
		 }else{ 

		 	$("#bois #tableBois tr:eq(2)").show();
 				//$("#tableBanq tr:eq(2)").show();
		}


		//////// Coinsmmm
		coin_nombrem=$("#droppableSalon .coinm").size(); 
		if(coin_nombrem==0){
			$("#bois #tableBois tr:eq(7)").hide();

			$("#tableBanq tr:eq(3)").hide(); 

		 }else{
		  $("#bois #tableBois tr:eq(7)").show();

		  $("#tableBanq tr:eq(3)").show();  
		}

		//////// Coinst


		coin_nombret=$("#droppableSalon .coint").size(); 

		if(coin_nombret==0){  
			$("#bois #tableBois tr:eq(8)").hide();
			$("#tableBanq tr:eq(4)").hide(); 

		 }else{
		  $("#bois #tableBois tr:eq(8)").show(); 
		  $("#tableBanq tr:eq(4)").show();  


		}


		



		//////// FCoins
		fcoin_nombre=$("#droppableSalon .fauxCoin").size();  
		//$("#bois #tableBois tr:eq(6) td:eq(1)").text(fcoin_nombre);  	
		if(fcoin_nombre==0){  
			$("#bois #tableBois tr:eq(6)").hide();
			$("#tableBanq tr:eq(2)").hide(); 
		 }else{

		  $("#bois #tableBois tr:eq(6)").show();
		  $("#tableBanq tr:eq(2)").show();  
		
		}



		//////////  Dossiers 
		dossier_nombre=0;
		dossier_metrage_bois=0;
		var l;
		$("#droppableSalon .sb").each(function(){
			if($(this).find("input[name=dossierArriere]").val()>=1){
			   dossier_nombre++;
			   l = parseInt($(this).find(".dp-numberPicker-input").val().split(" ")[0])/100;
			   dossier_metrage_bois+=l; 
			}
		});


		///-------arrendu

faceronduSIZE=0;
		$("#droppableSalon .sb").each(function(){
			   l = parseInt($(this).find(".facerondu").val());
			   faceronduSIZE+=l; 
		});	

		if(faceronduSIZE==0)  
			$("#bois #tableBois tr:eq(10)").hide();
		 else $("#bois #tableBois tr:eq(10)").show();



		//////////  npilier 

		npilier=$("#droppableSalon .pilier").size();  
		if(npilier==0)  
			$("#bois #tableBois tr:eq(9)").hide();
		 else $("#bois #tableBois tr:eq(9)").show();



		//$("#bois #tableBois tr:eq(6) td:eq(1)").text(dossier_nombre); 
		//$("#bois #tableBois tr:eq(6) td:eq(2)").text(toMetre(dossier_metrage_bois));
		if(dossier_nombre==0)  
			$("#bois #tableBois tr:eq(5)").hide();
		 else $("#bois #tableBois tr:eq(5)").show();
		 
		metrageTotalBois(); 

idxxn=$("#goinputprix").val()
prix1=parseFloat(idxxn)

  bois2(prix1)


		///////////////////// tr background
		 var i=0;
		 $("#bois #tableBois tr").each(function(){ 
			  if ( $(this).is(':visible') ){ 
				 if (i % 2 == 0)
					 $(this).css("background-color" , "rgb(235, 235, 235");  
				 else 
					 $(this).css("background-color" , "rgb(250, 250, 250");
				 i++;
			  }
		}); 

		 var i=0;
		 $("#tableBanq tr").each(function(){ 
			  if ( $(this).is(':visible') ){ 
				 if (i % 2 == 0)
					 $(this).css("background-color" , "rgb(235, 235, 235");  
				 else 
					 $(this).css("background-color" , "rgb(250, 250, 250");
				 i++;
			  }
		}); 

//		$("#bois #tableBois tr:eq(0)").css("background-color" , "#E48409");  
		///////////////////////////////////////////////
		
	if(metrageBois==0)
		$("#bois #choix_bois, #bois #f_tableBois").hide();
	else
		$("#bois #choix_bois, #bois #f_tableBois").show();


 }
 


 function calculTissuSupplementaire() {
	 
	    var prix=200;
	    
    	var hB = parseInt($("#banquettes #selecthB").val());
    	var x=lB+hB*2+16;
    	if(x>140){
    		var tranche=140/(x-140);
    		metrageTissuSupplementaireCV=metrageBanquettes/tranche;	
    		prixTissuSupplementaireCV=metrageTissuSupplementaireCV*prix;
    		$("#tissuSupplementaireCV table tr:eq(1) td:eq(0)").text(toMetre(metrageTissuSupplementaireCV));
    		$("#tissuSupplementaireCV table tr:eq(1) td:eq(1)").text(toDH(prixTissuSupplementaireCV));
    		
    		$("#tissuSupplementaireCV").show(); 
    		
    	} else {
    		metrageTissuSupplementaireCV=0;
    		prixTissuSupplementaireCV=0;
    		$("#tissuSupplementaireCV").hide(); 
    	}
 }

 function metrageCT(type,L,Nbr){
	 var m;
	 if( (type=="T1" || type=="T2") && (L>40) ){	 
		 m = ((L*2+5) * Nbr)/100;
		 if(type=="T2") m=m*2;
	 } else if( (type=="T1" || type=="T2") && (L<40) ){
		 if(lB>=73){
		   m = 0.8 * Nbr;	
		   if(type=="T2") m=m*2;	   
		 }else{	   
		   if(type=="T2") m = 0.8 * Nbr;
		   if(type=="T1"){
			   m = 0.4 * Nbr; 
			   if(Nbr%2==1)   m+=0.4;   // impair				  
		   }	   
		 }		 
	 } else if( type=="B" ){  // Boudin
		 m = 0.8 * Nbr;	 
	 } else if( type=="C" ){  // Cigarette
		 m = 0.9 * Nbr;	 
	 } 	 
	  
   return m; 
 }
 
 function prixTotalTissu() {
	    prix_total_tissu = prixTissuCV + prixTissuSupplementaireCV + prixTissuT1 + prixTissuT2 + prixTissuBoudin + prixTissuCigarette + prixTissuCS;
		$("#tissu #totalTissu tr:eq(1) td:eq(1)").text(toDH(prix_total_tissu));
		
	 	prixTotalSalon();
	}

	function metrageTotalTissu() {
		var metrageTotalTissu=metrageTissuCV + metrageTissuT1 + metrageTissuT2 + metrageTissuBoudin + metrageTissuCigarette + metrageTissuCS; 
		$("#tissu #totalTissu tr:eq(1) td:eq(0)").text(toMetre(metrageTotalTissu)); 	
		
		prixTotalTissu();
	}

	function refTissuCVchanged() { 
		 
		 var prix=200; 
		 
		 prixTissuCV = metrageTissuCV * prix;  
		 $("#tissuCV #tableTissuCV tr:eq(1) td:eq(2)").text(toDH(prixTissuCV));
		 
		 prixTotalTissu();
	}  

	function refTissuCTchanged() { 
		 
		 var prix=200;  
		 
		 prixTissuT1=metrageTissuT1 * prix;
		 prixTissuT2=metrageTissuT2 * prix;
		 prixTissuBoudin=metrageTissuBoudin * prix;
		 prixTissuCigarette=metrageTissuCigarette * prix;
		 
		 if(prixTissuT1>0)
		    $("#tableCotes tr:eq(1) td:eq(4)").text(toDH(prixTissuT1));
		 else 
			 $("#tableCotes tr:eq(1) td:eq(4)").text("");
		 if(prixTissuT2>0)
			    $("#tableCotes tr:eq(2) td:eq(4)").text(toDH(prixTissuT2));
			 else 
				 $("#tableCotes tr:eq(2) td:eq(4)").text("");
		 if(prixTissuBoudin>0)
			    $("#tableCotes tr:eq(3) td:eq(4)").text(toDH(prixTissuBoudin));
			 else 
				 $("#tableCotes tr:eq(3) td:eq(4)").text("");
		 if(prixTissuCigarette>0)
			    $("#tableCotes tr:eq(4) td:eq(4)").text(toDH(prixTissuCigarette));
			 else 
				 $("#tableCotes tr:eq(4) td:eq(4)").text(""); 	  
		 
		 prixTotalTissu();	 
	}

	function refTissuCSchanged() { 
		 
		 var prix=200; 
		 
		 prixTissuCS = metrageTissuCS * prix;  
		 $("#tissu #tableCoussins tr:eq(1) td:eq(4)").text(toDH(prixTissuCS));
		 
		 prixTotalTissu();
	} 
	
 function tissuCT() {
	  
	 metrageTissuT1=0;
	 metrageTissuT2=0;
	 metrageTissuBoudin=0;
	 metrageTissuCigarette=0;

	 var LT1    	  = parseInt($("#cotes #selectLT1").val());
	 var NbrT1 		  = parseInt($("#cotes #selectNbrT1").val());
	 
	 var LT2    	  = parseInt($("#cotes #selectLT2").val());
	 var NbrT2 		  = parseInt($("#cotes #selectNbrT2").val());
	 
	 var LBoudin      = parseInt($("#cotes #selectLBoudin").val());
	 var NbrBoudin 	  = parseInt($("#cotes #selectNbrBoudin").val());
	 
	 var LCigarette   = parseInt($("#cotes #selectLCigarette").val());
	 var NbrCigarette = parseInt($("#cotes #selectNbrCigarette").val()); 
	 
	 if(NbrT1>0){
		 metrageTissuT1=metrageCT("T1",LT1,NbrT1); 
	     $("#tableCotes tr:eq(1) td:eq(3)").text(toMetre(metrageTissuT1));	 	
	  } else $("#tableCotes tr:eq(1) td:eq(3)").text("");	
	 
	 if(NbrT2>0){ 
		 metrageTissuT2=metrageCT("T2",LT2,NbrT2);
	 	 $("#tableCotes tr:eq(2) td:eq(3)").text(toMetre(metrageTissuT2));
 	  } else $("#tableCotes tr:eq(2) td:eq(3)").text("");		
	 
	 if(NbrBoudin>0){ 
		metrageTissuBoudin=metrageCT("B",LBoudin,NbrBoudin); 
	 	$("#tableCotes tr:eq(3) td:eq(3)").text(toMetre(metrageTissuBoudin)); 
	 } else $("#tableCotes tr:eq(3) td:eq(3)").text("");	
	 
	 if(NbrCigarette>0){
		metrageTissuCigarette=metrageCT("C",LCigarette,NbrCigarette);
	 	$("#tableCotes tr:eq(4) td:eq(3)").text(toMetre(metrageTissuCigarette)); 
	 } else $("#tableCotes tr:eq(4) td:eq(3)").text("");	

	 refTissuCTchanged(); // prix 
 }
 
function couture() {

	  /////// couvertures ////////
	 $("#coutureCV #tableCoutureCV tr:eq(1) td:eq(0)").text(nbr_CV); 
	 $("#coutureCV #tableCoutureCV tr:eq(1) td:eq(1)").text(toMetre(metrageTissuCV));
 
	  ////// cotés //////////
	 
	 var LT1    	  = parseInt($("#cotes #selectLT1").val());
	 var NbrT1 		  = parseInt($("#cotes #selectNbrT1").val());
	 
	 var LT2    	  = parseInt($("#cotes #selectLT2").val());
	 var NbrT2 		  = parseInt($("#cotes #selectNbrT2").val());
	 
	 var LBoudin      = parseInt($("#cotes #selectLBoudin").val());
	 var NbrBoudin 	  = parseInt($("#cotes #selectNbrBoudin").val());
	 
	 var LCigarette   = parseInt($("#cotes #selectLCigarette").val());
	 var NbrCigarette = parseInt($("#cotes #selectNbrCigarette").val()); 
  
	 if(NbrT1>0){
		    $("#coutureCotes #tableCoutureCotes tr:eq(1) td:eq(1)").text(LT1+" cm");
	 		$("#coutureCotes #tableCoutureCotes select#selectNbrT1_couture").select2("val", NbrT1); 		
	 		$("#coutureCotes #tableCoutureCotes tr:eq(1)").show();
	 	} else $("#coutureCotes #tableCoutureCotes tr:eq(1)").hide();
	 
	 if(NbrT2>0){
	 		$("#coutureCotes #tableCoutureCotes tr:eq(2) td:eq(1)").text(LT2+" cm");
	 		$("#coutureCotes #tableCoutureCotes select#selectNbrT2_couture").select2("val", NbrT2*2);
	 		$("#coutureCotes #tableCoutureCotes tr:eq(2)").show();
	 	} else $("#coutureCotes #tableCoutureCotes tr:eq(2)").hide();	
	 
	 if(NbrBoudin>0){
	 		$("#coutureCotes #tableCoutureCotes tr:eq(3) td:eq(1)").text(LBoudin+" cm");
	 		$("#coutureCotes #tableCoutureCotes select#selectNbrBoudin_couture").select2("val", NbrBoudin);
	 		$("#coutureCotes #tableCoutureCotes tr:eq(3)").show();
	 	} else $("#coutureCotes #tableCoutureCotes tr:eq(3)").hide();	
	 
	 if(NbrCigarette>0){
	 		$("#coutureCotes #tableCoutureCotes tr:eq(4) td:eq(1)").text(LCigarette+" cm");
	 		$("#coutureCotes #tableCoutureCotes select#selectNbrCigarette_couture").select2("val", NbrCigarette);
	 		$("#coutureCotes #tableCoutureCotes tr:eq(4)").show();
	 	} else $("#coutureCotes #tableCoutureCotes tr:eq(4)").hide();
	 
	 
	///////////////////// tr background
		 var i=0;
		 $("#coutureCotes #tableCoutureCotes tr").each(function(){ 
			  if ( $(this).is(':visible') ){ 
				 if (i % 2 == 0)
					 $(this).css("background-color" , "rgb(235, 235, 235");  
				 else 
					 $(this).css("background-color" , "rgb(250, 250, 250");
				 i++;
			  }
		}); 
		$("#coutureCotes #tableCoutureCotes tr:eq(0)").css("background-color" , "#E48409");  
		///////////////////////////////////////////////
		 
	if(NbrT1==0 && NbrT2==0 && NbrBoudin==0 && NbrCigarette==0)
		$("#couture #f_coutureCotes").hide();
	else
		$("#couture #f_coutureCotes").show();
	  
	//// coussins ///////////
	
	var NbrCoussin = parseInt($("#coussins #selectNbrCoussin").val());
	$("#coutureCoussins #selectNbrCoussin_couture").select2("val", NbrCoussin);
	
	
 }
 

function garniture() {
 
	  ////// cotés //////////
	 
	 var LT1    	  = parseInt($("#cotes #selectLT1").val());
	 var NbrT1 		  = parseInt($("#cotes #selectNbrT1").val());
	 
	 var LT2    	  = parseInt($("#cotes #selectLT2").val());
	 var NbrT2 		  = parseInt($("#cotes #selectNbrT2").val());
	 
	 var LBoudin      = parseInt($("#cotes #selectLBoudin").val());
	 var NbrBoudin 	  = parseInt($("#cotes #selectNbrBoudin").val());
	 
	 var LCigarette   = parseInt($("#cotes #selectLCigarette").val());
	 var NbrCigarette = parseInt($("#cotes #selectNbrCigarette").val()); 

	 if(NbrT1>0){
		    $("#garnitureCotes #tableGarnitureCotes tr:eq(1) td:eq(1)").text(LT1+" cm");
	 		$("#garnitureCotes #tableGarnitureCotes select#selectNbrT1_garniture").select2("val", NbrT1); 		
	 		$("#garnitureCotes #tableGarnitureCotes tr:eq(1)").show();
	 	} else $("#garnitureCotes #tableGarnitureCotes tr:eq(1)").hide();
	 
	 if(NbrT2>0){
	 		$("#garnitureCotes #tableGarnitureCotes tr:eq(2) td:eq(1)").text(LT2+" cm");
	 		$("#garnitureCotes #tableGarnitureCotes select#selectNbrT2_garniture").select2("val", NbrT2*2);
	 		$("#garnitureCotes #tableGarnitureCotes tr:eq(2)").show();
	 	} else $("#garnitureCotes #tableGarnitureCotes tr:eq(2)").hide();	
	 
	 if(NbrBoudin>0){
	 		$("#garnitureCotes #tableGarnitureCotes tr:eq(3) td:eq(1)").text(LBoudin+" cm");
	 		$("#garnitureCotes #tableGarnitureCotes select#selectNbrBoudin_garniture").select2("val", NbrBoudin);
	 		$("#garnitureCotes #tableGarnitureCotes tr:eq(3)").show();
	 	} else $("#garnitureCotes #tableGarnitureCotes tr:eq(3)").hide();	
	 
	 if(NbrCigarette>0){
	 		$("#garnitureCotes #tableGarnitureCotes tr:eq(4) td:eq(1)").text(LCigarette+" cm");
	 		$("#garnitureCotes #tableGarnitureCotes select#selectNbrCigarette_garniture").select2("val", NbrCigarette);
	 		$("#garnitureCotes #tableGarnitureCotes tr:eq(4)").show();
	 	} else $("#garnitureCotes #tableGarnitureCotes tr:eq(4)").hide();
	 
	 
	///////////////////// tr background
		 var i=0;
		 $("#garnitureCotes #tableGarnitureCotes tr").each(function(){ 
			  if ( $(this).is(':visible') ){ 
				 if (i % 2 == 0)
					 $(this).css("background-color" , "rgb(235, 235, 235");  
				 else 
					 $(this).css("background-color" , "rgb(250, 250, 250");
				 i++;
			  }
		}); 
		$("#garnitureCotes #tableGarnitureCotes tr:eq(0)").css("background-color" , "#E48409");  
		///////////////////////////////////////////////
		 
	if(NbrT1==0 && NbrT2==0 && NbrBoudin==0 && NbrCigarette==0)
		$("#garniture #f_garnitureCotes").hide();
	else
		$("#garniture #f_garnitureCotes").show();
	  
	//// coussins ///////////
	
	var NbrCoussin = parseInt($("#coussins #selectNbrCoussin").val());
	$("#garnitureCoussins #selectNbrCoussin_garniture").select2("val", NbrCoussin);
 
 }

 function calculNbrCoussins() {
	 
  if(metrageBanquettes>0){
	 var largCotes = parseInt($("#cotes #selectLT1").val()) * parseInt($("#cotes #selectNbrT1").val()) +
					 parseInt($("#cotes #selectLT2").val()) * parseInt($("#cotes #selectNbrT2").val()) +
					 parseInt($("#cotes #selectLBoudin").val()) * parseInt($("#cotes #selectNbrBoudin").val()) +
					 parseInt($("#cotes #selectLCigarette").val()) * 2 * parseInt($("#cotes #selectNbrCigarette").val());
	
	 var lcoussin=parseInt($("#coussins #selectLCoussin").val()); 
	 var espaceCoussinCoin=nbrCoussinCoin*15; // 15 cm par coussin
	 
	 var NbrCoussin = Math.round( (metrageBanquettes*100 - largCotes - espaceCoussinCoin)/lcoussin ) + nbrCoussinCoin ;     // *100 cm ceil
	
	 if(NbrCoussin>0){  
		 $("#coussins #selectNbrCoussin").select2("val", NbrCoussin);
		 $("#garnitureCS #selectNbrCoussinGarniture").select2("val", NbrCoussin);
	 }else 
		 $("#coussins #selectNbrCoussin").select2("val", 0);
	 
  } else {
	  $("#coussins #selectNbrCoussin").select2("val", 0);
  } 
 			 
}

 function tissuCS(){
	  
	 var LCoussin    = parseInt($("#coussins #selectLCoussin").val()); 
	 var NbrCoussin  = parseInt($("#coussins #selectNbrCoussin").val()); 
 
	 var m;
	 if(LCoussin<=70) m=60;
	 else if(LCoussin>70) m=LCoussin+5;
	 
	 metrageTissuCS= (m * NbrCoussin)/100;
	 $("#tissu #tableCoussins tr:eq(1) td:eq(3)").text(toMetre(metrageTissuCS));
	 
	 refTissuCSchanged(); // prix
 }
 
 function metrageB(id){
	 
	 	var l = parseInt($("#droppableSalon .sb[data-id="+id+"]").find(".dp-numberPicker-input").val().split(" ")[0]); 
	  
	 	l+=2*parseInt($("#droppableSalon .sb[data-id="+id+"]").find("input.nbrCoinCollision").val());  // coin collision
	   
	 	if(parseInt($("#droppableSalon .sb[data-id="+id+"]").find(".check[name='fauxCoin']").val())==1) 
			 l+=lsB; // lsB pour fauxCoin
		  
	 	if(parseInt($("#droppableSalon .sb[data-id="+id+"]").find(".check[name='accoudoirGauche']").val())==1) 
		 l-=parseInt($("#droppableSalon .sb[data-id="+id+"]").find(".largeurAccoudoir").val()); // - largeur accoudoirGauche
	 	if(parseInt($("#droppableSalon .sb[data-id="+id+"]").find(".check[name='accoudoirDroite']").val())==1) 
			 l-=parseInt($("#droppableSalon .sb[data-id="+id+"]").find(".largeurAccoudoir").val()); // - largeur accoudoirDroite
		 	
		 l=l/100;	
		 metrageBanquettes+=l; 
		 lCV=l;
	     return "<span class='longB'>" + toMetre(l) + "</span>";
}
 
function banquettes() {

      var nbrB=$("#droppableSalon .sb").size();
      metrageBanquettes=0; 
	  var listeBanquettes="<ul>";	
	 
	  lsB=parseInt($("#dessin #largeurSalon").val());
	  
	  if(selectlB_changed==false)
	    $("#banquettes #selectlB").select2("val", lsB);  
	  		    	   
	  lB = parseInt($("#banquettes #selectlB").val());
	  
 
	 var liste_sb; 
	 var li; 
	 $("#droppableSalon .sb").each(function() { 		  
		 li="<li>";
		 li+=metrageB($(this).attr("data-id"));
		 li+="</li>";	 
  	     listeBanquettes+=li;
	 });
	 
	 listeBanquettes+="</ul>";
	 
	 $("#banquettes #nbrB").text(nbrB);
	 $("#banquettes #listeBanquettes").html(listeBanquettes);
	 $("#banquettes #metrageBanquettes").text(toMetre(metrageBanquettes));		
} 


 
function tissu(){
	
	 //// tissu banquettes ///////////////////////////////// 	
	 var nbrB=$("#droppableSalon .sb").size(); 
	 lB = parseInt($("#banquettes #selectlB").val());
	 metrageBanquettes=0;
 
	 nbr_CV=0;
	 var metrage_couverture=0;
	 metrageTissuCV=0;
	 
	 var nbr_couvertures=$("#droppableSalon .couverture").size(); // en dessin
	 var nbr_B_ENcouverture=0;
	 $("#droppableSalon .couverture").each(function() {
		 nbr_B_ENcouverture+=parseInt($(this).find(".nbSupport_couverture").val());
	 }); 
	
	 /*/ pour calculer metrageBanquettes
	 $("#droppableSalon .sb").each(function() { 		 
		 sb_id=$(this).attr("data-id"); 
		 metrageB(sb_id);   
	 });*/
 
	////////////////////// liste couvertures ////////////////////////////
	 var nbSupport_couverture=0;	  
	 var liste_sb;
	 var sb_id;
	 var longCV=0; 
	 var li;
	 var sb_en_couverture = new Array(); 
	 var listeCouvertures="<ul>";
	 
	 $("#droppableSalon .couverture").each(function() {
		 
		 nbSupport_couverture=$(this).find(".nbSupport_couverture").val();
		 liste_sb=$(this).find(".liste_sb");
		 
	     if(nbSupport_couverture>0) {
	        li="<li>"; 
	        longCV=0;
	    	  for (i = 0 ; i < nbSupport_couverture  ; i++) {
	    		    
	    		 sb_id=liste_sb.find("option:eq("+i+")").val();
	    		 sb_en_couverture.push(sb_id);
	    		 li+=metrageB(sb_id);	  
	    		 longCV+=lCV;
	     	  }
	       li+="<div class='longCV'>" + toMetre(longCV) + "</div>"; 
	       li+="</li>";	 
	       listeCouvertures+=li;
	     }	    		  
	 }); 
	 
	 $("#droppableSalon .sb").each(function() { 
		 
		 sb_id=$(this).attr("data-id");
		 if( $.inArray(sb_id , sb_en_couverture) == -1 ){
			 li="<li>";
			 li+=metrageB(sb_id);
			 li+="</li>";	 
			 listeCouvertures+=li;
		 }
		 
	 });
	 
	 listeCouvertures+="</ul>";  
	 
	 ///////////////////////////////////////////////////////////////////////////////////
	 var x_couverture= 0.8;	
	 nbr_CV=nbr_couvertures+(nbrB-nbr_B_ENcouverture);
	 metrage_couverture=nbr_CV*x_couverture;
	 metrageTissuCV=metrageBanquettes+metrage_couverture;
		
	$("#tissuCV #tableTissuCV tr:eq(1) td:eq(0)").text(nbr_CV);
	$("#tissuCV #tableTissuCV tr:eq(1) td:eq(1)").text(toMetre(metrageBanquettes) + " + " + nbr_CV+" x " + x_couverture+" m = " + toMetre(metrageTissuCV));
	$("#tissuCV #listeCouvertures").html(listeCouvertures);	

	calculTissuSupplementaire();	
	
	refTissuCVchanged(); //prix
	
	tissuCT();
	calculNbrCoussins(); 
	tissuCS();
  
	metrageTotalTissu();
	 
}

$( document ).ready(function() {
 
	 $( "#tabs" ).tabs(); 
	 $( "#tabsB, #tabsCT, #tabsCS" ).tabs({
		 create: function( event, ui ) {
			 
			 $(".liG").css({ 
				 top: "2px"
				});
			 $(".liGB").css({ 
				 top: "3px"
				});	
			 $(".liP").css({
				 height: "26px",
				 top: "11px"
				});
				
			 $(".liP a.ui-tabs-anchor").css({
				 padding: "5px",
				 fontSize: "14px" 
				});
			 }
		 }); 
	 
	 $("#selecthB").val("26");
	 $("#select_l1_cb, #select_l2_cb").val("20");  select_dd_cb
	 $("#select_dd_cb, #select_dg_cb").val("80");
	 	
	 $("#tabs").on("tabsactivate", (event, ui) => {

		    if (ui.newPanel.is("#bois")){
		    	
		    	bois();
			 
		    }else if (ui.newPanel.is("#banquettes")) {
		    	
		    	banquettes();
		    	
		    }else if (ui.newPanel.is("#tissu")) { 
		    			 		    	
				tissu();
				
		    }else if (ui.newPanel.is("#couture")) { 
		    			 		    	
		    	couture();
		    	
		    }else if (ui.newPanel.is("#garniture")) { 
		    			 		    	
		    	garniture();
		    }
		     
    });
	
	 /*
	 $("#tabsB").on("tabsactivate", (event, ui) => {

		    if (ui.newPanel.is("#tissuCV")){
		    	
		    	calculTissuSupplementaire();
		    }
	    });
	  
	 $("#tabsCT").on("tabsactivate", (event, ui) => {

		    if (ui.newPanel.is("#tissuCT")){
		    	
		    	tissuCT();
		    	
		    } else if (ui.newPanel.is("#garnitureCT")){
		    	
		    	garnitureCT();
		    }
   
	    });

	 $("#tabsCS").on("tabsactivate", (event, ui) => {

		    if (ui.newPanel.is("#tissuCS")){
		    	
		    	tissuCS();
		    }
	    });
	 */
	 
	$( "#col1Content" ).accordion({
		heightStyle: "content"
	}); 
	
	$("#droppableSalon .sb").each(function(){
		var SBinitial=$(this);
		$(this).find("input.check[value='1']").each(function(){	 
	   	 var name = $(this).attr("name"); 
	   	 	   	 
	   	 if(name=="coinGauche"){
		  if(SBinitial.hasClass("sbh"))  
			  SBinitial.css("border-right","2px dashed #fcf4e2");
		   else
			   SBinitial.css("border-top","2px dashed #fcf4e2");
	   	 }else if(name=="coinDroite"){
		    if(SBinitial.hasClass("sbh"))
		      SBinitial.css("border-left","2px dashed #fcf4e2");	
		     else
		      SBinitial.css("border-bottom","2px dashed #fcf4e2"); 
	   	 } else if(name=="accoudoirGauche")
		   	 SBinitial.find(".divAccoudoirGauche").css("display","block"); 
		   	else if(name=="accoudoirDroite")
			 SBinitial.find(".divAccoudoirDroite").css("display","block");			   	  			 		        	 		        		      
	   }); 
    }); 
 	 	  
	 $(".draggable").draggable({
		  helper: 'clone', 
		  tolerance: 'fit',
		  revert: true
		}); 
	
	$("#droppableSalon").droppable({
		  accept: '.draggable', 
		  drop: function (e, ui) {
		      if ($(ui.draggable)[0].id != "") {	    	  
		    
		          x = ui.helper.clone();
		          
		          var echelle=$("#echelle").val(); 
		          var largeur=$("#largeurSalon").val(); 
		          
		          if ($(ui.draggable)[0].id == "addSBV") { 
		        	   
		        	  x.resizable({
				     		 //containment: "#droppableSalon",
				     		 grid: 1,
					     	 //minHeight: 30,
						     //maxHeight: 300,
				     		 handles: { 
				     			    'n' : '.ngrip',
				     			    's' : '.sgrip'
				     		    },
						      resize: function( event, ui ) {
							      var echelle=$("#echelle").val();
						    	  var hcm = Math.round($(this).height()*echelle/60); // en cm
							      var h=hcm*60/echelle; // en px
							         
							      $(this).css("height",h); 
							      $(this).find(".longueurSpin").dpNumberPicker("setvalue", hcm);								      
							   },
							   stop: function( event, ui ) {
								  collision_coin_sb($(this));  
							   }
				     	 });

		        	   x.find(".longueur").css("visibility","visible");
		        	   x.find(".longueurSpin").dpNumberPicker({
		    				step: 1,
		    				min: 1,
		    				//max:500,
		    				value:200, 
		    				formatter: function(val){
		    					return val+" cm"; 
		    				},
		    				afterChange: function(){
		    					if($(this).attr("class")!=undefined){
		    					 var echelle=$("#echelle").val();		    				
			    				 var w=((this.options.value)*60/echelle) + "px";
			    			     $(this).parent().parent().css("height",w); 
			    			     collision_coin_sb($(this).parent().parent()); 
		    					}  					
			    			}	    				 
		    			}); 
		    			
		        	   x.find(".dp-numberPicker-input").change(function(){
		        		    var echelle=$("#echelle").val();
		        		    var w=(($(this).val().split(" ")[0])*60/echelle) + "px";
		        			$(this).parent().parent().parent().css("height",w);	
		        			collision_coin_sb($(this).parent().parent().parent()); 
		        		});
		        		
		        	   var h = (200*60/echelle) + "px";
			           x.css("height",h);
			           
			           var w = (largeur * 60/echelle) + "px";
			           x.css("width",w); 
			           
			           SB_count++;   
					   x.attr("data-id", "sb_"+SB_count); 
					   
		    	  } else if ($(ui.draggable)[0].id == "addSBH") { 
 
	        	  	  x.resizable({
		        	   //  containment: "#droppableSalon",
			     		 grid: 1,  
				         //minWidth: 30,
				         //maxWidth: 300,
			     		 handles: { 		         
			     		        'e' : '.egrip', 
			     		        'w' : '.wgrip'  
			     		    },
				         resize: function( event, ui ) {
				        	 var echelle=$("#echelle").val();
					         var wcm = Math.round($(this).width()*echelle/60); // en cm
					         var w=wcm*60/echelle; // en px
					         
					         $(this).css("width",w); 
					         $(this).find(".longueurSpin").dpNumberPicker("setvalue", wcm);	 
					      },
						   stop: function( event, ui ) {
								  collision_coin_sb($(this));  
							   }    
			     	    }); 
				     	 
		        	  	   x.find(".longueur").css("visibility","visible");
			        	   x.find(".longueurSpin").dpNumberPicker({
			    				step: 1,
			    				min: 1,
			    				//max:500,
			    				value:200, 
			    				formatter: function(val){
			    					return val+" cm"; 
			    				},
			    				afterChange: function(){
			    					if($(this).attr("class")!=undefined){
			    					 var echelle=$("#echelle").val();		    				
				    				 var w=((this.options.value)*60/echelle) + "px";
				    			     $(this).parent().parent().css("width",w); 	
				    			     collision_coin_sb($(this).parent().parent()); 
			    					}  					
				    			}	    				 
			    			}); 
			    			
			        	   x.find(".dp-numberPicker-input").change(function(){
			        		    var echelle=$("#echelle").val();
			        		    var w=(($(this).val().split(" ")[0])*60/echelle) + "px";
			        			$(this).parent().parent().parent().css("width",w);
			        			collision_coin_sb($(this).parent().parent().parent());
			        		});	

			        	   var w = (200 * 60/echelle) + "px";
				           x.css("width",w);
				           
				           var h = (largeur * 60/echelle) + "px";
				           x.css("height",h);	
				           
				          SB_count++;   
						  x.attr("data-id", "sb_"+SB_count); 	
						  
			    	}else if (  $(ui.draggable)[0].id == "addCoin" || $(ui.draggable)[0].id == "addFauxCoin"  ) {
				    	 			    		 
			    		 var w_h = (largeur * 60/echelle) + "px";	    		        	  
			    	     x.css({
			    	             "height" : w_h,
			    	             "width" : w_h
			    	         });  

			    	     if ($(ui.draggable)[0].id == "addFauxCoin"  ) {

								CN_count++;   
							    x.attr("data-id", "cn_"+CN_count); 
			    	     }





					}else if (  $(ui.draggable)[0].id == "addCan") {
				    	 			    		 
			    		 var w_h = (largeur * 60/echelle) + "px";
			    		 var aj=0.47*parseInt(w_h);
			    		 var  vop  = parseInt(w_h)+parseInt(aj);
			    		 console.log(vop)
		        	  	   x.find(".dimens").css("visibility","visible");
    		        	  
			    	     x.css({
			    	             "height" : vop,
			    	             "width" : vop
					});  


		    	         
				      } else if ($(ui.draggable)[0].id == "addCouvertureH") { 
		        	  	  x.resizable({ 
					     		 grid: 1,  
						         minWidth:40,
					     		 handles: { 		         
					     		        'e' : '.egrip', 
					     		        'w' : '.wgrip'  
					     		    },
						         resize: function( event, ui ) {							          
							         $(this).find("span.fm").css("width", $(this).width()-24 );
							         collision_couverture_sb($(this));
							      },
							      start: function( event, ui ) {
							    	  $(this).addClass("dr");							    	 
							      },
								   stop: function( event, ui ) {
									   $(this).removeClass("dr");
								  }
					     	    }); 
				     	     
					 } else if ($(ui.draggable)[0].id == "addCouvertureV") { 
		        	  	  x.resizable({ 
					     		 grid: 1,  
						         minHeight:40,
					     		 handles: { 		         
					     		        'n' : '.ngrip', 
					     		        's' : '.sgrip'  
					     		    },
						         resize: function( event, ui ) {							          
							         $(this).find("span.fm").css("height", $(this).height()-24 ); 
							         collision_couverture_sb($(this));
							      },
							      start: function( event, ui ) {
							    	  $(this).addClass("dr");
							      },
								   stop: function( event, ui ) {
									   $(this).removeClass("dr");
								  }    
					     	    }); 
				     	     
					 } else if ($(ui.draggable)[0].id == "addPilier") { 
		        	  	  x.resizable({ 
					     		 grid: 1,   
					     		 handles: { 		         
					     		        'e' : '.egrip', 
					     		        'w' : '.wgrip',
						     		    'n' : '.ngrip', 
						     		    's' : '.sgrip'  
					     		    } 
					     	    }); 				     	     
					 }
					 
		    	  
		          ui.helper.remove();
		          
		          if ($(ui.draggable)[0].id == "addPilier") {
			          pilier_count++;
			          x.find(".n_pilier").text(pilier_count);
			          
		        	  x.draggable({
			              helper: 'original',
			              cursor: 'move',
			              containment: '#droppableSalon',
			              snap: true,
			              snapTolerance: 5, 
			              preventCollision: true,	 
			              drop: function (event, ui) {
			                  $(ui.draggable).remove();
			              }
			          });

				 } else	 {         
			      
		           x.draggable({
		              helper: 'original',
		              cursor: 'move',
		              containment: '#droppableSalon',
		              snap: true,
		              snapTolerance: 10,
		              obstacle: ".obstacle",
		              preventCollision: true,
		              start: function() {
			         	$(this).removeClass("obstacle");
			         	
			         	if ( $(ui.draggable)[0].id == "addCouvertureH" || $(ui.draggable)[0].id == "addCouvertureV")
			         		$(this).addClass("dr");			         	
			         		
			          },
			          drag: function() {
			        	  if ( $(ui.draggable)[0].id == "addCouvertureH" || $(ui.draggable)[0].id == "addCouvertureV")
			        		  collision_couverture_sb($(this));
			          },
			          stop: function() { 
			        	  collision_coin_sb($(this));  
			        	  $(this).addClass("obstacle"); 
			        	  
			        	  if ( $(ui.draggable)[0].id == "addCouvertureH" || $(ui.draggable)[0].id == "addCouvertureV"){
				         		$(this).removeClass("dr");
				         		collision_couverture_sb($(this));
			        	  }
			          },
		              drop: function (event, ui) {		            	  
		                  $(ui.draggable).remove();
		              }
		           });
		           
				 }
		          x.mouseover( function() { 
			 		 	$(this).find(".ui-resizable-handle, .options").css("visibility","visible");
			 		 	$(this).find(".dp-numberPicker-sub").css("visibility","visible");
			 		 	$(this).find(".dp-numberPicker-add").css("visibility","visible");   
			 		 });
			 	 
			  	  x.mouseout( function()  {  
			 		    $(this).find(".ui-resizable-handle, .options").css("visibility","hidden"); 
			 			$(this).find(".dp-numberPicker-sub").css("visibility","hidden");
			 		 	$(this).find(".dp-numberPicker-add").css("visibility","hidden"); 
			 		  });
		 		  
		           x.find(".deleteSB").click(function () {
		        	   $(this).tipsy("hide");
		        	   toDelete=$(this).parent().parent();
		        	   dialogConfirm.dialog( "open" ); 
		           });
		 		  
		           x.find(".optionsCoin2").click(function () {
		        	   $(this).tipsy("hide");
		        	   toDelete=$(this).parent().parent();
		        	   //dialogConfirm2.dialog( "open" ); 
					   SB=$(this).parent().parent();	 

     				 var dossierArriere=SB.find("input[name=dossierArriere]").val();
			           $("#dialog-options_c2 select#dossierArriere").select2("val", dossierArriere);
			           if(dossierArriere==1 || dossierArriere==2 ){	        	   			        	   
			        	   $("#dialog-options_c2 #largeurDossier").select2("val", SB.find("input.largeurDossier").val());
			        	   $("#dialog-options_c2 #hauteurDossier").select2("val", SB.find("input.hauteurDossier").val()); 
			        	   $("#dialog-options_c2 select#largeurDossier, #dialog-options_c2 select#hauteurDossier").removeAttr("disabled");			  		     
				       } else
				    	   $("#dialog-options_c2 select#largeurDossier, #dialog-options_c2 select#hauteurDossier").attr("disabled","disabled");	
			           
		        	 dialogOptions_c2.dialog("open");



		           });

		 		  
		           x.find(".optionsCoin1").click(function () {
		        	   $(this).tipsy("hide");
		        	   toDelete=$(this).parent().parent();
		        	   //dialogConfirm2.dialog( "open" ); 
					   SB=$(this).parent().parent();	 

     				 var dossierArriere=SB.find("input[name=dossierArriere]").val();
			           $("#dialog-options_c select#dossierArriere").select2("val", dossierArriere);
			           if(dossierArriere==1 || dossierArriere==2 || dossierArriere==3 || dossierArriere==4){	        	   			        	   
			        	   $("#dialog-options_c #largeurDossier").select2("val", SB.find("input.largeurDossier").val());
			        	   $("#dialog-options_c #hauteurDossier").select2("val", SB.find("input.hauteurDossier").val()); 
			        	   $("#dialog-options_c select#largeurDossier, #dialog-options_c select#hauteurDossier").removeAttr("disabled");			  		     
				       } else
				    	   $("#dialog-options_c select#largeurDossier, #dialog-options_c select#hauteurDossier").attr("disabled","disabled");	
			           
		        	 dialogOptions_c.dialog("open");



		           });




		           if(x.hasClass("sb"))
		           {
		        	    
		            x.find(".optionsSB").click(function () {
			            			           
					   SB=$(this).parent().parent();	 
					   SB.find("input.check[value='1']").each(function(){	 
			        	 var id = $(this).attr("name"); 
		        		 $("#dialog-options input#"+id).iCheck('check');  			        	 		        		      
		        		});
			        		  
		        	   var largeurAccoudoir=parseInt(SB.find("input.largeurAccoudoir").val());	

			           if(largeurAccoudoir!=0)  			      
			        	 $("#dialog-options #largeurAccoudoir").select2("val", largeurAccoudoir);
			           
			         
			           if(SB.hasClass("sbh"))
			           { 
			        	   $("#dialog-options label[for=accoudoirGauche]").text("À gauche");
			        	   $("#dialog-options label[for=accoudoirDroite]").text("À droite");
			        	   $("#dialog-options label[for=faceGauche]").text("À gauche");
			        	   $("#dialog-options label[for=faceDroite]").text("À droite");
			        	   $("#dialog-options select#dossierArriere option:eq(1)").text("En haut");
			        	   $("#dialog-options select#dossierArriere option:eq(2)").text("En bas");
						   $("#dialog-options select#dossierArriere2 option:eq(1)").text("À gauche");
			        	   $("#dialog-options select#dossierArriere2 option:eq(2)").text("À droite");

			           } else if(SB.hasClass("sbv"))
			           {
			        	   $("#dialog-options label[for=accoudoirGauche]").text("En haut");
			        	   $("#dialog-options label[for=accoudoirDroite]").text("En bas");
			        	   $("#dialog-options label[for=faceGauche]").text("En haut");
			        	   $("#dialog-options label[for=faceDroite]").text("En bas");
			        	   $("#dialog-options select#dossierArriere option:eq(1)").text("À gauche");
			        	   $("#dialog-options select#dossierArriere option:eq(2)").text("À droite");
						   $("#dialog-options select#dossierArriere2 option:eq(1)").text("En haut");
			        	   $("#dialog-options select#dossierArriere2 option:eq(2)").text("En bas");
			           }
			           
			           var dossierArriere=SB.find("input[name=dossierArriere]").val();
			           $("#dialog-options select#dossierArriere").select2("val", dossierArriere);
			           if(dossierArriere==1 || dossierArriere==2){	        	   			        	   
			        	   $("#dialog-options #largeurDossier").select2("val", SB.find("input.largeurDossier").val());
			        	   $("#dialog-options #hauteurDossier").select2("val", SB.find("input.hauteurDossier").val()); 
			        	   $("#dialog-options select#largeurDossier, #dialog-options select#hauteurDossier").removeAttr("disabled");			  		     
				       } else
				    	   $("#dialog-options select#largeurDossier, #dialog-options select#hauteurDossier").attr("disabled","disabled");	
			           
		        	 dialogOptions.dialog("open");		        	 	   		        	   
		            });

		            x.find(".formeSB").click(function () {	
    		            
		            	SB=$(this).parent().parent();
		            	  
		            	$( "#dialog-forme-sb .borderTopLeftRadiusInput" ).val(SB.css("border-top-left-radius"));
		            	$( "#dialog-forme-sb .borderTopLeftRadius" ).slider( "value", SB.css("border-top-left-radius").split('px')[0] ); 
		            	
		            	$( "#dialog-forme-sb .borderTopRightRadiusInput" ).val(SB.css("border-top-right-radius"));
		            	$( "#dialog-forme-sb .borderTopRightRadius" ).slider( "value", SB.css("border-top-right-radius").split('px')[0] );
		            	
		            	$( "#dialog-forme-sb .borderBottomLeftRadiusInput" ).val(SB.css("border-bottom-left-radius"));
		            	$( "#dialog-forme-sb .borderBottomLeftRadius" ).slider( "value", SB.css("border-bottom-left-radius").split('px')[0] );	

		            	$( "#dialog-forme-sb .borderBottomRightRadiusInput" ).val(SB.css("border-bottom-right-radius"));
		            	$( "#dialog-forme-sb .borderBottomRightRadius" ).slider( "value", SB.css("border-bottom-right-radius").split('px')[0] );
		            	
		            	dialogFormeSB.dialog("open");        	   
			        });	
		            
		           } else if(x.hasClass("pilier")){
			           		           
			            x.find(".optionsPilier").click(function () {
			            	dialogOptionsPilier.dialog("open");        	   
				        });	
				        	
			            x.find(".formePilier").click(function () {	
				            		            
			            	PILIER=$(this).parent().parent();
			            	$("#dialog-forme-pilier select.borderTopStyle").select2("val", PILIER.css("border-top-style"));
			            	$("#dialog-forme-pilier select.borderBottomStyle").select2("val", PILIER.css("border-bottom-style"));
			            	$("#dialog-forme-pilier select.borderLeftStyle").select2("val", PILIER.css("border-left-style"));
			            	$("#dialog-forme-pilier select.borderRightStyle").select2("val", PILIER.css("border-right-style"));
			            	
			            	 //    
			            	$( "#dialog-forme-pilier .borderTopLeftRadiusInput" ).val(PILIER.css("border-top-left-radius"));
			            	$( "#dialog-forme-pilier .borderTopLeftRadius" ).slider( "value", PILIER.css("border-top-left-radius").split('px')[0] ); 
			            	
			            	$( "#dialog-forme-pilier .borderTopRightRadiusInput" ).val(PILIER.css("border-top-right-radius"));
			            	$( "#dialog-forme-pilier .borderTopRightRadius" ).slider( "value", PILIER.css("border-top-right-radius").split('px')[0] );
			            	
			            	$( "#dialog-forme-pilier .borderBottomLeftRadiusInput" ).val(PILIER.css("border-bottom-left-radius"));
			            	$( "#dialog-forme-pilier .borderBottomLeftRadius" ).slider( "value", PILIER.css("border-bottom-left-radius").split('px')[0] );	

			            	$( "#dialog-forme-pilier .borderBottomRightRadiusInput" ).val(PILIER.css("border-bottom-right-radius"));
			            	$( "#dialog-forme-pilier .borderBottomRightRadius" ).slider( "value", PILIER.css("border-bottom-right-radius").split('px')[0] );
			            	
			            	dialogFormePilier.dialog("open");        	   
				        });				            
		           }
		           
		           x.find(".options img, .options input.nbSupport_couverture").tipsy({gravity: 's'});


		           x.appendTo('#droppableSalon');
		           
		           
		           collision_coin_sb(x);  
		           collision_couverture_sb(x);
		      }
		  }
		});	
	 
	 dialogOptions = $("#dialog-options").dialog({
		 autoOpen: false,
		 height: 470,
		 width: 270,
		 modal: true,
		 buttons: {
		 	"Valider": editOptions,
		 	"Annuler": function() { dialogOptions.dialog( "close" ); }
		 },
	     close: function(event, ui) {
		   $('#dialog-options input').iCheck('uncheck'); 
		 }
	  }); 

	 

	 	 dialogOptions_c = $("#dialog-options_c").dialog({
		 autoOpen: false,
		 height: 270,
		 width: 270,
		 modal: true,
		 buttons: {
		 	"Valider": editOptions_c,
		 	"Annuler": function() { dialogOptions_c.dialog( "close" ); }
		 },
	     close: function(event, ui) {
		   $('#dialog-options_c input').iCheck('uncheck'); 
		 }
	  }); 


	 	 dialogOptions_c2 = $("#dialog-options_c2").dialog({
		 autoOpen: false,
		 height: 270,
		 width: 270,
		 modal: true,
		 buttons: {
		 	"Valider": editOptions_c2,
		 	"Annuler": function() { dialogOptions_c2.dialog( "close" ); }
		 },
	     close: function(event, ui) {
		   $('#dialog-options_c2 input').iCheck('uncheck'); 
		 }
	  }); 

	  
	 dialogOptionsPilier = $("#dialog-options-pilier").dialog({
		 autoOpen: false,
		 height: 300,
		 width: 270,
		 modal: true,
		 buttons: {
		 	"Valider": editOptions_pilier,
		 	"Annuler": function() { dialogOptionsPilier.dialog( "close" ); }
		 } 
	  });
	  
	 dialogFormePilier = $("#dialog-forme-pilier").dialog({
		 autoOpen: false,
		 height: 415,
		 width: 270,
		 modal: true
	  });	  

	 dialogFormeSB = $("#dialog-forme-sb").dialog({
		 autoOpen: false,
		 height: 290,
		 width: 270,
		 modal: true
	  });



	  
	 dialogConfirm = $("#dialog-confirm" ).dialog({
			  autoOpen: false,
		      resizable: false,
		      height:'auto',
		      width: 400,
		      modal: true, 
		      buttons: {
		    	"Non": function() {
		    		dialogConfirm.dialog( "close" );
			        },
		        "Oui": function() {
		        	//supprimerBien(idBienToDelete); 
		             $(toDelete).remove();
		             toDelete=null;
		             dialogConfirm.dialog( "close" );
		        }        
		      }
	 });
	 



	  
	 dialogConfirm2 = $("#dialog-confirm2" ).dialog({
			  autoOpen: false,
		      resizable: false,
		      height:'auto',
		      width: 400,
		      modal: true, 
		      buttons: {
		    	"Non": function() {
		    		dialogConfirm.dialog( "close" );
			        },
		        "Oui": function() {
		        	//supprimerBien(idBienToDelete); 
		             $(toDelete).remove();
		             toDelete=null;
		             dialogConfirm.dialog( "close" );
		        }        
		      }
	 });
	 




	 $('input.check').iCheck({
		    checkboxClass: 'icheckbox_flat-orange',
		    radioClass: 'iradio_flat-orange'
     });
 
	 $('#dialog-forme-pilier .slider').slider({
	        value: 0,
	        min: 0,
	        max: 200,
	        step: 1,
	        slide: function(event, ui) {
		        var className=$(this).attr("class").split(' ')[1];
	            $("#dialog-forme-pilier ."+className+"Input" ).val( ui.value+"px" );
	            PILIER.css(className, ui.value); 
		     } 
	    });   
	    
	 $('#dialog-forme-pilier select.borderStyle').change(function(){
		 PILIER.css($(this).attr("class").split(' ')[1], $(this).val());    			        			
		});
	
	 $('#dialog-forme-sb .slider').slider({
	        value: 0,
	        min: 0,
	        max: 200,
	        step: 1,
	        slide: function(event, ui) {
		        var className=$(this).attr("class").split(' ')[1];
	            $("#dialog-forme-sb ."+className+"Input" ).val( ui.value+"px" );
	            SB.css(className, ui.value); 
            	SB.find("input.facerondu").val('1');

		     } 
	    });

	 $("select.s1").select2({width : 90});	
	 $("select.s2").select2({width : 95});	 
	 $("#col1 #largeurSalon").select2("val", 70);
	 $("#col1 #hauteurSB").select2("val", 26);
	 $("#dialog-options #largeurAccoudoir").select2("val", 14);
	 $("#bois select.s2").select2({width : 200}); 
	 $("#banquettes select#selectTypeBanquette").select2({width : 100}); 
	 
	 $("#dialog-options #largeurDossier").select2("val", 5);
	 $("#dialog-options #hauteurDossier").select2("val", 80);
	 
	 $("#cotes #selectLT1").select2("val", 36);
	 $("#cotes #selectLT1").select2("val", 36);
	 $("#cotes #selectLT2").select2("val", 36);
	 $("#cotes #selectLBoudin").select2("val", 24);
	 $("#cotes #selectLCigarette").select2("val", 12);
	 
	 $("#coussins #selectLCoussin").select2("val", 70);
	 $("#coussins #selectHCoussin").select2("val", 57);
	 
	 $("#col1 *[title]").tipsy({gravity: 's'});
	 $("input.lcs_check").lc_switch();
	 
	 
	 /*
	 $('#banquettes select#selectTypeBanquette').change(function(){
		 if($(this).val()=="garniture") 
			 $( "#tabsB" ).tabs( "enable", "#garnitureB" );  
		 else 
			 $( "#tabsB" ).tabs( "disable", "#garnitureB" ); 
	 });
	 
	 $("body").delegate("#onCommandBois .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandBois").css("background","#F2FFF2");
			   $("#CommandBois").fadeIn(); 
		   } else {
			   $("#onCommandBois").css("background","");
			   $("#CommandBois").fadeOut(); 
		   }
		});
	 
	 $("body").delegate("#onCommandTissuB .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandTissuB").css("background","#F2FFF2");
			   $("#CommandTissuB").fadeIn(); 
		   } else {
			   $("#onCommandTissuB").css("background","");
			   $("#CommandTissuB").fadeOut(); 
		   }
		}); 
	 
	 $("body").delegate("#onCommandBanquette .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandBanquette").css("background","#F2FFF2");
			   $("#CommandBanquette").fadeIn(); 
		   } else {
			   $("#onCommandBanquette").css("background","");
			   $("#CommandBanquette").fadeOut(); 
		   }
		}); 
	 
	 $("body").delegate("#onCommandCoutureB .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandCoutureB").css("background","#F2FFF2");
			   $("#CommandCoutureB").fadeIn(); 
		   } else {
			   $("#onCommandCoutureB").css("background","");
			   $("#CommandCoutureB").fadeOut(); 
		   }
		});  	 

	 /////////////////////////////////////// cotés /////////////////////////////////////////////
	 $("body").delegate("#onCommandTissuCT .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandTissuCT").css("background","#F2FFF2");
			   $("#CommandTissuCT").fadeIn(); 
		   } else {
			   $("#onCommandTissuCT").css("background","");
			   $("#CommandTissuCT").fadeOut(); 
		   }
		}); 
	 $("body").delegate("#onCommandCoutureCT .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandCoutureCT").css("background","#F2FFF2");
			   $("#CommandCoutureCT").fadeIn(); 
		   } else {
			   $("#onCommandCoutureCT").css("background","");
			   $("#CommandCoutureCT").fadeOut(); 
		   }
		}); 
	 $("body").delegate("#onCommandGarnitureCT .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandGarnitureCT").css("background","#F2FFF2");
			   $("#CommandGarnitureCT").fadeIn(); 
		   } else {
			   $("#onCommandGarnitureCT").css("background","");
			   $("#CommandGarnitureCT").fadeOut(); 
		   }
		}); 
	 //////////////////////////////////////////// coussins ///////////////////////////////////////
	 $("body").delegate("#onCommandTissuCS .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandTissuCS").css("background","#F2FFF2");
			   $("#CommandTissuCS").fadeIn(); 
		   } else {
			   $("#onCommandTissuCS").css("background","");
			   $("#CommandTissuCS").fadeOut(); 
		   }
		}); 
	 $("body").delegate("#onCommandCoutureCS .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandCoutureCS").css("background","#F2FFF2");
			   $("#CommandCoutureCS").fadeIn(); 
		   } else {
			   $("#onCommandCoutureCS").css("background","");
			   $("#CommandCoutureCS").fadeOut(); 
		   }
		}); 
	 
	 $("body").delegate("#onCommandGarnitureCS .lcs_check", "lcs-statuschange", function() {
		 if( $(this).is(':checked') ){
			   $("#onCommandGarnitureCS").css("background","#F2FFF2");
			   $("#CommandGarnitureCS").fadeIn(); 
		   } else {
			   $("#onCommandGarnitureCS").css("background","");
			   $("#CommandGarnitureCS").fadeOut(); 
		   }
		}); 
	 
	 */
	 
	 $('select[name="colorpicker"]').simplecolorpicker({picker: true, theme: 'glyphicons'});
	 
	 
	 
	  $("#dialog-options input#accoudoirGauche, #dialog-options input#accoudoirDroite").on('ifChecked', function(event){
		  $("#dialog-options select#largeurAccoudoir").removeAttr("disabled");
	  });
	  
	  $("#dialog-options input#accoudoirGauche").on('ifUnchecked', function(event){ 
	    $("#dialog-options input#faceGauche").iCheck('enable');  
	    if( !$('#dialog-options input#accoudoirDroite').is(":checked") ) 
	    	$("#dialog-options select#largeurAccoudoir").attr("disabled","disabled");
	  });

	  $("#dialog-options input#accoudoirDroite").on('ifUnchecked', function(event){ 
		$("#dialog-options input#faceDroite").iCheck('enable'); 
		if( !$('#dialog-options input#accoudoirGauche').is(":checked") ) 
		    $("#dialog-options select#largeurAccoudoir").attr("disabled","disabled");
	  });
	  
	  ///////////////////////////////////////////////////////////////////////////////////////////////////
	  $("#dialog-options input#accoudoirGauche").on('ifChecked', function(event){
		  $("#dialog-options input#faceGauche").iCheck('uncheck');
		  $("#dialog-options input#faceGauche").iCheck('disable');
	  });
	  $("#dialog-options input#accoudoirDroite").on('ifChecked', function(event){
		  $("#dialog-options input#faceDroite").iCheck('uncheck');
		  $("#dialog-options input#faceDroite").iCheck('disable');
	  });
	  ///////////////////////////////////////////////////////////////////////////////////////////////////
	  
	  $("#dialog-options input#dossierArriere").on('ifChecked', function(event){
		  $("#dialog-options select#largeurDossier, #dialog-options select#hauteurDossier").removeAttr("disabled");
	  });
	  
	  $("#dialog-options select#dossierArriere").change(function(){	 
		     var dossierArriere=$(this).val();
		     if(dossierArriere==1 || dossierArriere==2)
		    	 $("#dialog-options select#largeurDossier, #dialog-options select#hauteurDossier").removeAttr("disabled");		    	  
		     else 
		    	 $("#dialog-options select#largeurDossier, #dialog-options select#hauteurDossier").attr("disabled","disabled");	
			 
		 });
	  
		 ///////////////////////  changement des select défault  ///////////////////////////
	  	
	     ///////// bois ////////////
		 $("#banquettes select#selectlB").change(function(){ 
			 selectlB_changed=true;		
			 lB=parseInt($(this).val());
			 tissuCT();
		 });
		 
		 $("#col1 #largeurSalon").change(function(){ 
			 selectlB_changed=false;	 
		 });
		 
		 $("#bois select#prixFC").change(function(){ 
			 refBoisChanged();	 
		 });
		 
		 ///////// tissu ////////////
		 $("#cotes #tableCotes select").change(function(){
			 tissuCT();
			 calculNbrCoussins();
			 tissuCS();
			 metrageTotalTissu();
		 });
		 
		 $("#coussins select#selectLCoussin").change(function(){ 
			 calculNbrCoussins();
			 tissuCS();
			 metrageTotalTissu();
		 });
		 
		 $("#coussins select#selectNbrCoussin").change(function(){			
			 tissuCS();
			 metrageTotalTissu();
			// $("#garnitureCS #selectNbrCoussinGarniture").select2("val", $(this).val());
		 });
		  
}); 
