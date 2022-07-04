$(document).ready(function (){
	$("search").click(function() {
        $(this).addClass("close-search"); 
    });
    $("close-search").click(function() {
        $(this).addClass("search"); 
    });

});
