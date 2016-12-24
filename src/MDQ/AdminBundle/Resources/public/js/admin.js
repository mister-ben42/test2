$(function () {	 
    jQuery(document).ready(function() {
		$('.bloc_news_button').click(function(){
		var tabresult=[0,0,0];
		//$(this).prevAll('.publication').css('color','red');
		tabresult[0]=$(this).prevAll('.id_news').text();
		if($(this).prevAll('.publication').children(':input').prop('checked')==true)
			{tabresult[1]=1;}
		if($(this).prevAll('.priorite').children(':input').prop('checked')==true)
			{tabresult[2]=1;}
		 //alert(tabresult)
		{				
				$.ajax({
				url: 'http://localhost/MondeDuquizz/web/app_dev.php/admin/formListNews',
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
