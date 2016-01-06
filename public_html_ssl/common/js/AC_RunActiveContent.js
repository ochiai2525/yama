//v1.7
//&nbsp;Flash&nbsp;Player&nbsp;Version&nbsp;Detection
//&nbsp;Detect&nbsp;Client&nbsp;Browser&nbsp;type
//&nbsp;Copyright&nbsp;2005-2007&nbsp;Adobe&nbsp;Systems&nbsp;Incorporated.&nbsp;&nbsp;All&nbsp;rights&nbsp;reserved.
var&nbsp;isIE&nbsp;&nbsp;=&nbsp;(navigator.appVersion.indexOf("MSIE")&nbsp;!=&nbsp;-1)&nbsp;?&nbsp;true&nbsp;:&nbsp;false;
var&nbsp;isWin&nbsp;=&nbsp;(navigator.appVersion.toLowerCase().indexOf("win")&nbsp;!=&nbsp;-1)&nbsp;?&nbsp;true&nbsp;:&nbsp;false;
var&nbsp;isOpera&nbsp;=&nbsp;(navigator.userAgent.indexOf("Opera")&nbsp;!=&nbsp;-1)&nbsp;?&nbsp;true&nbsp;:&nbsp;false;

function&nbsp;ControlVersion()
{
	var&nbsp;version;
	var&nbsp;axo;
	var&nbsp;e;

	//&nbsp;NOTE&nbsp;:&nbsp;new&nbsp;ActiveXObject(strFoo)&nbsp;throws&nbsp;an&nbsp;exception&nbsp;if&nbsp;strFoo&nbsp;isn't&nbsp;in&nbsp;the&nbsp;registry

	try&nbsp;{
		//&nbsp;version&nbsp;will&nbsp;be&nbsp;set&nbsp;for&nbsp;7.X&nbsp;or&nbsp;greater&nbsp;players
		axo&nbsp;=&nbsp;new&nbsp;ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
		version&nbsp;=&nbsp;axo.GetVariable("$version");
	}&nbsp;catch&nbsp;(e)&nbsp;{
	}

	if&nbsp;(!version)
	{
		try&nbsp;{
			//&nbsp;version&nbsp;will&nbsp;be&nbsp;set&nbsp;for&nbsp;6.X&nbsp;players&nbsp;only
			axo&nbsp;=&nbsp;new&nbsp;ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
			
			//&nbsp;installed&nbsp;player&nbsp;is&nbsp;some&nbsp;revision&nbsp;of&nbsp;6.0
			//&nbsp;GetVariable("$version")&nbsp;crashes&nbsp;for&nbsp;versions&nbsp;6.0.22&nbsp;through&nbsp;6.0.29,
			//&nbsp;so&nbsp;we&nbsp;have&nbsp;to&nbsp;be&nbsp;careful.&nbsp;
			
			//&nbsp;default&nbsp;to&nbsp;the&nbsp;first&nbsp;public&nbsp;version
			version&nbsp;=&nbsp;"WIN&nbsp;6,0,21,0";

			//&nbsp;throws&nbsp;if&nbsp;AllowScripAccess&nbsp;does&nbsp;not&nbsp;exist&nbsp;(introduced&nbsp;in&nbsp;6.0r47)		
			axo.AllowScriptAccess&nbsp;=&nbsp;"always";

			//&nbsp;safe&nbsp;to&nbsp;call&nbsp;for&nbsp;6.0r47&nbsp;or&nbsp;greater
			version&nbsp;=&nbsp;axo.GetVariable("$version");

		}&nbsp;catch&nbsp;(e)&nbsp;{
		}
	}

	if&nbsp;(!version)
	{
		try&nbsp;{
			//&nbsp;version&nbsp;will&nbsp;be&nbsp;set&nbsp;for&nbsp;4.X&nbsp;or&nbsp;5.X&nbsp;player
			axo&nbsp;=&nbsp;new&nbsp;ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version&nbsp;=&nbsp;axo.GetVariable("$version");
		}&nbsp;catch&nbsp;(e)&nbsp;{
		}
	}

	if&nbsp;(!version)
	{
		try&nbsp;{
			//&nbsp;version&nbsp;will&nbsp;be&nbsp;set&nbsp;for&nbsp;3.X&nbsp;player
			axo&nbsp;=&nbsp;new&nbsp;ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version&nbsp;=&nbsp;"WIN&nbsp;3,0,18,0";
		}&nbsp;catch&nbsp;(e)&nbsp;{
		}
	}

	if&nbsp;(!version)
	{
		try&nbsp;{
			//&nbsp;version&nbsp;will&nbsp;be&nbsp;set&nbsp;for&nbsp;2.X&nbsp;player
			axo&nbsp;=&nbsp;new&nbsp;ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			version&nbsp;=&nbsp;"WIN&nbsp;2,0,0,11";
		}&nbsp;catch&nbsp;(e)&nbsp;{
			version&nbsp;=&nbsp;-1;
		}
	}
	
	return&nbsp;version;
}

