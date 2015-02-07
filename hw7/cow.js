/**
 * Created by Ravjot on 09/08/14.
 */
"use strict";
document.observe("dom:loaded",function ()
{
    $("btn_login").onclick = login;
});
function login()
{
    //alert($('txt_username').value);
    new Ajax.Request("cowLogin.php",
        {
           method:"POST",
           parameters:{
               name: $("txt_username").value,
               pass: $("txt_password").value
               },
           onSuccess: loginSuccessFun,
           onFailure: loginFailFun
        });
    //alert($('txt_username').value);
}

function populatelist(ajax)
{

    var results = JSON.parse(ajax.responseText);
    var div = document.createElement('div');
    div.id ="todoDiv";
    var list = document.createElement("ul");
    list.id ="todolist";

    div.appendChild(list);
    $('maincontent').appendChild(div);
    var i =0;
    results.each(function()
    {
        var element = document.createElement("li");
        element.innerHTML = results[i];
        element.id = "todolist_"+i;
        element.hide();
        element.appear();
        list.appendChild(element);
        i=i+1;
    });
    Sortable.create('todolist',{onUpdate: listUpdate});
}

function loginSuccessFun(ajax)
{
    if(ajax.responseText == "Login Failed")
    {
        $("login").shake();
        $("login").highlight();
        return;
    }
    //alert(responseText);
    var results = JSON.parse(ajax.responseText);
    //alert(result.hi[0].name);
    var para = document.createElement("p");
    para.innerHTML = $("txt_username").value + "'s To-Do List";
    $('maincontent').innerHTML = "";
    $('maincontent').appendChild(para);
    //alert(results[0]);
    populatelist(ajax);

    var txt = document.createElement('input');
    txt.type = 'text';
    txt.size = '30';
    txt.id ='txt_newtodo';
    $('maincontent').appendChild(txt);

    var btnAdd = document.createElement('input');
    btnAdd.type = 'button';
    btnAdd.value = 'Add to Bottom';
    btnAdd.id ='btnAdd';
    btnAdd.onclick = add;
    $('maincontent').appendChild(btnAdd);

    var btnDel = document.createElement('input');
    btnDel.type = 'button';
    btnDel.value = 'Delete Top Item';
    btnDel.id = 'btnDel';
    btnDel.onclick = del;
    $('maincontent').appendChild(btnDel);

    var logoutlist = document.createElement('ul');
    var logoutelement = document.createElement('li');
    var  logout = document.createElement('a');
    //logout.href ="cow.html";
    logout.href ="";
    logout.innerHTML = "Logout";
    logout.onclick = logoutfun;
    logoutelement.appendChild(logout);
    logoutlist.appendChild(logoutelement);
    $('maincontent').appendChild(logoutlist);
}

function logoutfun()
{

    new Ajax.Request("cowLogout.php",
        {
            method:"POST",
            parameters:{
                user: ""
            },
            onSuccess: logoutSuccessfun(),
            onFailure: loginFailFun
        });
}

function logoutSuccessfun(ajax)
{
    if(ajax.responseText === "Done")
    {
        window.location.href ="cow.html";
    }
}

function loginFailFun(ajax, exception)
{
    alert(ajax.responseText);
}

function add()
{
    if($('txt_newtodo').value == "")
    {
        $('txt_newtodo').highlight();
        return;
    }
    var element = document.createElement("li");
    element.innerHTML = $("txt_newtodo").value.escapeHTML();
    $("todolist").appendChild(element);
    element.hide();
    element.appear();
    //element.highlight();

    new Ajax.Request("cowGet.php",
        {
            method:"POST",
            parameters:{
                todo: $("txt_newtodo").value.escapeHTML()
            },
            onSuccess: add_todo,
            onFailure: loginFailFun
        });

    //alert("add");
}

function add_todo(ajax)
{
    //alert(ajax.response);

    /* to display from file in the server
    addtolist(ajax);
    */
    $('txt_newtodo').value ="";
    Sortable.create('todolist',{onUpdate: listUpdate});
}

function listUpdate(list)
{
    //alert("poo");
    list.shake();
    list.highlight();
    //$("todolist").shake();

    var itemsArray = [];
    var items = $('todolist').childNodes;
    var i=0;
    for(i=0; i<items.length; i++ )
    {
        //alert(items[i].innerHTML);
        itemsArray[i] = items[i].innerHTML;
    }
    add_todo();
    //alert("poo1");
    new Ajax.Request("cowUpdate.php",
        {
            method:"POST",
            parameters:{
                todo: JSON.stringify(itemsArray)
            },
            onSuccess: add_todo,
            onFailure: loginFailFun
        });
    //alert("poo2");

}

function addtolist(ajax)
{
    var results = JSON.parse(ajax.responseText);
    $('todoDiv').removeChild($("todolist"));
    var list = document.createElement("ul");
    list.id ="todolist";
    //Sortable.create("todolist");
    $('todoDiv').appendChild(list);
    var i =0;
    results.each(function()
    {
        var element = document.createElement("li");
        element.innerHTML = results[i];
        element.id = "todolist_"+i;
        list.appendChild(element);
        i=i+1;
    });
}

function del()
{
    var elements = $('todolist').childNodes;
    var element = elements[0];
    element.fade({duration: 3.0,
        afterFinish: funcall(element)
    });

    //document.removeChild(element);


    new Ajax.Request("cowLogin.php",
        {
            method:"POST",
            parameters:{
                todo: ""
            },
            onSuccess: del_todo,
            onFailure: loginFailFun
        });
    //alert("del");

}

function funcall(element)
{
    element.remove();
}

function del_todo(ajax)
{
    //alert("deleted");
    //addtolist(ajax);
    $('txt_newtodo').value ="";
}