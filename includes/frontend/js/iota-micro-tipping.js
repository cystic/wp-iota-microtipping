
//
// CUSTOMIZABLE FUNCTIONS TO ADAPT TO PAGE DESIGN IF DESIRED
//

var $ = jQuery;

function initDom(iotaConnection, parent) {
    // Define initial DOM content without values. Values gonna be updated later by 'updateQR()' and 'updateTips()'
    if (iotaConnection) {
        var template = ' \
            <span style="cursor:pointer;"> \
                <img src="data:image/png;base64,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" height="15px" /> \
                <img src="data:image/gif;base64,R0lGODlhFAAUAPEDAMzMzLOzs39/f////yH5BAUKAAMAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAFAAUAAACPJyPqcuNItyCUJoQBo0ANIxpXOctYHaQpYkiHfM2cUrCNT0nqr4uudsz/IC5na/2Mh4Hu+HR6YBaplRDAQAh+QQFCgADACwEAAIADAAGAAACFpwdcYupC8BwSogR46xWZHl0l8ZYQwEAIfkEBQoAAwAsCAACAAoACgAAAhccMKl2uHxGCCvO+eTNmishcCCYjWEZFgAh+QQFCgADACwMAAQABgAMAAACFxwweaebhl4K4VE6r61DiOd5SfiN5VAAACH5BAUKAAMALAgACAAKAAoAAAIYnD8AeKqcHIwwhGntEWLkO3CcB4biNEIFACH5BAUKAAMALAQADAAMAAYAAAIWnDSpAHa4GHgohCHbGdbipnBdSHphAQAh+QQFCgADACwCAAgACgAKAAACF5w0qXa4fF6KUoVQ75UaA7Bs3yeNYAkWACH5BAUKAAMALAIABAAGAAwAAAIXnCU2iMfaRghqTmMp1moAoHyfIYIkWAAAOw==" height="15px" /> \
            </span> \
        ';    
    }
    else {
        var template = ' \
            <span style="cursor:pointer;"> \
                <img src="data:image/png;base64,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" height="15px" /> \
            </span> \
        ';    
    }
    
    // Apply initial DOM content
    $( parent ).html(template);  
}

function updateQr(parent, qrObject, tipAddress, tipMessage, tipAmount) {   

    // Prepare parent element for relative positioning of QR code    
    $( parent ).css("position", "relative");
    
    // Style and position QR code
    qrObject.css("visibility", "hidden");
    qrObject.css("opacity", "0");
    qrObject.css("-webkit-transition", "opacity 600ms, visibility 600ms");
    qrObject.css("transition", "opacity 600ms, visibility 600ms");
    qrObject.css("position", "absolute");
    qrObject.css("top", "-220px");
    qrObject.css("left", "-85px");    
    qrObject.css("background-color", "white");
    qrObject.css("padding", "10px");
    qrObject.css("border-left", "1px solid #ccc");
    qrObject.css("border-top", "1px solid #ccc");
    qrObject.css("border-bottom", "1px solid white");
    qrObject.css("border-radius", "3px");
    qrObject.css("-webkit-box-shadow", "3px 3px 3px #555");
    qrObject.css("-moz-box-shadow", "3px 3px 3px #555");
    qrObject.css("box-shadow", "3px 3px 3px #555");    
    qrObject.children("canvas").css("width", "150px");
    qrObject.children("canvas").css("height", "150px");   

    // Add description to QR code
    qrObject.append('<div style="text-align: center;">IOTA Micropayment<br/><i>' + tipMessage + '</i></div>')    
                    
    // Add QR overlay
    $( parent ).append(qrObject);
    
    // Define mouse-over event
    $( parent ).mouseleave(function() {
        qrObject.css("visibility", "hidden");
        qrObject.css("opacity", "0");
    });
    
    // Define mouse-over event
    $( parent ).mouseover(function() {
        qrObject.css("visibility", "visible");
        qrObject.css("opacity", "1");
    });
}

