var Payment = function(){
	/*Formulario de pagos con tarjeta de credito*/
	$formCreditcard = $("#creditcard-form");
	$alertCreditcard = $("#alert-creditcard");
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
				console.log(a);
				console.log(res);
				$alertCreditcard.html("error ... "+res.responseJSON.message	);
			}
		});
	};
	return {
		creditcard:function(){
			makePayment.creditcard();
		}
	};
}();