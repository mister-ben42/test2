$(function () {	 
jQuery(document).ready(function() {
	var numQ=0;
	var volume_son=0.1;
	var repselect; var error;
	var timerID; var timeLeft;
	// ********** Critères principaux : ceux du Masterquizz **********************
		var afficheTheme=1; var dossier=""; var hauteur='195'; var clearImage=1; var gameTime=15000; var comTime=12000; var affichCom=1; var interQTime=500; var BigImg=0; var fondSon=1; var game="MasterQuizz";var delai=2000;
	toutaulong()
	init();	
	// ---- Fonction valable sur toute la partie du jeu // -------
	function volume(){
			if(volume_son==3){volume_son=0;
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
		$('#rep1').text(''); $('#rep2').text(''); $('#rep3').text(''); $('#rep4').text('');
		$('.bloc_reponse').attr('class','bloc_reponse');		
		$('#jeu_bloc_valid img').attr({src:'../../../bundles/mdqgene/images/buttonvalidMq.png'});
		$('#jeu_bloc_error img').attr({src:'../../../bundles/mdqgene/images/maboulejaune.png', width:'15px'});
		$('#jeu_bloc_bloc_precise_error').css('display','none');
		$('input[class="checkbox_error"]').prop('checked', false);
		setTimeout(function () { 
			phase0(numQ); 
		}, interQTime);
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
		$('#bloc_question_diff img').load(function(){
			$('#bloc_question_theme_diff').css('display','inline-block');
		});
		$('#bloc_question_bas_txt').text('');
		setTimeout(function () { 
			phase2(question); 
		}, 3000);
		return;
	}
	function phase2(question){
	//************ Affichage Question ****************************/
		
		$('#bloc_question_bas_txt').text('').css('color','rgb(234,254,255)');	
		$('#bloc_question_theme_diff').css('display','none');
		$('#bloc_question_numQ').text(numQ).css('display','inline-block');

			$('#bloc_question_intitule').text(question['intitule']).css('display','inline-block');
			$('#bloc_question_bas_txt').text('');
			phase2bis(question);
		
	}
	function phase2bis(question)// Pour différer l'afficher des proposition, ntamment pour les questions photos.
	{
		for (var i=1;i<5;i++){			
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
				if(fondSon!=0)
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

		 var com=(question['commentaire']);
		$('#bloc_question_commentaire').html(com).css('display','inline-block');


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
