function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

  	function validateForm(theForm) {
		  if (theForm.MobileNo.value == "")
		  {
			alert("Please enter a value for the \"Mobile No\" field.");
			theForm.MobileNo.focus();
			return (false);
		  }
		
		  if (theForm.MobileNo.value.length < 10)
		  {
			alert("Please enter at least 10 characters in the \"Mobile No\" field.");
			theForm.MobileNo.focus();
			return (false);
		  }
		
		  if (theForm.MobileNo.value.length > 10)
		  {
			alert("Please enter at most 10 characters in the \"Mobile No\" field.");
			theForm.MobileNo.focus();
			return (false);
		  }
		
		  var checkOK = "0123456789";
		  var checkStr = theForm.MobileNo.value;
		  var allValid = true;
		  var validGroups = true;
		  var decPoints = 0;
		  var allNum = "";
		  for (i = 0;  i < checkStr.length;  i++)
		  {
			ch = checkStr.charAt(i);
			for (j = 0;  j < checkOK.length;  j++)
			  if (ch == checkOK.charAt(j))
				break;
			if (j == checkOK.length)
			{
			  allValid = false;
			  break;
			}
			allNum += ch;
		  }
		  if (!allValid)
		  {
			alert("Please enter only digit characters in the \"Mobile No\" field.");
			theForm.MobileNo.focus();
			return (false);
		  }
		  return (true);	
	}
	
	function busSignon() {
			exit = false;
			var f = document.forms["form1"];
			var oktogo = 0;
			
		if(f.pin.value.search(/\S/) == -1)
			{
				alert("Please enter the PIN sent to your mobile");
				oktogo =1;
				return false;
			}
			if(!f.terms.checked)
			{
				alert('Please accept the Terms & Conditions');
				oktogo = 1 ;
				return false;
			}		
			if(oktogo == 0) {		
				f.submit();	
			}
		return false;
	}	
	
	function isEmailAddr(email)
	{
	  var result = false;
	  var theStr = new String(email);
	  var index = theStr.indexOf("@");
	  if (index > 0)
	  {
	    var pindex = theStr.indexOf(".",index);
	    if ((pindex > index+1) && (theStr.length > pindex+1))
	        result = true;
	  }
	  return result;
	}

	function oneEmailPlease(daForm) {
		if( daForm.fEmail1.value == "" ){
			alert("please enter at least one email address!");
			return false;
		}else{
			if( isEmailAddr(daForm.fEmail1.value) ){
				return true;
			}else{
				alert("Please enter a complete email address in the form: yourname@yourdomain.com");
				return false;
			}
		}
		return false;
	}	


function $() {
	var elements = new Array();
	for (var i = 0; i < arguments.length; i++) {
		var element = arguments[i];
		if (typeof element == 'string')
			element = document.getElementById(element);
		if (arguments.length == 1)
			return element;
		elements.push(element);
	}
	return elements;
}

function xx(o, x, obj)
{
	if (o.value.length == x)
		eval(obj).focus();
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}


function isChecked(qA,qB){
		var qAisChecked = false;
		var qBisChecked = false;

		for (i=qA.length-1; i > -1; i--) {
			if (qA[i].checked) {
				qAisChecked = true;
			}
		}

		for (i=qB.length-1; i > -1; i--) {
			if (qB[i].checked) {
				qBisChecked = true;
			}
		}

		if(qAisChecked && qBisChecked){
			return true;
		}else{
			if(!qAisChecked){
				qA[0].focus();
			}else{
				qB[0].focus();
			}
			alert("Please choose an answer");
			return false;
		}
}

function checkDefaultTextFieldValue(obj,defaultText){
	if( defaultText == obj.value ){
		obj.value = "";
	}else{
		if( obj.value == '' ){
			obj.value = defaultText;
		}
	}
}