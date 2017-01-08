$(function () {	 
    jQuery(document).ready(function() {
		$('.bloc_news_button').click(function(){
		var tabresult=[0,0,0];
		//$(this).prevAll('.publication').css('color','red');
		tabresult[0]=$(this).parents('.form_news').find('.id_news').text();
                tabresult[1]=$(this).parents('.form_news').find('select[name=publication] option:selected').val();
		if($(this).prevAll('.priorite').children(':input').prop('checked')==true)
			{tabresult[2]=1;}
		 //alert(tabresult)
		{				
				$.ajax({
				url: 'http://localhost/MondeDuQuizz/web/app_dev.php/admin/formListNews',
				type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
				data:{ tabresult : tabresult },
				dataType: 'json',
				success: function(tabretour){
						alert("Mise à jour effectuée"+"   "+tabretour);
						
						}
			});
		}
	});
    });
});
