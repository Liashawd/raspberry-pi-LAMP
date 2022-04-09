var body = document.body,
    html = document.documentElement;

    var height = Math.max( body.scrollHeight, body.offsetHeight, 
                   html.clientHeight, html.scrollHeight, html.offsetHeight );

    //
    var isVisible = false;
    var prevState = isVisible;

    //
    var element = document.getElementById("footer");
    element.style.opacity = "0";


window.onscroll = function()
{

    if(element.getBoundingClientRect().top <= (window.innerHeight || document.documentElement.clientHeight))
    {
        isVisible = true;
        if(isVisible == true && prevState != isVisible){
            console.log("visible");
            element.style.opacity = "1";
            element.style.transition = "opacity 1.8s ease-out";
        }

    }
    else{
        isVisible = false;
        if(isVisible == false && prevState != isVisible)
        {
            console.log("not");
            element.style.opacity = "0";

        }

    }
    prevState = isVisible;
    //console.log(element.getBoundingClientRect().top.toString()+" rect bot");
    //console.log((window.innerHeight || document.documentElement.clientHeight).toString()+" compare");

}

//
//                 DROPDOWN
//



var showingMenu = false;
var menu = document.getElementById("menu");

//need menu visible to set variable
menu.style.display = "block";
let menuHeight = menu.clientHeight;
menu.style.height = "0px";



function dropToggle(){
    if(showingMenu)
    {
        //menu.style.display = "none";
	    menu.style.height = "0px";
        showingMenu = false;
    }
    else{
        //menu.style.display = "block";
	    menu.style.height = menuHeight+"px";
        showingMenu = true;
    }
    console.log(menuHeight);
}