jQuery(document).ready(function($){
	$('#authorize_pro_ccnum').on('blur change', function(){
		var $this = $(this);
		var $parent = $this.closest('.form-row');
		var validated = true;
		if($parent.is('.validate-required')){
			validated = wa.ecom.validateCardNumber($this.val());
		}
		if(validated){
			$parent.removeClass('jigoshop-invalid').addClass('jigoshop-validated');
		}
		else {
			$parent.removeClass('jigoshop-validated').addClass('jigoshop-invalid');
		}
	});
	$('#authorize_pro_cvc').on('blur change', function(){
		var $this = $(this);
		var $parent = $this.closest('.form-row');
		var validated = true;
		if($parent.is('.validate-required')){
			validated = wa.ecom.validateCVC($this.val());
		}
		if(validated){
			$parent.removeClass('jigoshop-invalid').addClass('jigoshop-validated');
		}
		else {
			$parent.removeClass('jigoshop-validated').addClass('jigoshop-invalid');
		}
	});
});

(function(wa){
	"use strict";
	var ecom = wa.ecom = {},
		NUMPATTERN = /^\d+$/,
		cardTypes = {
			visa: { css: 'visa', name: 'Visa' },
			master: { css: 'masterCard', name: 'MasterCard' },
			ax: { css: 'americanExpress', name: 'American Express' },
			discover: { css: 'discover', name: 'Discover' },
			jcb: { css: 'jcb', name: 'JCB' },
			diners: { css: 'dinersClub', name: 'Diners Club' },
			unknown: { css: 'unknown', name: 'unknown' }
		};
	ecom.trim = function(value){
		return ( value + "" ).replace(/^\s+|\s+$/g, "");
	};
	ecom.luhnCheck = function(cardNumber){
		var sum = 0,
			numdigits = cardNumber.length,
			parity = numdigits % 2,
			i = 0;
		for(; i < numdigits; i++){
			var digit = parseInt(cardNumber.charAt(i), 10);
			if(i % 2 === parity){
				digit *= 2;
			}
			if(digit > 9){
				digit -= 9;
			}
			sum += digit;
		}
		return (sum % 10) === 0;
	};
	ecom.cardTypes = function(){
		var e, t, n, r;
		t = {};
		for(e = n = 40; n <= 49; e = ++n){
			t[ e ] = cardTypes.visa;
		}
		for(e = r = 50; r <= 59; e = ++r){
			t[ e ] = cardTypes.master;
		}
		t[ 34 ] = t[ 37 ] = cardTypes.ax;
		t[ 60 ] = t[ 62 ] = t[ 64 ] = t[ 65 ] = cardTypes.discover;
		t[ 35 ] = cardTypes.jcb;
		t[ 30 ] = t[ 36 ] = t[ 38 ] = t[ 39 ] = cardTypes.diners;
		return t;
	}();
	//public API
	wa.ecom.validateCardNumber = function(cardNumber){
		cardNumber = ( cardNumber + "" ).replace(/\s+|-/g, "");
		return cardNumber.length >= 10 && cardNumber.length <= 16 && ecom.luhnCheck(cardNumber);
	};
	wa.ecom.validateExpiry = function(month, year){
		var r,
			i,
			numMonth = parseInt(month, 10);
		month = ecom.trim(month);
		year = ecom.trim(year);
		if(!NUMPATTERN.test(month) || !NUMPATTERN.test(year) || numMonth < 1 || numMonth > 12){
			return false;
		}
		i = new Date(year, month);
		r = new Date();
		i.setMonth(i.getMonth() - 1);
		i.setMonth(i.getMonth() + 1, 1);
		return i > r;
	};
	wa.ecom.validateCVC = function(cvc){
		cvc = ecom.trim(cvc);
		return  ( NUMPATTERN.test(cvc) && cvc.length >= 3 && cvc.length <= 4 );
	};
	wa.ecom.cardType = function(cardNumber){
		return ecom.cardTypes[ cardNumber.slice(0, 2) ] || cardTypes.unknown;
	};
})(window.wa || ( window.wa = {} ));