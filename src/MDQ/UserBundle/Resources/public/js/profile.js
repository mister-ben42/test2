$(function () {	 
    jQuery(document).ready(function() {
	//il doit être possible de simplifier tout ça/
	var prct_H=$('#sc_prct_H').text();
	var larg_H=prct_H*150/100-2;
	$('#bande_score_H').css('width',larg_H);
	var prct_G=$('#sc_prct_G').text();
	var larg_G=prct_G*150/100-2;
	$('#bande_score_G').css('width',larg_G);
	var prct_SN=$('#sc_prct_SN').text();
	var larg_SN=prct_SN*150/100-2;
	$('#bande_score_SN').css('width',larg_SN);
	var prct_AL=$('#sc_prct_AL').text();
	var larg_AL=prct_AL*150/100-2;
	$('#bande_score_AL').css('width',larg_AL);
	var prct_SL=$('#sc_prct_SL').text();
	var larg_SL=prct_SL*150/100-2;
	$('#bande_score_SL').css('width',larg_SL);
	var prct_D=$('#sc_prct_D').text();
	var larg_D=prct_D*150/100-2;
	$('#bande_score_D').css('width',larg_D);
    });
});
