var commonLi = {};
/*
*	Usage:验证url
*/
commonLi.isURL = function(url){
	var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{3}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
	var re = new RegExp(strRegex);
	if (re.test(url)) {
		return true;
	} else {
		return false;
	}
}

/*
*	Usage:关闭当前窗口 兼容多浏览器
*/
commonLi.closeWebPage = function(){
	 if (navigator.userAgent.indexOf("MSIE") > 0) {
		if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
			window.opener = null;
			window.close();
		} else {
			window.open('', '_top');
			window.top.close();
		}
	 }
	 else if (navigator.userAgent.indexOf("Firefox") > 0) {
		window.location.href = 'about:blank ';
	 } else {
		window.opener = null;
		window.open('', '_self', '');
		window.close();
	 }
}