(function( $ ) {
	'use strict';

	$(function() {

		$('#studiumPay_display').text($('#studiumPay_cost').val());
		$('#studiumPay_cost')
			.attr('type', 'range')
			.attr('max', 10000)
			.on("change mousemove", function() {
				var cost = this.value;
				$('#studiumPay_display').text(cost);
			});

// //todo zrefraktoryzwoać do osobnej funkcji przyjmującej 2 argumenty
// 			$('.studiumPay__checkbox--JS').on('change', function(){
// 				var costSum = 0;
// 				$('.studiumPay__checkbox--JS:checked').each(function(index, item){
// 					costSum += parseInt(item.value);
// 				});
//
// 				$('#studiumPay_display').text(costSum);
// 				$('#studiumPay_cost').val(costSum);
// 				if ($('.studiumPay__checkbox--JS:checked').length === $('.studiumPay__checkbox--JS').length) {
// 					$('#studiumPay_prepay').show();
// 				}else{
// 					$('#studiumPay_prepay').hide();
// 				}
// 			});
//--------------
	});

})( jQuery );
