$(function () {	 
    jQuery(document).ready(function() {
       // console.log("jQuery est prêt !");
		//alert('dans jquerry');
        // $('.formQ').css('color','green');      
       $(".dom1class").change(function() {
            mafonctionchange('theme','dom1');
        }).trigger('change'); 
        $('.formQ :input').each(function(){
			$(this).keyup(function(){
			$(this).next().text(($(this).val().length)+' lettres');
		}).trigger('keyup');
            });
		$('#bloc_list_question .bloc1 :input').each(function(){
			$(this).keyup(function(){
			//$(this).parent().next().css('color','white');
			$(this).parent().next('.nblettre').text(($(this).val().length));
		}).trigger('keyup');
            });
		$('.admin_editQ_error_button').click(function(){
			var idQ=$(this).parents('.admin_listQ_bloc').find('.admin_listQ_idQ').text();
			$.ajax({
                url: 'http://localhost/MondeDuQuizz/web/app_dev.php/admin/resetError',
                type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
                data:
                {
                  idQ : idQ
                },
                dataType: 'json',
				success:function(reponse) {
                    alert('Reset effectué');
                    }			
			});
		});
		$('.admin_listQ_valid').click(function(){
			alert('Clic pris en compte');
			var idQ=$(this).parents('.admin_listQ_bloc').find('.admin_listQ_idQ').text();
			if($(this).text()=="Valide"){var valid=1;}
			else if($(this).text()=="Refus"){var valid=0;}
			else if($(this).text()=="Passe"){var valid=2};
			if(valid==1 || valid==2 || valid==0)
			{
				alert("idQ :"+idQ+" - Valid : "+valid);
				$.ajax({
					url: 'http://localhost/MondeDuQuizz/web/app_dev.php/admin/modifQajax',
					type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
					data:
					{
					  idQ : idQ, valid : valid
					},
					dataType: 'json',
					success:function(reponse) {
						alert('MAJ effectuée');
						}			
				});
			}
		});
		$('.admin_listQ_modifier').click(function(){
			var idQ=$(this).parents('.admin_listQ_bloc').find('.admin_listQ_idQ').text();
			var intitule=$(this).parents('.admin_listQ_bloc').find('.bloc_intitule textarea').val();
			var brep=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=brep]').val();
			var mrep1=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=mrep1]').val();
			var mrep2=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=mrep2]').val();
			var mrep3=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=mrep3]').val();
			var dom1=$(this).parents('.admin_listQ_bloc').find('select[name=dom1] option:selected').val();
			var dom2=$(this).parents('.admin_listQ_bloc').find('input[name=dom2]').val();
			if(dom2=="")
				{
				dom2=$(this).parents('.admin_listQ_bloc').find('select[name=dom2] option:selected').val();
				}
			var dom3=$(this).parents('.admin_listQ_bloc').find('input[name=dom3]').val();
			if(dom3=="")
				{
				dom3=$(this).parents('.admin_listQ_bloc').find('select[name=dom3] option:selected').val();
				}	
			var theme=$(this).parents('.admin_listQ_bloc').find('input[name=theme]').val();
				if(theme=="")
				{
				theme=$(this).parents('.admin_listQ_bloc').find('select[name=theme] option:selected').val();
				}
			var diff=$(this).parents('.admin_listQ_bloc').find('select[name=diff] option:selected').val();
			var type=$(this).parents('.admin_listQ_bloc').find('select[name=type] option:selected').val();
			var delai=$(this).parents('.admin_listQ_bloc').find('input[name=delai_année]').val();
			var com=$(this).parents('.admin_listQ_bloc').find('.bloc_commentaire textarea').val();
			//if(delai==""){delai=null;}
			alert("- idQ :"+idQ+"\n - Intitule : "+intitule+"\n - brep : "+brep+"\n - mrep1 : "
			+mrep1+"\n - mrep2 : "+mrep2+"\n - mrep3 : "+mrep3+"\n - commentaire : "+com +"\n - dom1 : "+dom1
			+"\n - theme : "+theme+"\n - dom2 : "+dom2+"\n - dom3 : "+dom3+"\n - diff : "+diff
			+"\n - type : "+type+"\n - délai : "+delai);
			$.ajax({
                url: 'http://localhost/MondeDuQuizz/web/app_dev.php/admin/modifQajax',
                type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
                data:
                {
                  idQ : idQ, intitule : intitule, brep : brep, mrep1 : mrep1, mrep2 : mrep2,
				  mrep3 : mrep3, com : com, dom1 : dom1, dom2 : dom2, dom3 : dom3, theme : theme,
				  diff : diff, type : type, delai : delai
                },
                dataType: 'json',
				success:function(reponse) {
                    alert('MAJ effectuée');
                    }			
			});		
		
		});
		$('.admin_listQ_envoyer').click(function(){
			var idQ=$(this).parents('.admin_listQ_bloc').find('.admin_listQ_idQ').text();
			var repAdmin=$(this).parents('.admin_listQ_bloc').find('select[name=repAdmin] option:selected').val();
			
			if(repAdmin!=100 && repAdmin!=200 )
			{
				alert("- idQ : "+idQ+"\n- repAdmin "+repAdmin);
				$.ajax({
					url: 'http://localhost/MondeDuQuizz/web/app_dev.php/admin/retourQaValajax',
					type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
					data:
					{
					  idQ : idQ, repAdmin : repAdmin
					},
					dataType: 'json',
					success:function(reponse) {
						if(reponse=='ok'){alert('Retour pris en compte');}
						else{alert('Il y a eu une erreur quelque part');}
						}			
				});
			}
			else if(repAdmin==100 || repAdmin==200)
			{
				var intitule=$(this).parents('.admin_listQ_bloc').find('.bloc_intitule textarea').val();
				var brep=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=brep]').val();
				var mrep1=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=mrep1]').val();
				var mrep2=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=mrep2]').val();
				var mrep3=$(this).parents('.admin_listQ_bloc').find('.blocrep input[name=mrep3]').val();
				var dom1=$(this).parents('.admin_listQ_bloc').find('select[name=dom1] option:selected').val();
				var dom2=$(this).parents('.admin_listQ_bloc').find('input[name=dom2]').val();
				if(dom2=="")
					{
					dom2=$(this).parents('.admin_listQ_bloc').find('select[name=dom2] option:selected').val();
					}
				var dom3=$(this).parents('.admin_listQ_bloc').find('input[name=dom3]').val();
				if(dom3=="")
					{
					dom3=$(this).parents('.admin_listQ_bloc').find('select[name=dom3] option:selected').val();
					}	
				var theme=$(this).parents('.admin_listQ_bloc').find('input[name=theme]').val();
				if(theme=="")
					{
					theme=$(this).parents('.admin_listQ_bloc').find('select[name=theme] option:selected').val();
					}
				var diff=$(this).parents('.admin_listQ_bloc').find('select[name=diff] option:selected').val();
				var type=$(this).parents('.admin_listQ_bloc').find('select[name=type] option:selected').val();
				var doublon=$(this).parents('.admin_listQ_bloc').find('select[name=doublon] option:selected').val();
				var delai=$(this).parents('.admin_listQ_bloc').find('input[name=delai_année]').val();
				var com=$(this).parents('.admin_listQ_bloc').find('.bloc_commentaire textarea').val();
				alert("- idQ :"+idQ+"\n - Intitule : "+intitule+"\n - brep : "+brep+"\n - mrep1 : "
				+mrep1+"\n - mrep2 : "+mrep2+"\n - mrep3 : "+mrep3+"\n - commentaire : "+com +"\n - dom1 : "+dom1
				+"\n - theme : "+theme+"\n - dom2 : "+dom2+"\n - dom3 : "+dom3+"\n - diff : "+diff
				+"\n - type : "+type+"\n - délai : "+delai+"\n - doublon : "+doublon+"\n - repAdmin : "+repAdmin);
				$.ajax({
                url: 'http://localhost/MondeDuQuizz/web/app_dev.php/admin/insertQaValajax',
                type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
                data:
                {
                  idQ : idQ, intitule : intitule, brep : brep, mrep1 : mrep1, mrep2 : mrep2,
				  mrep3 : mrep3, com : com, dom1 : dom1, dom2 : dom2, dom3 : dom3, theme : theme,
				  diff : diff, type : type, delai : delai, doublon : doublon, repAdmin : repAdmin
                },
                dataType: 'json',
				success:function(reponse) {
						if(reponse=='ok'){alert('Insertion dans la bdd');}
						else if(reponse=='erreur'){alert('Il y a eu une erreur quelque part au niveau du php');}
						else {alert('Il y a une ou plusieus questions qui ont le même énoncé :');
							var nbdoublon=reponse.length;
							for(var i=0; i<nbdoublon; i++)
							{
							alert('id :'+reponse[i].id+' - intitule : '+reponse[i].intitule+ 
							' - Brep : '+reponse[i].brep+ ' - Mrep1 : '+reponse[i].mrep1 +
							' - Mrep2 : '+reponse[i].mrep2 +' - Mrep3 : '+reponse[i].mrep3 +
							' - dom1 : '+reponse[i].dom1 + ' - theme : '+reponse[i].theme +
							' - comm : '+reponse[i].commentaire);
							}
						}
						}			
			});		
			
			}
		});
        function mafonctionchange(selecteur,selecteurparent)
        {         
           // alert("dans mafonctionchange");
			var theme=$('#formQ_theme_initial').text();
			$.ajax({
                url: 'http://localhost/MondeDuQuizz/web/app_dev.php/question/adaptForm',
                type: 'POST',// ne pas oublier les en t^te dans le fichier de ttt de la dde.
                data:
                {
                  id : $("select."+selecteurparent+"class option:selected").val(),
                    select : selecteur,
                },
                dataType: 'json',
                success: function(reponse) {
                    $('.'+selecteur+'class').empty();
					$.each(reponse, function(index, element) {
                        $('.' + selecteur + 'class').append('<option value="'+ element[1] +'"> '+ element[1] +' </option>');
                    });
					if(theme){$('[value="'+theme+'"]').prop('selected',true);}
					}
          });
        }
    });
});
