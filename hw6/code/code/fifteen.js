"use strict";

window.onload = load;
var x_emptydiv;
var y_emptydiv;
//var rand;
var Case;

/* This event is raised Whenever any game piece is clicked */

function Clicked() {
 //alert("Clicked:" + this.id);
 //var CurrentPosition = document.getElementById('puzzlearea').getElementsByTagName('*');
 //positionInArray =0;
 //while(positionInArray < CurrentPosition.length)
 //{
 //if(CurrentPosition[positionInArray].id == this.id)
 //{
 //alert("loop broken at " + positionInArray);
 //break;
 //}
 //positionInArray++;
 //}
 //alert("loop broken at " + positionInArray);
	/* check if this can move one step forward */
 if ((parseInt(document.getElementById(this.id).style.left) + parseInt("100px") === parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) + parseInt("0px") === parseInt(y_emptydiv))) {
  //alert("move forward");
  document.getElementById("15").style.left = document.getElementById(this.id).style.left;
  document.getElementById("15").style.top = document.getElementById(this.id).style.top;
  document.getElementById(this.id).style.left = x_emptydiv;
  document.getElementById(this.id).style.top  = y_emptydiv;
  x_emptydiv = document.getElementById("15").style.left;
  y_emptydiv = document.getElementById("15").style.top;
 }
 /* check if this can move one step back */
	else if((parseInt(document.getElementById(this.id).style.left) - parseInt("100px") === parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) + parseInt("0px") === parseInt(y_emptydiv))) {
		//alert("move backward");
		document.getElementById("15").style.left = document.getElementById(this.id).style.left;
		document.getElementById("15").style.top = document.getElementById(this.id).style.top;
		document.getElementById(this.id).style.left = x_emptydiv;
		document.getElementById(this.id).style.top  = y_emptydiv;
		x_emptydiv = document.getElementById("15").style.left;
		y_emptydiv = document.getElementById("15").style.top;
	}
	/* check if this can move one step down */
	else if((parseInt(document.getElementById(this.id).style.left) + parseInt("0px") === parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) + parseInt("100px") === parseInt(y_emptydiv))) {
		//alert("move downward");
		document.getElementById("15").style.left = document.getElementById(this.id).style.left;
		document.getElementById("15").style.top = document.getElementById(this.id).style.top;
		document.getElementById(this.id).style.left = x_emptydiv;
		document.getElementById(this.id).style.top  = y_emptydiv;
		x_emptydiv = document.getElementById("15").style.left;
		y_emptydiv = document.getElementById("15").style.top;
	}
	/* check if this can move one step up */
	else if((parseInt(document.getElementById(this.id).style.left) + parseInt("0px") === parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) - parseInt("100px") === parseInt(y_emptydiv))) {
		//alert("move upward");
		document.getElementById("15").style.left = document.getElementById(this.id).style.left;
		document.getElementById("15").style.top = document.getElementById(this.id).style.top;
		document.getElementById(this.id).style.left = x_emptydiv;
		document.getElementById(this.id).style.top = y_emptydiv;
		x_emptydiv = document.getElementById("15").style.left;
		y_emptydiv = document.getElementById("15").style.top;
	}
	
	//this.style.top = parseInt(this.style.top) + parseInt("100px") + "px"; 
	//alert("loop broken at " + positionInArray);
	//alert(CurrentPosition.length);
	//alert(((parseInt(CurrentPosition[positionInArray - 4].style.top) - parseInt(CurrentPosition[positionInArray].style.top))));
}

/* called when mouseOver event is raised by any game piece*/

