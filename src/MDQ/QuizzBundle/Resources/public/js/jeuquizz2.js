﻿$(function () {	 
jQuery(document).ready(function() {
       // console.log("jQuery est prêt !");
		//alert('dans jquerry');
	var numQ=0;
	var volume_son=0.1;
	var repselect; var error;
	var timerID; var timeLeft;
	// ********** Critères principaux : ceux du Masterquizz **********************
		var afficheTheme=1; var dossier=""; var hauteur='195'; var clearImage=1; var gameTime=15000; var comTime=12000; var affichCom=1; var interQTime=500; var BigImg=0; var fondSon=1; var game="MasterQuizz";
	toutaulong()
	init();	
	// ---- Fonction valable sur toute la partie du jeu // -------
	function volume(){
			if(volume_son==1){volume_son=0;
							$('#quizz_volume img').attr({src:'../../../bundles/mdqquizz/images/vol0.png'});}
			else if(volume_son==0){volume_son=0.1;
							$('#quizz_volume img').attr({src:'../../../bundles/mdqquizz/images/vol1.png'});}
			else if(volume_son==0.1){volume_son=0.4;
							$('#quizz_volume img').attr({src:'../../../bundles/mdqquizz/images/vol2.png'});}
			else if(volume_son==0.4){volume_son=1;
							$('#quizz_volume img').attr({src:'../../../bundles/mdqquizz/images/vol3.png'});}
			//alert(volume_son);
			$('#son_fondjeu')[0].volume=0.5*0.33*volume_son;
			if(game=="MuQuizz"){$('#music_Q')[0].volume=1*0.33*volume_son;}	
		}
	function toutaulong(){	
		$('#quizz_volume').on('click',volume);
	}
	//-------------------- A chaque question ----------------------
	function init() {// réinitialise les variables, les vues, et lance la phase 0;
		numQ=numQ+1; error=0;
		repselect="none"; timeLeft=gameTime/100;
		$('#bloc_question_dom').text('').attr('class','bloc_question_dom_N'); $('#bloc_question_numQ').text('');$('#bloc_question_intitule').text('');$('#bloc_question_theme').text('');$('#bloc_question_intitule').text(''); $('#bloc_question_commentaire').text('').css('display','none'); $('#bloc_question_photo img').attr({src:''});
		
		$('#bloc_question_bas_txt').text('Chargement de la question ...');
		$('#bloc_question_bas_txt2').text('').css('display','none');
		$('#bloc_question_bas_txt3').text('').css('display','none');
		$('#bloc_question_bas3').css('display','none');
		
//		$('#rep1').text('').css('line-height','40px').css('white-space','nowrap'); $('#rep2').text('').css('line-height','40px').css('white-space','nowrap'); $('#rep3').text('').css('line-height','40px').css('white-space','nowrap'); $('#rep4').text('').css('line-height','40px').css('white-space','nowrap');
		$('#rep1').text(''); $('#rep2').text(''); $('#rep3').text(''); $('#rep4').text('');

		$('.bloc_reponse').attr('class','bloc_reponse');
		
		$('#jeu_bloc_valid img').attr({src:'../../../bundles/mdqgene/images/buttonvalidMq.png'});
		$('#jeu_bloc_error img').attr({src:'../../../bundles/mdqgene/images/maboulejaune.png', width:'15px'});
		$('#jeu_bloc_bloc_precise_error').css('display','none');
		$('input[class="checkbox_error"]').prop('checked', false);		
		$('#bloc_question_photo').css('display','none');
		$('#bloc_question_photo img').attr({src: '', alt: '', height: ''});
		$('#bloc_question_photo2 img').css('display','none');
		$('#bloc_question_photo img').attr({src: '', alt: '', height: ''});
		setTimeout(function () { 
			phase0(numQ); 
		}, interQTime);
	}
	function defineParameter(dom1)
	{
		
		if(dom1=="TvQuizz")
		{
			afficheTheme=0; dossier="TV/"; hauteur='300'; clearImage=0; gameTime=12000; timeLeft=120; comTime=8000; interQTime=1500; BigImg=1;
		}
		else if (dom1=="SexyQuizz")
		{
			afficheTheme=0; dossier="Sexy/";
		}
		else if (dom1=="FfQuizz")
		{
			afficheTheme=0; dossier="Ff/"; hauteur='300'; clearImage=0; comTime=8000; affichCom=0; interQTime=1500; BigImg=1;			
		}
		else if (dom1=="LxQuizz")
		{
			afficheTheme=0; dossier="Lx/"; hauteur='300'; clearImage=0; comTime=8000; affichCom=1; interQTime=1500; BigImg=1;			
		}
		else if (dom1=="WzQuizz")
		{
			afficheTheme=0; dossier="Wz/"; hauteur='300'; clearImage=0; comTime=8000; affichCom=1; interQTime=1500; BigImg=1;			
		}
		else if (dom1=="ArQuizz")
		{
			afficheTheme=0; dossier="Ar/"; hauteur='300'; clearImage=0; comTime=8000; affichCom=1; interQTime=1500; BigImg=1;			
		}
		else if (dom1=="MuQuizz")
		{
			afficheTheme=0; comTime=12000; affichCom=1; interQTime=1500; fondSon=0; game="MuQuizz";
			$('<source id="music_Q_mp3"/>').appendTo($('#music_Q'));
			$('<source id="music_Q_ogg"/>').appendTo($('#music_Q'));
		}
		
	}
	function clickerror(){// Comme le click erro est activé sur pluseiurs phase et désactivé sur une autre, je le mets en fonction générale.
			$('#jeu_bloc_error').off('click',clickerror);
			$('#jeu_bloc_error img').attr({src:'../../../bundles/mdqgene/images/maboulerouge.png', width:'15px'});
			error=1;
			//alert('erreur signalée');
		}
	function phase0(numQ){//requête qui va chercher la question
		//alert('dans phase0');
		$.ajax({
                url: 'http://localhost/MondeDuQuizz/web/app_dev.php/quizz/editQuestion',
                type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
                data:{numQ : numQ },
                dataType: 'json',
                success: function(question) {
                    // alert('success');
					if(question['id']=="error"){window.location.replace("http://localhost/MondeDuQuizz/web/app_dev.php/");}
					if(numQ==1){defineParameter(question['dom1']);}
					if(fondSon!=0){$('#son_fondjeu')[0].volume=0.5*0.33*volume_son;
							$('#son_fondjeu')[0].play();}
					 if(afficheTheme==0){phase2(question);}
					 else{phase1(question);}      
						}                
         });
		 return;
	}
	function phase1(question){// affichage du theme, du dom, de la diff, avec timer.		
		if(question['dom1']=='Histoire'){$('#bloc_question_dom').attr('class','bloc_question_dom_H');}
		else if(question['dom1']=='Géographie'){$('#bloc_question_dom').attr('class','bloc_question_dom_G');}
		else if(question['dom1']=='Divers'){$('#bloc_question_dom').attr('class','bloc_question_dom_D');}
		else if(question['dom1']=='Sciences et nature'){$('#bloc_question_dom').attr('class','bloc_question_dom_SN');}
		else if(question['dom1']=='Sports et loisirs'){$('#bloc_question_dom').attr('class','bloc_question_dom_SL');}
		else if(question['dom1']=='Arts et Littérature'){$('#bloc_question_dom').attr('class','bloc_question_dom_AL');}
		$('#bloc_question_dom').text(question['dom1']);
		$('#bloc_question_theme').text(question['theme']);
		$('#bloc_question_diff img').attr({src:'../../../bundles/mdqquizz/images/diff'+question['diff']+'.png'});
		//$('#bloc_question_diff').text('niveau : '+question['diff']);
		$('#bloc_question_diff img').load(function(){
			$('#bloc_question_theme_diff').css('display','inline-block');
		});
		$('#bloc_question_bas_txt').text('');
		setTimeout(function () { 
			phase2(question); 
		}, 3000);
		return;
	}
	function phase2(question){//affichage intitulé et rep, timer, clickrep, clickvalid, clickerreur
	// **** Fonction prérequise : prise telle quel, me permet d'adapter la mise en forme à la taille du texte.
	/*	function textWidth (texte,police,taille)
					{// fonction pour calculer la taille d'un texte en pixel
					var container=document.createElement('div');					
					container.style.visibility='hidden';
					container.style.display='inline';
					container.style.lettreSpacing='1px';
					container.style.wordSpacing='110%';
					container.style.width='1px';
					container.style.fontFamily=police;
					container.style.fontSize=taille;
					//alert (texte+"  "+container.style.fontSize+" "+container.style.fontFamily);
					container.id="magicdiv";
					document.body.appendChild(container);
					document.getElementById('magicdiv').style.overflow="auto";
					document.getElementById('magicdiv').innerHTML=texte;
					var longueur = document.getElementById('magicdiv').scrollWidth;
					document.getElementById('magicdiv').parentNode.removeChild(document.getElementById('magicdiv'))
					return longueur;
		}*/
	//************ Affichage Question ****************************/
		
		$('#bloc_question_bas_txt').text('');		
		$('#bloc_question_theme_diff').css('display','none');
		$('#bloc_question_numQ').text(numQ).css('display','inline-block');
		$('#bloc_question_bas_txt').css('color','rgb(234,254,255)');
		// Adaptation en fonction du type de la question
		if(question['type']=="texte"){
			$('#bloc_question_intitule').text(question['intitule']).css('display','inline-block');
			$('#bloc_question_bas_txt').text('');
			phase2bis(question);
			}
		else if(question['type']=="citation"){
			$('#bloc_question_intitule').text(question['intitule']).css('display','inline-block');
			$('#bloc_question_bas_txt').text('A qui doit-on cette célèbre phrase ?');
			}
		else if(question['type']=="suitelog"){
			$('#bloc_question_intitule').text(question['intitule']).css('display','inline-block');
			$('#bloc_question_bas_txt').text('Quel nombre vient compléter cette suite logique ?');
			}
		else if(question['type']=="citationlitt"){
			$('#bloc_question_intitule').text(question['intitule']).css('display','inline-block');
			$('#bloc_question_bas_txt').text('De quelle oeuvre est extrait ce texte ?');
			}
		else if(question['type']=="image"){
			if(BigImg==0){
			  $('#bloc_question_photo img').attr({src: '../../../../../../../../MondeDuQuizz/web/bundles/mdqquestion/images/imgQuestions/'+dossier+question['media']+'.jpg', alt: question['media'], height: hauteur}).load(function(){
				  $('#bloc_question_photo').css('display','inline-block');
				  
				   if(question['intitule']!="none"){
				  $('#bloc_question_bas_txt').text(question['intitule']);}
				  else{$('#bloc_question_bas_txt').text('');}				   
			  });
			 setTimeout(function () { 
				      phase2bis(question);
				}, 300);
			}
		//	else{phase2bis(question);}
			else if(BigImg==1){
			    hauteur=$('#bloc_question_photo2').height();
			    $('#bloc_question_photo2 img').attr({src: '../../../../../../../../MondeDuQuizz/web/bundles/mdqquestion/images/imgQuestions/'+dossier+question['media']+'.jpg', alt:question['media'], height: hauteur}).load(function(){				  
				  var largeurImg=0.98*$('#bloc_question_photo2 img').width();
				  var largeur=largeurImg;
				  
				  if(largeurImg>600)
				  {   largeur=600;  }
				  else if(largeurImg>$('#bloc_page').width())
				  { var largeur=$('#bloc_page').width(); }
				   if(largeurImg>largeur+10)
				    {
					var marginL=((largeurImg-largeur)/2);
					$('#bloc_question_photo2 img').css('margin-left','-'+marginL+'px');
				    }
				    else{$('#bloc_question_photo2 img').css('margin-left','0px');}
				   // alert("largeur : "+largeur+"; largeurImg :"+largeurImg);
				 $('#bloc_question_photo2').animate({'width':largeur},400,function(){
				  $('#bloc_question_photo2').css('width',largeur);
				  $('#bloc_question_photo2 img').css('display','inline-block');
				  }); // Je supprime ma petite animation, car il y a une sorte de "saut" de l'image après affichage.
			      });
			    setTimeout(function () { 
				      phase2bis(question);
				}, 300);
			}
		}
		else if(question['type']=="audio"){
				$('#bloc_question_photo img').attr({src: '../../../../../../../../MondeDuQuizz/web/bundles/mdqquizz/images/musique.jpg', alt: "musique", height: '100'});
				$('#bloc_question_photo').css('display','inline-block');
				$('#music_Q_mp3').attr({src: '../../../../../../../../MondeDuQuizz/web/bundles/mdqquestion/sons/'+question['media']+'.mp3'});
				$('#music_Q_ogg').attr({src: '../../../../../../../../MondeDuQuizz/web/bundles/mdqquestion/sons/'+question['media']+'.ogg'});
				$('#music_Q')[0].load();
				$('#music_Q')[0].volume=1*0.33*volume_son;
				$('#music_Q')[0].play();
				setTimeout(function () { 
				      phase2bis(question);
				}, 2000);
			}
		else{
			$('#bloc_question_intitule').text('Erreur dans le type de la question').css('display','inline-block');
			 
			}
		if(question['type']=="citation" || question['type']=="citationlitt" || question['type']=="suitelog") {phase2bis(question);}
		
	}
	function phase2bis(question)// Pour différer l'afficher des proposition, ntamment pour les questions photos.
	{
		for (var i=1;i<5;i++){			
			/*var taille=textWidth(question['rep'+i],'serif',$('#rep'+i).css('font-size'));
			//alert(question['rep'+i]+';'+taille);
			if(taille>178){
				$('#rep'+i).css('line-height','22px').css('white-space','normal')
			}
			*/
			$('#rep'+i).text(question['rep'+i]);
		}
		
	//*********** Mise en place des évènement click ***************** //
	// clickrep et clickvalid
		$('.bloc_reponse').on('click',clicrep);
		function clicrep(){
			$('.bloc_reponse').attr('class','bloc_reponse');
			$(this).attr('class','bloc_reponse reponse_select');
			repselect=$(this).text();			
		}
		$('#jeu_bloc_valid').on('click',clicvalid);
		function clicvalid(){
			if(repselect!="none"){
				//alert(repselect);
				if(fondSon!=0 && question['dom1']!="SexyQuizz")
					{$('#son_fondjeu')[0].pause();
					$('#son_fondjeu')[0].currentTime=0;
					}
				$('#son_clicvalid')[0].volume=0.5*0.33*volume_son;
				$('#son_clicvalid')[0].play();
				$('.bloc_reponse').off('click',clicrep);
				clearTimeout(timerID);
				clearInterval(intervalID);
				$('#jeu_img_boule_noire').stop(true, false);
				var tpsrestant=timeLeft;
				$('#jeu_bloc_valid img').attr({src:'../../../bundles/mdqgene/images/buttonvalidMq3.png'});
				$('#jeu_bloc_valid').off('click',clicvalid);
				setTimeout(function () { 
					phase3(question['id'], repselect, tpsrestant);	 
				}, 500);
						
			}
		}
		$('#jeu_bloc_error').on('click',clickerror);
		
	// gestion du timer
		clearTimeout(timerID);
		
		$('#jeu_img_boule_noire').fadeTo(gameTime,0.01);
		timerID = setTimeout(function() {
			clearInterval(intervalID);
			clearTimeout(timerID);
			//alert("fin du timer");			
			$('#jeu_bloc_valid').off('click',clicvalid);
			$('.bloc_reponse').off('click',clicrep);
			$('#timer').html(0);
			setTimeout(function () {
				if(fondSon!=0 && question['dom1']!="SexyQuizz")
					{$('#son_fondjeu')[0].pause();
					$('#son_fondjeu')[0].currentTime=0;
					}
				phase3(question['id'], 'none', 0);
				$('#son_fintps')[0].volume=0.4*0.33*volume_son;
				$('#son_fintps')[0].play();
				$('#bloc_question_bas_txt').text('Temps écoulé').css('color','rgb(243,248,78)');
			}, 500);
		},gameTime);
		intervalID=setInterval(function(){
			var oldtimeLeft=timeLeft;
			timeLeft--;
			if ((Math.floor(timeLeft/10+1))!=(Math.floor(oldtimeLeft/10+1)))
				{$('#timer').html(Math.floor(timeLeft/10+1));}
		}, 100);
	} 
	function phase3(idQ,rep,temps) {//envoi de la réponse à la bdd et retour de la bonne rep
		$.ajax({
                url: 'http://localhost/MondeDuQuizz/web/app_dev.php/quizz/verifReponse',
                type: 'POST',
                data:{idQ : idQ, rep : rep, temps : temps, numQ : numQ  },
                dataType: 'json',
                success: function(question) {
                    //alert('success');
					$('#bloc_question_intitule').css('display','none');
					if(clearImage==1)//évite le rechargement des photos
						{
							$('#bloc_question_photo img').attr({src: '', alt: '', height: ''});
							$('#bloc_question_photo').css('display','none');
						}
					$('#bloc_question_bas_txt').css('color','rgb(243,248,78)')
					if(rep==question['brep']) {
						$('#son_succes')[0].volume=1*0.33*volume_son;
						if(game=="MuQuizz"){$('#son_succes')[0].volume=0.2*0.33*volume_son;}
						$('#son_succes')[0].play();
						$('#bloc_question_bas_txt').text('Bonne réponse !');
						$('.reponse_select').attr('class','bloc_reponse reponse_juste');
					}
					else if (rep!='none') {
						$('#son_echec')[0].volume=1*0.33*volume_son;					
						if(game=="MuQuizz"){$('#son_echec')[0].volume=0.2*0.33*volume_son;}
						$('#son_echec')[0].play();
						$('#bloc_question_bas_txt').text('Mauvaise réponse !');
						$('.reponse_select').attr('class','bloc_reponse reponse_fausse');
					}
					else {
						
					}
					if(question['dom1']=="TvQuizz" || question['dom1']=="EyesQuizz")
						{var delai=0;}
					else{var delai=2000;}
					setTimeout(function () { 
						phase4(question,rep);
					}, delai);         
				}                
         });
		 return;
	}
	function phase4(question,rep) {//affichage de la bonne rep et des conséquences.
		
		$('#jeu_img_boule_noire').fadeTo(250,1);$('#timer').html(comTime/1000);
		if(rep!=question['brep']){
			$('.bloc_reponse:contains('+question['brep']+')').attr('class','bloc_reponse reponse_correction');
		}
		if(affichCom==0){}
		else if (affichCom==1 && BigImg==1){
			{
			 var com=(question['commentaire']).replace('**','</br>');
			// Test longeur chaine pour adapté police, affichage en fonction
			  var result=question['commentaire'].indexOf('*')//test si étoile
			    if(result>-1)
			    {
			    var text1=question['commentaire'].substring(0, question['commentaire'].indexOf('*'));
			    var text2=question['commentaire'].substring(0, question['commentaire'].lastIndexOf('*')+1);
			      if(text1.length>text2.length){var maxlength=text1.length;}
			      else{var maxlength=text2.length;}
			      //test en fonction de max length et de largeur : on affiche ou non txt3
			     var largeurA=$('#bloc_question_photo2').width();
				if (largeurA/10<maxlength)
				{
				  $('#bloc_question_bas_txt3').html(com).css('display','block');
				  $('#bloc_question_bas3').css('display','block');
				 // alert('affich text3 ; largeurA='+largeurA+' ; maxlength='+maxlength);
				}
				else{
				$('#bloc_question_bas_txt2').html(com).css('display','block');
				}
			    }
			    else{
			    $('#bloc_question_bas_txt2').html(com).css('display','block');
			    }
			}
		}
		else if(question['imageCom']==null)
			{var com=(question['commentaire']).replace('**','</br>');
			$('#bloc_question_commentaire').html(com).css('display','inline-block');}
		else
		{
			if(question['dom1']=="EyesQuizz"){var dossier="Eyes/";}
			else{var dossier="";}
			if(clearImage==1)//évite le rechargement des photos
			{
				$('#bloc_question_photo img').attr({src: '../../../../../../../../MondeDuQuizz/web/bundles/mdqquestion/images/imgQuestions/'+dossier+question['imageCom']+'.jpg', alt: question['imageCom'], height: '195'});
				$('#bloc_question_photo img').load(function(){
					$('#bloc_question_photo').css('display','inline-block');
				});
			}		
			var com=(question['commentaire']).replace('**','</br>');
			$('#bloc_question_bas_txt').html(com).css('display','inline-block');
		}
		$('#jeu_bloc_score_score').text(question['score']);
		$('#jeu_bloc_valid img').attr({src:'../../../bundles/mdqgene/images/buttonvalidMq4.png'});
		function clic_valid_com(){
				$('#jeu_bloc_valid').off('click',clic_valid_com);
				clearInterval(interval_com);
				clearTimeout(timer_com);
				phase5(question['id'],question['finP']);
			}
		$('#jeu_bloc_valid').on('click',clic_valid_com);
		var timer_com=setTimeout(function(){
				$('#jeu_bloc_valid').off('click',clic_valid_com);
				clearTimeout(timer_com);
				clearInterval(interval_com);
				phase5(question['id'],question['finP']);				
			},comTime);
			timeLeft=comTime/100;
			var interval_com=setInterval(function(){
				var oldtimeLeft=timeLeft; timeLeft--;
				if ((Math.floor(timeLeft/10+1))!=(Math.floor(oldtimeLeft/10+1)))
					{$('#timer').html(Math.floor(timeLeft/10+1));}
			}, 100);
		/*	
		setTimeout(function () { 
							phase5();
						}, 10000);
		*/
	}
	function phase5(idQ, finP){// Teste si erreur signalée
		if(fondSon!=0){
		  $('#son_fondjeu')[0].pause();
		  $('#son_fondjeu')[0].currentTime=0;
		}
		$('#jeu_bloc_error').off('click',clickerror);
		if(error==0){
			if(finP==1){finpartie();}
			else{init();}
		}
		else{// si une erreur est signalée.
			function clic_annule_error(){			
				$('#button_annule_error').off('click',clic_annule_error);
				$('#button_valid_error').off('click',clic_valid_error);
				clearInterval(interval_error);
				clearTimeout(timer_error);
				if (finP==1){finpartie();}
				else{init();}
			}
			
			function clic_valid_error(){
				$('#button_annule_error').off('click',clic_annule_error);
				$('#button_valid_error').off('click',clic_valid_error);
				clearInterval(interval_error);
				clearTimeout(timer_error);
				var taberror=[0,0,0];
				if($('input[name="erreur"]').prop('checked')==true){taberror[0]=1;}
				if($('input[name="ortho"]').prop('checked')==true){taberror[1]=1;}
				if($('input[name="autre"]').prop('checked')==true){taberror[2]=1;}
				if (taberror[0]==1 || taberror[1]==1 || taberror[2]==1)
				{				
					alert(taberror);
					$.ajax({
					url: 'http://localhost/MondeDuQuizz/web/app_dev.php/quizz/signalError',
					type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
					data:{ idQ : idQ, taberror : taberror },
					dataType: 'json',				       
				});
				}
				if (finP==1){finpartie();}
				else{init();}
			}
			$('#jeu_bloc_bloc_precise_error').css('display','block');
			$('#jeu_img_boule_noire').fadeTo(250,1);$('#timer').html("15");
			$('#button_annule_error').on('click',clic_annule_error);
			$('#button_valid_error').on('click',clic_valid_error);
			var timer_error=setTimeout(function(){
				$('#button_annule_error').off('click',clic_annule_error);
				$('#button_valid_error').off('click',clic_valid_error);
				clearTimeout(timer_error);
				clearInterval(interval_error);
				if (finP==1){finpartie();}
				else{init();}
			},15000);
			timeLeft=150;
			var interval_error=setInterval(function(){
				var oldtimeLeft=timeLeft; timeLeft--;
				if ((Math.floor(timeLeft/10+1))!=(Math.floor(oldtimeLeft/10+1)))
					{$('#timer').html(Math.floor(timeLeft/10+1));}
			}, 100);
		}
	}
	function finpartie(){
		//alert('Dans la fonction finpartie');
		window.location.replace("http://localhost/MondeDuQuizz/web/app_dev.php/quizz/finPartie");
		//$('head').append( '<meta name="meta" http-equiv="refresh" content="0;url=finPartie" />' );
	}
});
});