//&nbsp;JavaScript&nbsp;helper&nbsp;required&nbsp;to&nbsp;detect&nbsp;Flash&nbsp;Player&nbsp;PlugIn&nbsp;version&nbsp;information
function&nbsp;GetSwfVer(){
	//&nbsp;NS/Opera&nbsp;version&nbsp;>=&nbsp;3&nbsp;check&nbsp;for&nbsp;Flash&nbsp;plugin&nbsp;in&nbsp;plugin&nbsp;array
	var&nbsp;flashVer&nbsp;=&nbsp;-1;
	
	if&nbsp;(navigator.plugins&nbsp;!=&nbsp;null&nbsp;&&&nbsp;navigator.plugins.length&nbsp;>&nbsp;0)&nbsp;{
		if&nbsp;(navigator.plugins["Shockwave&nbsp;Flash&nbsp;2.0"]&nbsp;||&nbsp;navigator.plugins["Shockwave&nbsp;Flash"])&nbsp;{
			var&nbsp;swVer2&nbsp;=&nbsp;navigator.plugins["Shockwave&nbsp;Flash&nbsp;2.0"]&nbsp;?&nbsp;"&nbsp;2.0"&nbsp;:&nbsp;"";
			var&nbsp;flashDescription&nbsp;=&nbsp;navigator.plugins["Shockwave&nbsp;Flash"&nbsp;+&nbsp;swVer2].description;
			var&nbsp;descArray&nbsp;=&nbsp;flashDescription.split("&nbsp;");
			var tempArrayMajor = descArray[2].split(".");			
			var versionMajor = tempArrayMajor[0];
			var versionMinor = tempArrayMajor[1];
			var versionRevision = descArray[3];
			if (versionRevision == "") {
				versionRevision = descArray[4];
			}
			if (versionRevision[0] == "d") {
				versionRevision = versionRevision.substring(1);
			} else if (versionRevision[0] == "r") {
				versionRevision = versionRevision.substring(1);
				if (versionRevision.indexOf("d") > 0) {
					versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
				}
			}
			var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;
		}
	}
	// MSN/WebTV 2.6 supports Flash 4
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;
	// WebTV 2.5 supports Flash 3
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;
	// older WebTV supports Flash 2
	else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;
	else if ( isIE && isWin && !isOpera ) {
		flashVer = ControlVersion();
	}	
	return flashVer;
}

