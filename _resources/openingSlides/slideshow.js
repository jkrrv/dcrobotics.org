var slidesTimer;
var slidesOn=false;
var slideAct="A";
var slideNumChangeTo = 0;
var slideCountdownN=slideHeight;
var slidePercentage = 100;
var slidePanelNew = "B";
var slideChanging=false;

function slideCommand(command) {
	if (command!=0 && slideChanging==false && slidePercentage==100) {
		slidesOn=1;
		slides();
		slideChange(command);
	}
}

function slideChange(change) {
	if (slideChanging==false) { // if the action is just starting
		slideChanging=true;
		if (change=="-") {  // interpret command as number-changing
			slideNumChangeTo--;
		} else if (change=="+") {
			slideNumChangeTo++;
		} else {
			slideNumChangeTo=change-1;
		}

		if (slideNumChangeTo>(slideContent.length-1)) { // keep things from rolling off the ends
			slideNumChangeTo = 0;
		} else if (slideNumChangeTo<0) {
			slideNumChangeTo = (slideContent.length-1);
		}

		if (slidePanelNew=="A") { // set content (may not be set if going out of order)
			document.getElementById('slidesA').style.backgroundImage="url('" + slidesRelUrl + slideContent[slideNumChangeTo][1] + "')";
			document.getElementById('slidesA').innerHTML=slideContent[slideNumChangeTo][4];
		} else {
			document.getElementById('slidesB').style.backgroundImage="url('" + slidesRelUrl + slideContent[slideNumChangeTo][1] + "')";
			document.getElementById('slidesB').innerHTML=slideContent[slideNumChangeTo][4];
		}

		for (val=0;val<(slideContent.length);val++) { // change color of buttons
			document.getElementById('slidesBtn'+(val)).style.background="url(" + slidesRelUrl + "slideControlButtons.png) -68px 0";
		}
		document.getElementById('slidesBtn'+(slideNumChangeTo)).style.background="url(" + slidesRelUrl + "slideControlButtons.png) -85px 0";
	}
	slideChanging=true;
	slidePercentage-=slideChangeIncrement;
	if (slidePercentage>0) { //still has to do at least one more incremental change (appa)
		slidesTimer=setTimeout("slideChange(0)",slideChangeRate);
	}
	if (slidePercentage<slideChangeIncrement) {
		slidePercentage = 0;
	}
	if (slidePanelNew=="A") {
		if (navigator.appName=="Microsoft Internet Explorer") {
			if (slidesThroughBlack) {
				document.getElementById('slidesA').filters.alpha.opacity=100-slidePercentage;
			}
			document.getElementById('slidesB').filters.alpha.opacity=slidePercentage;
		} else {
			if (slidesThroughBlack) {
				document.getElementById('slidesA').style.opacity=1-(slidePercentage*.01);
			}
			document.getElementById('slidesB').style.opacity=(slidePercentage*.01); 
		}
	} else {
		if (navigator.appName=="Microsoft Internet Explorer") {
			document.getElementById('slidesB').filters.alpha.opacity=100-slidePercentage;
			if (slidesThroughBlack) {
				document.getElementById('slidesA').filters.alpha.opacity=slidePercentage;
			}
		} else {
			document.getElementById('slidesB').style.opacity=1-(slidePercentage*.01);
			if (slidesThroughBlack) {
				document.getElementById('slidesA').style.opacity=(slidePercentage*.01);
			}
		}
	}
	if (slidePercentage==100-(Math.round((100-slideAnchorChangePercentage)/slideChangeIncrement)*slideChangeIncrement)) {
		slideAnchorChange(slideNumChangeTo);
	}
	if (slidePercentage<=0) {
		slidePercentage=100;
		slideChanging=false;
		if (slideNumChangeTo==(slideContent.length-1)) { //if the next one is the first one
			if (slidePanelNew=="A") {
				document.getElementById('slidesB').style.backgroundImage="url('" + slidesRelUrl + slideContent[0][1] + "')";
				document.getElementById('slidesB').innerHTML="";
				slidePanelNew="B";
			} else {
				document.getElementById('slidesA').style.backgroundImage="url('" + slidesRelUrl + slideContent[0][1] + "')";
				document.getElementById('slidesA').innerHTML="";
				slidePanelNew="A";
			}
		} else {
			if (slidePanelNew=="A") {
				document.getElementById('slidesB').style.backgroundImage="url('" + slidesRelUrl + slideContent[slideNumChangeTo+1][1] + "')";
				document.getElementById('slidesB').innerHTML="";
				slidePanelNew="B";
			} else {
				document.getElementById('slidesA').style.backgroundImage="url('" + slidesRelUrl + slideContent[slideNumChangeTo+1][1] + "')";
				document.getElementById('slidesA').innerHTML="";
				slidePanelNew="A";
			}
		}
	}
}

