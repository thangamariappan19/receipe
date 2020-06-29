(function(window){
  'use strict';

  // This function will contain all our code
   	function wpr(){
   	var _thisWPR = {};

    // testing helo function
   	_thisWPR.hello = function() {
   		alert('hi');
   	}
    

    // wpr sign up form alert and url redirection
	_thisWPR.alert = function(message, type, callbackfunc) {
		
		type = undefined ? 'success' : type 
       // swal(message, "", type);
        swal({title:message ,text: '' , type: type}, callbackfunc);
	}



    // We will add functions to our library here !
    return _thisWPR;
    }


  // We need that our library is globally accesible, then we save in the window
    if(typeof(window.WPR) === 'undefined'){
        window.WPR = wpr();
    }
})(window); // We send the window variable withing our function