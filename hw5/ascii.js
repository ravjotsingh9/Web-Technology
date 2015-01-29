"use strict";
var frames;
var currentframe;
var textboxContent;
var timer = null;
var interval;

/*  called when animation drop down changes*/
function animation_change()
{
	var x = document.getElementById("animationDropdown").value;
	document.getElementById("txtArea").value = ANIMATIONS[x];
}

/* called when size drop down changes*/
function size_change()
{
	var x = document.getElementById("sizeDropdown").value;
	document.getElementById("txtArea").style.fontSize = x;
}

/* called when start button is pressed */
function startAnimation()
{
	textboxContent = document.getElementById("txtArea").value;
	frames = textboxContent.split("=====\n");
	currentframe = 0;
	displayframe();
	turbo();
	timer = window.setInterval(displayframe, interval);
	startedstate();
}

/*  method to next display frame*/
function displayframe()
{
	currentframe = currentframe % frames.length;
	document.getElementById("txtArea").value = frames[currentframe];
	currentframe = currentframe + 1;
}
 /* called when stop button is pressed */
function stopAnimation()
{
	window.clearInterval(timer);
	timer = null;
	document.getElementById("txtArea").value = textboxContent;
	stopedstate();
}

/* enable/disable elements the way they should be at the time when animation is started*/
function startedstate()
{
	document.getElementById("start").disabled = true;
	document.getElementById("animationDropdown").disabled = true;
	document.getElementById("stop").disabled = false;
	
}
/* enable/disable elements the way they should be at the time when animation is stopped*/
function stopedstate()
{
	document.getElementById("start").disabled = false;
	document.getElementById("animationDropdown").disabled = false;
	document.getElementById("stop").disabled = true;

}


/* called when turbo check box is clicked*/
function turbo()
{
	if(document.getElementById("turbo").checked === true)
	{
		interval = 50;
	}
	else
	{
		interval = 250;
	}
	if(timer !== null)
	{
		window.clearInterval(timer);
		timer = window.setInterval(displayframe, interval);	
	}
	
}