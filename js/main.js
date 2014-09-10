var Payment = function(){
	/*Formulario de pagos con tarjeta de credito*/
	$formCreditcard = $("#creditcard-form");
	$formCash = $("#cash-form");
	$alertCreditcard = $("#alert-creditcard");
	$alertCash = $("#alert-cash");
	var makePayment = {};
	makePayment.creditcard=function(){
		$alertCreditcard.html("procesando...");
		$.ajax({
			url: 'index.php/creditcard-payment',
			type: 'POST',
			data: $formCreditcard.serialize(),
			dataType: 'json',
			success: function(res) {
				if(res.status == "ok"){
					$alertCreditcard.html("procesando correctamente");
				}else{
					$alertCreditcard.html("error ... "+res.message);
				}
			},
			error:function(res,a){
				$alertCreditcard.html("error ... "+res.responseJSON.message	);
			}
		});
	};
	makePayment.cash=function(){
		$alertCash.html("procesando...");
		$.ajax({
			url: 'index.php/cash-payment',
			type: 'POST',
			data: $formCash.serialize(),
			dataType: 'json',
			success: function(res) {
				if(res.status == "ok"){
					$alertCash.html("procesando correctamente");
				}else{
					$alertCash.html("error ... "+res.message);
				}
			},
			error:function(res,a){
				$alertCash.html("error ... "+res.responseJSON.message	);
			}
		});
	};
	return {
		creditcard:function(){
			makePayment.creditcard();
		},
		cash:function(){
			makePayment.cash();
		}
	};
}();