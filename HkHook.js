// Draggable Windows functions

var DW_mouseX, DW_mouseY, DW_offsetX, DW_offsetY;
var DW_id = "win1";
var DW_dragMode = false;
var DW_offsetMode = false;

function DW_selection(target, act){
	if (!act) {
		if (typeof target.onselectstart != "undefined") //IE route
			target.onselectstart = function() { return false; }
		else if (typeof target.style.MozUserSelect != "undefined") //Firefox route
			target.style.MozUserSelect = "none";
		else //All other route (ie: Opera)
			target.onmousedown = function() { return false; }
	} else {
		if (typeof target.onselectstart != "undefined") //IE route
			target.onselectstart = function() { return true; }
		else if (typeof target.style.MozUserSelect != "undefined") //Firefox route
			target.style.MozUserSelect = "none";
		else //All other route (ie: Opera)
			target.onmousedown = function() { return true; }
	}
}

function DW_findPos(obj) {
	var left = 0;
	var top = 0;
	if (obj.offsetParent) {
		left = obj.offsetLeft;
		top = obj.offsetTop;
		while (obj = obj.offsetParent) {
			left += obj.offsetLeft;
			top += obj.offsetTop;
		}
	}
	DW_offsetX = left;
	DW_offsetY = top;
}

function DW_moving(event) {
	
	var alvo = document.getElementById(DW_id);
	
	if (document.all) {
		DW_mouseX = window.event.clientX;
		DW_mouseY = window.event.clientY;
	} else {
		DW_mouseX = event.pageX;
		DW_mouseY = event.pageY;
	}
	if (!DW_offsetMode) {
		DW_findPos(document.getElementById(DW_id));
		DW_offsetX = DW_mouseX - DW_offsetX;
		DW_offsetY = DW_mouseY - DW_offsetY;
	}
	
	 var debugPanel = DW_searchDOM('//p[@class="debug"]').snapshotItem(0);
	if(debugPanel) debugPanel.innerHTML = "DW_mouseX: "+DW_mouseX+"<br />DW_mouseY: "+DW_mouseY+"<br />DW_offsetX: "+DW_offsetX+"<br />DW_offsetY: "+DW_offsetY+"<br />window: "+DW_id+"<br />DW_dragMode: "+DW_dragMode;
	
	var body = document.getElementsByTagName("body").item(0);
	if (DW_dragMode) {
		alvo.style.top = (DW_mouseY-DW_offsetY)+"px";
		alvo.style.left = (DW_mouseX-DW_offsetX)+"px";
		alvo.style.cursor = "move";
		alvo.style.opacity = 0.7;
		alvo.style.filter = "alpha(opacity=70)";
		DW_selection(body, false);
		
		//GM_setValue(vInfo.uniqueID+"DragWin."+DW_id,alvo.style.top+":"+alvo.style.left);
		
	} else {
		alvo.style.cursor = "default";
		alvo.style.opacity = 1;
		alvo.style.filter = "alpha(opacity=100)";
		DW_selection(body, true);
	}
}

function DW_startDrag(win_id){
	//DW_id=domWindow.getAttribute("id");
	DW_id=win_id;
 //alert(DW_id);

	DW_findPos(document.getElementById(DW_id));
	DW_offsetX = DW_mouseX - DW_offsetX;
	DW_offsetY = DW_mouseY - DW_offsetY;

	DW_dragMode = true; DW_offsetMode = true;
}
function DW_stopDrag() { DW_dragMode = false; DW_offsetMode = false; }

function DW_closeWindow(btn) {
	var window=btn.parentNode.parentNode;
	var id=window.getAttribute("id");
	
	window.style.visibility = "hidden";

	GM_setValue(vInfo.uniqueID+"DragWin."+id+".closed","true");
}
function DW_isClosed(window){
 
	var id=window.getAttribute("id");
	var closed=GM_getValue(vInfo.uniqueID+"DragWin."+id+".closed");
	return closed=="true";
}
	
function DW_openWindows() { 
	var windows=document.evaluate('//div[@class="DW_window"]',document,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null);
	for(var i=0;i<windows.snapshotLength;i++){
		windows.snapshotItem(i).style.visibility = "visible";
		var id=windows.snapshotItem(i).getAttribute("id");
		GM_setValue(vInfo.uniqueID+"DragWin."+id+".closed","false");
	}
}


