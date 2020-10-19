jQuery(document).ready(function(){
	
	activeFormatCurrency();
	activeFormatCurrencyLabel();

	$(".format_currency").change(function () {
	    if (!$.isNumeric($(this).val())) $(this).val('0').trigger('change');
	    $(this).val(parseFloat($(this).val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
	});

	
	
})
//format currency input
function activeFormatCurrency(){
	var count_format_currency_input = $(".format_currency").length;
	if(count_format_currency_input > 0){
		for(var i = 0; i < count_format_currency_input; i++){		
			if (!$.isNumeric($(".format_currency_input"+i).val())) $(".format_currency_input"+i).val('0').trigger('ready');
    		$(".format_currency_input"+i).val(parseFloat($(".format_currency_input"+i).val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());	
		}
		
	}
}

//format currency label
function activeFormatCurrencyLabel(){
	var count_format_currency_label = $(".format_currency_list").length;
	if (count_format_currency_label > 0){
		for(var i = 0; i < count_format_currency_label; i++){		
			if (!$.isNumeric($(".format_currency_label"+i).html())) $(".format_currency_label"+i).html('0').trigger('ready');
		    $(".format_currency_label"+i).html("Rp. "+parseFloat($(".format_currency_label"+i).html(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());		
		}
	}
}

function formatCurrencyById(id){
	var element = document.getElementById(id);
    if (!$.isNumeric($(element).val())) $(element).val('0');
    $(element).val(parseFloat($(element).val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
}

function formatCurrencyByIdLabel(id){
	var element = document.getElementById(id);
    if (!$.isNumeric($(element).text())) $(element).text('0');
    $(element).text("Rp. "+parseFloat($(element).text(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
}