function mouseOver() {
	//this.className += " movablepiece";
	//alert("Over:" + this.id);
	if((parseInt(document.getElementById(this.id).style.left) + parseInt("100px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) + parseInt("0px") == parseInt(y_emptydiv)))
	{
		this.className += " movablepiece";
	}
	else if((parseInt(document.getElementById(this.id).style.left) - parseInt("100px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) + parseInt("0px") == parseInt(y_emptydiv)))
	{
		this.className += " movablepiece";
	}
	else if((parseInt(document.getElementById(this.id).style.left) + parseInt("0px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) + parseInt("100px") == parseInt(y_emptydiv)))
	{
		this.className += " movablepiece";
	}
	else if((parseInt(document.getElementById(this.id).style.left) + parseInt("0px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(this.id).style.top) - parseInt("100px") == parseInt(y_emptydiv)))
	{
		this.className += " movablepiece";
	}
	
}

/* is raised when mouse moves out of the game piece */

function mouseOut()
{
	this.className = this.className.replace("movablepiece",'');
	//alert("Out:" + this.id);
}


/* function called onload event of window */

function load(){
	//alert("hi");
	var x_pos = "0px";
	var y_pos = "0px";
	var x_size = "100px";
	var y_size = "100px";
	document.getElementById('shufflebutton').onclick = shuffle;
	/* get all element in puzzlearea div */
	var pieces = document.getElementById('puzzlearea').getElementsByTagName('*');
	
	/* attach css class and position to game pieces */
	for( var i = 0; i < pieces.length ; i++)
	{
		//alert("HI");
		pieces[i].className = "puzzlepiece";	
		//pieces[i].className = "movablepiece";
		pieces[i].id = i;
		pieces[i].onclick = Clicked;
		pieces[i].onmouseover = mouseOver;
		pieces[i].onmouseout =  mouseOut;
		if(((parseInt(x_size) * parseInt(i)) % 400) == "0")
		{
			pieces[i].style.left = "0px" ;
			x_pos = "0px";
			pieces[i].style.top = (( parseInt(y_size)) * (parseInt(i) / 4)) + "px";
			y_pos = (( parseInt(y_size)) * (parseInt(i) / 4)) + "px";
		}
		else
		{
			pieces[i].style.left = ((parseInt(x_size) * parseInt(i)) % 400) + "px";
			x_pos = ((parseInt(x_size) * parseInt(i)) % 400) + "px";
			pieces[i].style.top = y_pos;
		}
		//alert(x_pos + "," + y_pos);
		//alert((0 - parseInt(x_pos)) + "," + (0 - parseInt(y_pos)));
		pieces[i].style.backgroundPosition = (0 - parseInt(x_pos)) + "px " + (0 - parseInt(y_pos)) + "px"; 
		//pieces[i].style.backgroundPositionY = 0 - parseInt(y_pos) + "px";
	}
	
	/* add one more div for empty space */
	var element = document.createElement("div");
	element.appendChild(document.createTextNode(' '));
	document.getElementById('puzzlearea').appendChild(element);
	element.id = 15;
	//element.className = "puzzlepiece";
	//element.onclick = Clicked;
	element.style.left = "300px";
	element.style.top = "300px";
	//alert("ss");
	x_emptydiv = "300px";
	y_emptydiv = "300px";
}

/* is triggered when shuffle button is clicked */
function shuffle()
{
	document.getElementById('shufflebutton').disabled = true;
	//alert("hi");
	var counter =0;
	while(counter < 100)
	{
		randomize();
		counter++;
	}	
	//alert("done");
	//Case =5;
	document.getElementById('shufflebutton').disabled = false;
}

/* check if game piece with given id is movable piece*/
function isShiftable(id)
{
	if((parseInt(document.getElementById(parseInt(id)).style.left) + parseInt("100px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(parseInt(id)).style.top) + parseInt("0px") == parseInt(y_emptydiv)))
	{
		Case = 1; //is behind
	}
	else if((parseInt(document.getElementById(parseInt(id)).style.left) - parseInt("100px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(parseInt(id)).style.top) + parseInt("0px") == parseInt(y_emptydiv)))
	{
		Case  = 2;	// is in front
	}
	else if((parseInt(document.getElementById(parseInt(id)).style.left) + parseInt("0px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(parseInt(id)).style.top) + parseInt("100px") == parseInt(y_emptydiv)))
	{
		Case = 3;	// is upward
	}
	else if((parseInt(document.getElementById(parseInt(id)).style.left) + parseInt("0px") == parseInt(x_emptydiv)) && (parseInt(document.getElementById(parseInt(id)).style.top) - parseInt("100px") == parseInt(y_emptydiv)))
	{
		Case = 4;	// is downward
	}
	else
	{
		Case = 5; // cannot move
	}
}


/* randomly select one game piece out of all movable pieces */
function randomize()
{
	//alert("randomize");
	var rand =  [0,0];
	var id =0;
	var index =0;
	var r = 0;
	
	/* for current pieces position, which all are movable*/
	while(id < 15)
	{
		isShiftable(parseInt(id));
		if(parseInt(Case) != 5)
		{
			rand[index] = parseInt(id);
			index++;
		}
		id++;
	}
	
	/* randomly select one out of all possivble movable pieces*/
	
	if((parseInt(document.getElementById("15").style.left) == parseInt("0px")) && (parseInt(document.getElementById("15").style.top) == parseInt("0px")) )
	{
		//rand = [2,4];
		//alert("if 1:" + rand[0]+","+ rand[1]);
		var r = Math.floor((Math.random() * 2) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else if((parseInt(document.getElementById("15").style.left) == parseInt("300px")) && (parseInt(document.getElementById("15").style.top) == parseInt("300px")) )
	{
		//rand = [1,3];
		//alert("if 2:" +rand[0]+","+ rand[1]);
		r = Math.floor((Math.random() * 2) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else if((parseInt(document.getElementById("15").style.left) == parseInt("0px")) && (parseInt(document.getElementById("15").style.top) == parseInt("300px")) )
	{
		//rand = [2,3];
		//alert("if 3:" +rand[0]+","+ rand[1]);
		r = Math.floor((Math.random() * 2) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else if((parseInt(document.getElementById("15").style.left) == parseInt("300px")) && (parseInt(document.getElementById("15").style.top) == parseInt("0px")) )
	{
		//rand = [1,4];
		//alert("if 4:" +rand[0]+","+ rand[1]);
		r = Math.floor((Math.random() * 2) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else if((parseInt(document.getElementById("15").style.left) == parseInt("0px")))
	{
		//rand = [2,3,4];
		//alert("if 5:" +rand[0]+","+ rand[1]+","+rand[2]);
		r = Math.floor((Math.random() * 3) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else if((parseInt(document.getElementById("15").style.top) == parseInt("0px")) )
	{
		//rand = [1,2,4];
		//alert("if 6:" +rand[0]+","+ rand[1]+","+rand[2]);
		r = Math.floor((Math.random() * 3) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else if((parseInt(document.getElementById("15").style.left) == parseInt("300px")) )
	{
		//rand = [1,3,4];
		//alert("if 7:" +rand[0]+","+ rand[1]+","+rand[2]);
		r = Math.floor((Math.random() * 3) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else if((parseInt(document.getElementById("15").style.top) == parseInt("300px")) )
	{
		//rand = [1,2,3];
		//alert("if 8:" +rand[0]+","+ rand[1]+","+rand[2]);
		r = Math.floor((Math.random() * 3) + 1);
		shift(rand[parseInt(r)-1]);
	}
	else
	{
		//rand =[1,2,3,4];
		//alert("if 9:" +rand[0]+","+ rand[1]+","+rand[2]+ ","+ rand[3]);
		r = Math.floor((Math.random() * 4) + 1);
		shift(rand[parseInt(r)-1]);
	}
}

/* swap empty piece with the piece of given id */
function shift(id)
{
	//alert("shift: " + id);
	document.getElementById("15").style.left = document.getElementById(id).style.left;
	document.getElementById("15").style.top = document.getElementById(id).style.top;
	document.getElementById(id).style.left = x_emptydiv;
	document.getElementById(id).style.top = y_emptydiv;
	x_emptydiv = document.getElementById("15").style.left;
	y_emptydiv = document.getElementById("15").style.top;
}
