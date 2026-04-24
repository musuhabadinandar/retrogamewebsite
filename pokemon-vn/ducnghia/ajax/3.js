$.ajaxSetup({
    scriptCharset: "utf-8",
    contentType: "application/x-www-form-urlencoded; charset=iso-8859-1"
});
$.ajaxSetup({
    crossDomain: true,
    xhrFields: {
        withCredentials: true
    }
});
$(function () {
    $("#radio").buttonset();
    $("*#button").button();
});
var loading_img = '<br><br><img id="img_load" src="images/loader.gif">';
function att_equipados() { $('#tabs-1').load('acoes.php?l=balls'); }
function att_equipados_2() { $('#tabs-2').load('acoes.php?l=potions'); }
function att_equipados_3() { $('#tabs-3').load('acoes.php?l=items'); }
function att_equipados_4() { $('#tabs-4').load('acoes.php?l=spc_items'); }
function att_equipados_5() { $('#tabs-5').load('acoes.php?l=stones'); }
function att_equipados_6() { $('#tabs-6').load('acoes.php?l=attacks'); }
function att_equipados_7() { $('#tabs-7').load('acoes.php?l=loot'); }
function att_equipados_8() { $('#tabs-8').load('acoes.php?l=quest'); }
function att_equipados_9() { $('#tabs-9').load('acoes.php?l=mochila'); }
function att_equipados_10() { $('#tabs-10').load('acoes.php?l=shop'); }