function updateTips(parent, tippedIotas) {  // only called if connection to IOTA full node is established!
    // Remove loading image with value
    if (tippedIotas > 1000000000 ) {
        $( parent ).children("span").children("img:last").replaceWith('<span style="vertical-align: middle;">' + (tippedIotas / 1000 / 1000 / 1000) + ' Gi</span>');
    }
    else if (tippedIotas > 1000000 ) {
        $( parent ).children("span").children("img:last").replaceWith('<span style="vertical-align: middle;">' + (tippedIotas / 1000 / 1000) + ' Mi</span>');
    }
    else if (tippedIotas > 1000 ) {
        $( parent ).children("span").children("img:last").replaceWith('<span style="vertical-align: middle;">' + (tippedIotas / 1000) + ' Ki</span>');
    }
    else {
        $( parent ).children("span").children("img:last").replaceWith('<span style="vertical-align: middle;">' + tippedIotas + ' i</span>');
    }
}


//
// LIBRARY CORE - DO NOT EDIT UNLESS NECESSARY
//

(function ( $ ) {


    $.fn.microtipping = function( iotaNodeUrl ) { 
        
        // Establish connection to an IOTA full node for querying balances
        function connectIotaNode(url) {            
            // Create IOTA instance directly with provider
            con = new IOTA({
                'provider': url
            });
            return con
        }
        
        // Check whether an address is according to the definition
        function validateAddress(tipAddress) {
            if (tipAddress == null) {
                return false;                
            }
            if( tipAddress.length != 90 ) {
                return false;
            }
            if(! /[a-zA-Z9]/.test(tipAddress)) {
                return false;
            }
            return true;
        }
        
        
        // Convert binary string to trytes as required by the IOTA library
        function toTrytes(input) {
            // If input is not a string, return null
            if ( typeof input !== 'string' ) return null

            var TRYTE_VALUES = "9ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var trytes = "";

            for (var i = 0; i < input.length; i++) {
                var char = input[i];
                var asciiValue = char.charCodeAt(0);

                // If not recognizable ASCII character, return null
                if (asciiValue > 255) {
                    //asciiValue = 32
                    return null;
                }

                var firstValue = asciiValue % 27;
                var secondValue = (asciiValue - firstValue) / 27;

                var trytesValue = TRYTE_VALUES[firstValue] + TRYTE_VALUES[secondValue];

                trytes += trytesValue;
            }
            return trytes;
        }
        
        // Convert to string and trim before converting to trytes
        function toSanitizedTrytes(input) {
            return toTrytes(input.toString().trim());            
        }
        
        // Genreate QR code image
        function generateQr(address, message, amount) {  // Make sure incoming data is already sanitized for IOTA use
            var qrObject = null;
            if( validateAddress(address) ) { 
                var code = '{"address":"' + address + '","amount":"' + amount + '","message":"' + toSanitizedTrytes(message) + '"}';
                qrObject = $( document.createElement("div") ).qrcode(code);
            }
            return qrObject;
        }
        
        // Query tips for given address/message and update values in DOM
        function queryAndUpdateTips(parent, address, message) {            
            iotaConnection.api.findTransactionObjects({'addresses': [address]}, function(error, success) {                
                if (error) {
                    console.error(error);
                } else {       
                    var balance = 0;
                    $( success ).each(function() {
                        if (this["signatureMessageFragment"].startsWith(toSanitizedTrytes(message))) {
                            balance += parseInt(this["value"])
                        }
                    });
                    updateTips(parent, balance);     
                }
            })                   
        }
                
        // Connect to IOTA node if connection details are given
        var iotaConnection = null;       
        if(iotaNodeUrl) {
            iotaConnection = connectIotaNode(iotaNodeUrl);
        }
                
        // Initialize DOM
        this.each(function() {            
            // Prepare initial DOM model
            initDom(iotaConnection, $( this ));            
        });
               
        // Fill DOM with values
        this.each(function() {
        
            // Inject IOTA QR code into DOM model
            var tipAddress  = $( this ).data("address").toString().trim() ? $( this ).data("address") : null;
            var tipMessage  = $( this ).data("tag").toString().trim() ? $( this ).data("tag") : "Microtip";    
            var tipAmount   = $( this ).data("amount").toString().trim() ? $( this ).data("amount") : "1";
            
            if (tipAddress) {
                // Generate QR code and inject it into DOM
                qrObject = generateQr(tipAddress, tipMessage, tipAmount);
                updateQr($( this ), qrObject, tipAddress, tipMessage, tipAmount);

                // Query tips and inject them into DOM
                if(iotaConnection) {
                    var tippedIotas = queryAndUpdateTips($( this ), tipAddress, tipMessage);                    
                }
            }
        });        
    };
    
}( window.jQuery ));


//
// INITIALIZATION
//

$(document).ready(function(){    
    $('[data-address]').microtipping(); 
});