function timerNext() {
	slidesOn=1;
	if (slideAct=="A") {
		document.getElementById('slidesCountdown').height=slideCountdownN;
	} else {
		document.getElementById('slidesCountdown').height=slideHeight-slideCountdownN;
	}
	if (slideCountdownN==slideChangePoint) {
		slideChange("+")
	}
	slideCountdownN-=1;
	if (slideCountdownN<=0) {
		if (slideAct=="A") {
			slideAct="B"
			document.getElementById('slidesCountdown').style.top="0px";
			document.getElementById('slidesCountdown').style.bottom="auto";
		} else {
			slideAct="A"
			document.getElementById('slidesCountdown').style.top="auto";
			document.getElementById('slidesCountdown').style.bottom="0px";
		}
		slideCountdownN=slideHeight
	}
	slidesTimer=setTimeout("timerNext()",slideStepTime);
}

function slides() {
	if (!slidesOn) {
		document.getElementById('slidesBtnPlay').style.background="url(" + slidesRelUrl + "slideControlButtons.png) -17px 0";
		document.getElementById('slidesBtnPlay').title="Pause";
 		timerNext();
	} else {
		slidesOn=0;
		clearTimeout(slidesTimer);
		document.getElementById('slidesBtnPlay').style.background="url(" + slidesRelUrl + "slideControlButtons.png) 0 0";
		document.getElementById('slidesBtnPlay').title="Resume";
	}
}

function slidesMouseOut() {
	if (slidesOn) {
		document.getElementById('slidesControl').style.display='none';
	}
	document.getElementById('slidesNavigator').style.display='none';
}

function slidesOnLoad() {
	for (val=0;val<(slideContent.length);val++) {
		document.getElementById('slidesNavigator').innerHTML=document.getElementById('slidesNavigator').innerHTML + "<a href='javascript:;' onClick='slideCommand(" + (val+1) + ");' title='" + slideContent[val][0] + "'><img src='" + slidesRelUrl + "clear.gif' id='slidesBtn" + val + "' onMouseOver='changeOpacity(this,1)' onMouseOut='changeOpacity(this,.6)' style='width:16px; height:16px; opacity:.6; filter:alpha(opacity=60); ' /></a>";
	}
	document.getElementById('slidesA').style.background=document.getElementById('slidesA').style.backgroundImage="url('" + slidesRelUrl + slideContent[0][1] + "')";
	slideCommand(1);
	slides();
}

function slideAnchorChange(whichSlide) {
	if (slideContent[whichSlide][2]=="") { //no link built-in
		document.getElementById('slidesImageMap').innerHTML="<area alt='' />;";
	} else { // image map areas in CSV
		document.getElementById('slidesImageMap').innerHTML=slideContent[whichSlide][2];
	}
}

function changeOpacity(opaqueObject,opacityLevel) {
	if (navigator.appName=="Microsoft Internet Explorer") {
		opaqueObject.filters.alpha.opacity=opacityLevel*100
	} else {
		opaqueObject.style.opacity=opacityLevel;
	}
}