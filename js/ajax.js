/**
 * JavaScript Ajax 简化使用类
 * @param string returnType 	'XML' or 'HTML'(default)
 */
function Ajax(returnType) {

	var ajax = new Object();
	ajax.returnType = returnType ? returnType.toUpperCase() : "HTML";
	ajax.requestUrl = '';
	ajax.requestContent = '';
	ajax.callback = null;

	ajax.createAjaxObj = function() {
		var request = false;
		if(window.XMLHttpRequest) {
			//Not IE
			request = new XMLHttpRequest();
			if(request.overrideMimeType) {
				request.overrideMimeType("text/xml");
			}
		}else if(window.ActiveXObject){
			//IE
			var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Msxml2.XMLHTTP.7.0','Msxml2.XMLHTTP.6.0','Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
			for(var i=0; i<versions.length; i++) {
				try {
					request = new ActiveXObject(versions[i]);
					if(request) {
						return request;
					}
				} catch(e) {
					request = false;
				}
			}
		}
		return request;
	}

	ajax.XMLHttpRequest = ajax.createAjaxObj();

	ajax.process = function() {
		if(ajax.XMLHttpRequest.readyState == 4) {
			if(ajax.XMLHttpRequest.status == 200) {
				if(ajax.returnType == "HTML") {
					ajax.callback(ajax.XMLHttpRequest.responseText);
				}else if(ajax.returnType == "XML") {
					ajax.callback(ajax.XMLHttpRequest.responseXML);
				}
			}
		}
	}

	ajax.get = function(requestUrl, callback) {
		ajax.requestUrl = requestUrl;
		if(callback != null) {
			ajax.XMLHttpRequest.onreadystatechange = ajax.process;
			ajax.callback = callback;
		}
		if(window.XMLHttpRequest) {
			ajax.XMLHttpRequest.open('get', ajax.requestUrl);
			ajax.XMLHttpRequest.send(null);
		}else {
			ajax.XMLHttpRequest.open('get', ajax.requestUrl, true);
			ajax.XMLHttpRequest.send();
		}
	}

	ajax.post = function(requestUrl, requestContent, callback) {
		ajax.requestUrl = requestUrl;
		if(typeof(requestContent) == 'object') {
			var str = '';
			for(var key in requestContent) {
				str += key + '=' + requestContent[key] + '&';
			}
			ajax.requestContent = str.substr(0, str.length - 1);
		}else {
			ajax.requestContent = requestContent;
		}
		if(callback != null) {
			ajax.XMLHttpRequest.onreadystatechange = ajax.process;
			ajax.callback = callback;
		}
		ajax.XMLHttpRequest.open('post', requestUrl);
		ajax.XMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		ajax.XMLHttpRequest.send(ajax.requestContent);
	}

	return ajax;

}