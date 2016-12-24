$(function () {	 
    jQuery(document).ready(function() {
		$('#form_ajoutQ textarea').each(function(){
			$(this).keyup(function(){
			$(this).next().text(($(this).val().length));
		}).trigger('keyup');
            });
		
		if($('#ajoutQ_doublon_cache').text()==1)
		{
			$('#flash_message').css('display','block');
			$('#flash_message_croix').on('click',(function(){
				$('#flash_message').css('display','none');
			}));
		}
    });	
});