function DW_isMinimized(window){
 
	var id=window.getAttribute("id");
	var minimized=window.getAttribute("minimized");
	return minimized=="true";

	//return window.getAttribute("minimized")=="true";
}

function DW_minimax(btn) {
 //alert("entering DW_minimax()");

	var window=btn.parentNode.parentNode;
	var id=window.getAttribute("id");
 //alert("id: "+id);


	var minimized=DW_isMinimized(window);
 //alert("minimized: "+minimized);
 
	if(minimized){	 // if it is minimized, let's restore it
		DW_setMinimized(btn,false);
	}else{		// but if it is not minimized, let's minimize it
		DW_setMinimized(btn,true);
	}
 
}

function DW_setMinimized(btn,value){

	var window=btn.parentNode.parentNode;
	var id=window.getAttribute("id");
	var content=document.evaluate('//div[@id="'+window.getAttribute("id")+'"]/div[@class="content"]',document,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null).snapshotItem(0);
	var statusbar=document.evaluate('//div[@id="'+window.getAttribute("id")+'"]/div[@class="statusbar"]',document,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null).snapshotItem(0);
	
	if(value){	// minimize it
		content.style.display = "none";
		btn.innerHTML = "+";
		btn.setAttribute("title", "Maximize");
		window.setAttribute("minimized",true);
		
		//GM_setValue(vInfo.uniqueID+"DragWin."+id+".minimized","true");
	
	}else{		// restore it
		content.style.display = "block";
		btn.innerHTML = "-";
		btn.setAttribute("title", "Minimize");
		statusbar.style.display = "block";
		window.setAttribute("minimized",false);
		
		//GM_setValue(vInfo.uniqueID+"DragWin."+id+".minimized","false");
	}

}

function DW_hideWindow(btn) {
 
	var window=btn.parentNode.parentNode;
	var minimaxBtn=DW_searchNode(window,'//a[@class="minimax"]').snapshotItem(0);
 
	if (!DW_isMinimized(window)) {
		DW_minimax(minimaxBtn);
	}
	window.style.top = 0;
	window.style.left = 0;
	window.getElementById("statusbar").style.display = "none";
}

//document.onmousemove = function(event) { DW_moving(event); }
document.addEventListener('mousemove', function(event) { DW_moving(event); }, false);
document.addEventListener('mouseup', DW_stopDrag, false);



// verifies if JavaScript is enabled and correctly supports DOM
function DW_verifyJS(){
	 if(document.getElementById && document.createTextNode) jsAvailable=true;
	 return jsAvailable;
}



// adds an event to an object, supporting a bunch of not-standardized damned browsers
function DW_addEvent(elm, evType, fn, useCapture){
	//if(!isJsAvailable()) return;
	
	if(elm.addEventListener){
		elm.addEventListener(evType, fn, useCapture);
		return true;
	}else if (elm.attachEvent){
		var r = elm.attachEvent('on' + evType, fn);
		return r;
	}else
		elm['on' + evType] = fn;
}

// adds a function as event to window.load
// if there is already another event attached to it, a new function is created that calls both events and this function is attached to window.load
// this way, if any other script had already attached an event there, this event is not overwritten and lost forever
function DW_addLoadEvent(func){
	//if(!isJsAvailable()) return;
	
	var oldonload = window.onload;
	if(typeof window.onload != 'function')
		DW_addEvent(window, 'load', func, false);
		//window.onload = func;
	else
		DW_addEvent(window, 'load', function(){
				if(oldonload)
					oldonload();
				func();
		} , false);
	
}

function DW_searchDOM(X){return document.evaluate(X,document,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null);}
function DW_searchNode(doc,X){return document.evaluate(X,doc,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null);}




function DW_init(){
	var windows = DW_searchDOM('//div[@class="DW_window"]');

 //alert(windows.snapshotLength+' windows found');

	for(var i=0;i<windows.snapshotLength;i++){
		var window=windows.snapshotItem(i);
 //alert(window.innerHTML);
		
		var aclose=DW_searchNode(window,'//a[@class="close"]').snapshotItem(0);
		aclose.addEventListener('mouseup', function(){ DW_closeWindow(this);  }, false);
		
		var ahide=DW_searchNode(window,'//a[@class="hide"]').snapshotItem(0);
 //alert(ahide.innerHTML);
		ahide.addEventListener('mouseup', function(){ DW_hideWindow(this);  }, false);
	
		var aminimax=DW_searchNode(window,'//a[@class="minimax"]').snapshotItem(0);
		aminimax.addEventListener('mouseup', function(){ DW_minimax(this);  }, false);
		
		
		var titlebar=DW_searchNode(window,'//div[@class="titlebar"]').snapshotItem(0);
		titlebar.addEventListener('mousedown', function(){ DW_startDrag(this.parentNode.getAttribute("id"));  }, false);
		
		window.addEventListener('mouseup', DW_stopDrag, false);

		window.addEventListener('mousemove', function(event) { DW_moving(event); }, false);

	}

}

