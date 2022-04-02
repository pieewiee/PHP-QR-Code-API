$("#wkssearch").change(function(){


if ($('#wkssearch').val().length > 5 )
{
loadFile("PHP/SearchCrip.php?name=" + $('#wkssearch').val(), Goto);
}
else{
$("#wkssearch").css("color", "#000000");
$("#wkssearch").css("border-color", "#007bff"); 
$("#wkssearch").css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(0, 123, 255, 0.6)"); 
}


});

$("#wkssearch").focusout(function(){
if ($('#wkssearch').val().length < 5 )
{
$("#wkssearch").css("color", "#000000");
$("#wkssearch").css("border-color", "#ced4da"); 
$("#wkssearch").css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 255, 255, 0.6)"); 
}
});

$("#wkssearch").focus(function(){
if ($('#wkssearch').val().length < 5 )
{
$("#wkssearch").css("color", "#000000");
$("#wkssearch").css("border-color", "#007bff"); 
$("#wkssearch").css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(0, 123, 255, 0.6)"); 
}

});

function Goto() { 
try {
$("#wkssearch").css("color", "#000000");
$("#wkssearch").css("border-color", "#00ff00"); 
$("#wkssearch").css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(0, 255, 0, 0.6)"); 
var myArr = JSON.parse(this.responseText);
var win = window.open("?file=" + myArr[0][0] + "&name=none&date=none#Getcrip", '_blank');
win.focus();
}
catch(err) {
//$('#wkssearch').val(err.message);
$("#wkssearch").css("color", "#ff0000"); 
$("#wkssearch").css("border-color", "#ff0000"); 
$("#wkssearch").css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)"); 
}
}