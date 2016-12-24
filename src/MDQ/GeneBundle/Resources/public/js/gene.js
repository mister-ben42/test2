$(function () {	 
    jQuery(document).ready(function() {
	// gestion de l'affichage de la partie centrale
	var delay=7000; var tpsanim=2000;
	var inter = setInterval(function(){nextElt()}, delay);
	$('#bloc_centre_anim1').addClass("active");
	 function nextElt()
	 {
		$('#accueil_bloc_centre_anim').find(".active").fadeOut(tpsanim);				 
		// Si l'image active courante n'est pas la dernière image de la liste
		if(!$('#accueil_bloc_centre_anim').find(".active").is(":last-child"))
			{
				// Alors on cherche l'image suivante (".next()"), on lui ajoute la class "active",
				// et on retire cette classe à l'image précedente (l'ancienne image active)
				$('#accueil_bloc_centre_anim').find(".active").next().addClass("active").prev().removeClass("active");
				// On affiche la nouvelle image active progressivement				
				$('#accueil_bloc_centre_anim').find(".active").fadeIn(tpsanim);
			}
				// L'image est la dernière de la liste
		else
			{
			// On fait la même chose mais en prenant la première image de la liste via le sélecteur "first-child"
			$('#accueil_bloc_centre_anim').find(":first-child").addClass("active").fadeIn(tpsanim);
			$('#accueil_bloc_centre_anim').find(":last-child").removeClass("active");
			}
	 }
	$('#bouton_jouer img').on('mouseover',(function(){		
		$('#bouton_jouer img').attr({src:'../bundles/mdqgene/images/buttonjouervalide.png'});
		$('#bouton_jouer img').on('mouseout',(function(){		
		$('#bouton_jouer img').attr({src:'../bundles/mdqgene/images/buttonjouer.png'});		
	}));
	}));
	if( typeof(mCustomScrollbar) == 'function' ){$('#bloc_news').mCustomScrollbar({     
	});}
	$('#bloc_connextion_bouton').on('click',(function(){
		$('#bandeau_form_connexion').css('display','block');
		$('#bloc_connexion_croix').on('click',(function(){
			$('#bandeau_form_connexion').css('display','none');
		}));
	}));
	$('.affich_flash1').on('click',(function(){
		$('#mess_flash_1').css('display','inline');
		$('#mess_flash_2').css('display','none');
		$('#mess_flash_3').css('display','none');
		$('#bloc_flash_message').css('display','block');
		$('#flash_message_croix').on('click',(function(){
			$('#bloc_flash_message').css('display','none');
		}));
	}));
	$('.affich_flash2').on('click',(function(){
		$('#mess_flash_2').css('display','inline');
		$('#mess_flash_1').css('display','none');
		$('#mess_flash_3').css('display','none');
		$('#bloc_flash_message').css('display','block');
		$('#flash_message_croix').on('click',(function(){
			$('#bloc_flash_message').css('display','none');
		}));
	}));
	$('.affich_flash3').on('click',(function(){
		$('#mess_flash_3').css('display','inline');
		$('#mess_flash_2').css('display','none');
		$('#mess_flash_1').css('display','none');
		$('#bloc_flash_message').css('display','block');
		$('#flash_message_croix').on('click',(function(){
			$('#bloc_flash_message').css('display','none');
		}));
	}));
	$('#bloc_HighScore .sigle_aide').on('mouseover',(function(){
		$('.highScore_aide').css('display','inline-block');
		$('#bloc_HighScore .sigle_aide').on('mouseout',(function(){
			$('.highScore_aide').css('display','none');
		}));
	}));
	$('#accueil_jeu_boutonGo img').on('mouseover',(function(){
		$('#accueil_jeu_boutonGo img').attr({src:'../bundles/mdqgene/images/LogoMqGo2.png'});
		$('#accueil_jeu_boutonGo img').on('mouseout',(function(){		
		$('#accueil_jeu_boutonGo img').attr({src:'../bundles/mdqgene/images/LogoMqGo.png'});
		}));
	}));
});
});