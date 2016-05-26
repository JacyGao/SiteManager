// JavaScript Document

var xmlHttp;

function urlencode(str) {
	return escape(str).replace(/\+/g,'%2B').replace(/%20/g, '+').replace(/\*/g, '%2A').replace(/\//g, '%2F').replace(/@/g, '%40');
}

function ajax_div(url, target) {
	target.innerHTML = "<b>Data loading, please wait...</b>";
	ajax_div_nomsg(url,target);
}

function ajax_js(url) {
	xmlHttp = new GetXmlHttpObject();	
	if (xmlHttp==null) { alert ("Browser does not support HTTP Request"); return false; }

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
			eval(xmlHttp.responseText);
		}

	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function ajax_div_nomsg(url, target) {
	xmlHttp = new GetXmlHttpObject();	
	if (xmlHttp==null) { alert ("Browser does not support HTTP Request"); return false; }

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
			target.innerHTML = xmlHttp.responseText;
//			target.style.height = target.innerHeight + 'px';
		}

	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}


function GetXmlHttpObject() { var xmlHttp=null; try { xmlHttp=new XMLHttpRequest(); } catch (e) { try { xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) { xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); } } return xmlHttp; }