DW_addLoadEvent(DW_init);








/* Window exemple */

function debug(){


	
	var dwwin = 


			'<p><img src="xls.jpg" alt="random image"/>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus venenatis fringilla purus. Suspendisse ultrices, leo vitae mollis eleifend, mi orci volutpat justo, in mollis erat dolor at dolor. Etiam volutpat diam. Morbi diam. Cras leo enim, imperdiet sit amet, facilisis a, ullamcorper in, nunc. Nunc elit quam, egestas sed, viverra eget, tempus nec, turpis. Morbi mauris dolor, adipiscing id, facilisis eget, dapibus ac, turpis.</p>'+
			'<p>Quisque nec magna. Morbi tellus nisl, ullamcorper sed, ullamcorper in, adipiscing et, tellus. Maecenas at urna. In vehicula est sed purus. Quisque lobortis vestibulum nulla. Sed lacinia pellentesque massa. Nulla facilisi. Vestibulum semper. Nulla vitae lacus eu mauris tincidunt luctus. Ut porttitor nisi quis tortor. Vestibulum adipiscing, elit id scelerisque molestie, tortor lacus ullamcorper neque, ut tristique mi purus sit amet orci.</p>'+
			'<p>Ut venenatis lacus ut diam. Nunc dignissim mattis risus. Nam sollicitudin nunc ut mauris commodo venenatis. Fusce augue tortor, consectetuer non, cursus nec, aliquam ac, magna. Praesent orci.</p>'+
			'<p id="debug">Ut venenatis lacus ut diam. Nunc dignissim mattis risus. Nam sollicitudin nunc ut mauris commodo venenatis. Fusce augue tortor, consectetuer non, cursus nec, aliquam ac, magna. Praesent orci.</p>';


	



	var body, windiv, titlebar, titlehead, content, statusbar, aclose, ahide, aminimax;
	body = document.getElementsByTagName('body')[0];
	
	windiv = document.createElement('DIV');
	windiv.id='win1';
	windiv.className='DW_window';
	windiv.style.top="600px";
	windiv.style.left="700px";
	
	titlebar = document.createElement('DIV');
	titlebar.className='titlebar';
	windiv.appendChild(titlebar);
	
	titlehead = document.createElement('H2');
	titlehead.innerHTML='Window Title';
	titlebar.appendChild(titlehead);
	
	aclose = document.createElement('A');
	aclose.title="Close";
	aclose.id="close";
	aclose.addEventListener('mouseup', function(){ DW_closeWindow(aclose);  }, false);
	aclose.innerHTML='x';
	titlebar.appendChild(aclose);
	
	ahide = document.createElement('A');
	ahide.title="Hide";
	ahide.id="hide";
	ahide.addEventListener('mouseup', function(){ DW_hideWindow(ahide);  }, false);
	ahide.innerHTML='^';
	titlebar.appendChild(ahide);
	
	aminimax = document.createElement('A');
	aminimax.title="Minimize";
	aminimax.id="minimax";
	aminimax.addEventListener('mouseup', function(){ DW_minimax(aminimax);  }, false);
	aminimax.innerHTML='-';
	titlebar.appendChild(aminimax);
	
	
	
	
	content = document.createElement('DIV');
	content.className='content';
	windiv.appendChild(content);
	
	statusbar = document.createElement('DIV');
	statusbar.className='statusbar';
	statusbar.innerHTML='statusbar .:';
	windiv.appendChild(statusbar);

	
	
	
	content.innerHTML = dwwin;
	body.appendChild(windiv);
	windiv.addEventListener('mousedown', function(){ DW_startDrag(windiv);  }, false);
	windiv.addEventListener('mouseup', DW_stopDrag, false);

	windiv.addEventListener('mousemove', function(event) { DW_moving(event); }, false);



}

//debug();