// When called with reqMajorVer, reqMinorVer, reqRevision returns true if that version or greater is available
function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision)
{
	versionStr = GetSwfVer();
	if (versionStr == -1 ) {
		return false;
	} else if (versionStr != 0) {
		if(isIE && isWin && !isOpera) {
			// Given "WIN 2,0,0,11"
			tempArray         = versionStr.split(" "); 	// ["WIN", "2,0,0,11"]
			tempString        = tempArray[1];			// "2,0,0,11"
			versionArray      = tempString.split(",");	// ['2', '0', '0', '11']
		} else {
			versionArray      = versionStr.split(".");
		}
		var versionMajor      = versionArray[0];
		var versionMinor      = versionArray[1];
		var versionRevision   = versionArray[2];

        	// is the major.revision >= requested major.revision AND the minor version >= requested minor
		if (versionMajor > parseFloat(reqMajorVer)) {
			return true;
		} else if (versionMajor == parseFloat(reqMajorVer)) {
			if (versionMinor > parseFloat(reqMinorVer))
				return true;
			else if (versionMinor == parseFloat(reqMinorVer)) {
				if (versionRevision >= parseFloat(reqRevision))
					return true;
			}
		}
		return false;
	}
}

function AC_AddExtension(src, ext)
{
  if (src.indexOf('?') != -1)
    return src.replace(/\?/, ext+'?'); 
  else
    return src + ext;
}

function AC_Generateobj(objAttrs, params, embedAttrs) 
{ 
  var str = '';
  if (isIE && isWin && !isOpera)
  {
    str += '<object ';
    for (var i in objAttrs)
    {
      str += i + '="' + objAttrs[i] + '" ';
    }
    str += '>';
    for (var i in params)
    {
      str += '<param name="' + i + '" value="' + params[i] + '" /> ';
    }
    str += '</object>';
  }
  else
  {
    str += '<embed ';
    for (var i in embedAttrs)
    {
      str += i + '="' + embedAttrs[i] + '" ';
    }
    str += '> </embed>';
  }

  document.write(str);
}

function AC_FL_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
     , "application/x-shockwave-flash"
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}

function AC_SW_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".dcr", "src", "clsid:166B1BCA-3F9C-11CF-8075-444553540000"
     , null
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}

function AC_GetArgs(args, ext, srcParamName, classid, mimeType){
  var ret = new Object();
  ret.embedAttrs = new Object();
  ret.params = new Object();
  ret.objAttrs = new Object();
  for (var i=0; i < args.length; i=i+2){
    var currArg = args[i].toLowerCase();    

    switch (currArg){	
      case "classid":
        break;
      case "pluginspage":
        ret.embedAttrs[args[i]] = args[i+1];
        break;
      case "src":
      case "movie":	
        args[i+1] = AC_AddExtension(args[i+1], ext);
        ret.embedAttrs["src"] = args[i+1];
        ret.params[srcParamName] = args[i+1];
        break;
      case "onafterupdate":
      case "onbeforeupdate":
      case "onblur":
      case "oncellchange":
      case "onclick":
      case "ondblClick":
      case "ondrag":
      case "ondragend":
      case "ondragenter":
      case "ondragleave":
      case "ondragover":
      case "ondrop":
      case "onfinish":
      case "onfocus":
      case "onhelp":
      case "onmousedown":
      case "onmouseup":
      case "onmouseover":
      case "onmousemove":
      case "onmouseout":
      case "onkeypress":
      case "onkeydown":
      case "onkeyup":
      case "onload":
      case "onlosecapture":
      case "onpropertychange":
      case "onreadystatechange":
      case "onrowsdelete":
      case "onrowenter":
      case "onrowexit":
      case "onrowsinserted":
      case "onstart":
      case "onscroll":
      case "onbeforeeditfocus":
      case "onactivate":
      case "onbeforedeactivate":
      case "ondeactivate":
      case "type":
      case "codebase":
      case "id":
        ret.objAttrs[args[i]] = args[i+1];
        break;
      case "width":
      case "height":
      case "align":
      case "vspace": 
      case "hspace":
      case "class":
      case "title":
      case "accesskey":
      case "name":
      case "tabindex":
        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];
        break;
      default:
        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
    }
  }
  ret.objAttrs["classid"] = classid;
  if (mimeType) ret.embedAttrs["type"] = mimeType;
  return ret;
}
