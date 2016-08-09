/*Funcion para vista Moviles-Tablet/PC*/
function viewUpdate(){

	//Ancho de pantalla
    var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;	
    
    //Tablet/PC	   
    if(width >= 640){    	
    	addClass();
    	contOne();
    }
    //Moviles
    else{
    	removeClass();
    	contTwo();
    }
}

/*Funcion para agregar clases (Tablet/PC)*/
function addClass(){
	$("#secDiv").css("padding-top","10px");

	$("#rewBorder").removeClass("infoRewBorder");
	$("#divImgRew").removeClass("row").addClass("medium-7 large-7 columns");
	$("#secDiv").addClass("medium-5 large-5 columns");
	$("#row").addClass("row rowHeight");
	$("#divImgRew").removeClass("divRew").addClass("divInterRew");
	$("#pts").removeClass("small-push-8");
	$("#exInfo").removeClass("small-12 medium-8 medium-offset-2 large-6 large-offset-3").addClass("medium-12 large-12");
}

/*Función para remover clases (Moviles)*/
function removeClass(){			
	$("#secDiv").css("padding-top","");

	$("#rewBorder").addClass("infoRewBorder");
	$("#divImgRew").removeClass("medium-7 large-7 columns").addClass("row");
	$("#secDiv").removeClass("medium-5 large-5 columns");
	$("#row").removeClass("row rowHeight");
	$("#divImgRew").removeClass("divInterRew").addClass("divRew");
	$("#pts").addClass("small-push-8 ");
	$("#exInfo").removeClass("medium-12 large-12").addClass("small-12 medium-8 medium-offset-2 large-6 large-offset-3");
}

/* Función para copiar y remover contenedor descripción de recompensa y 
ubicarlo debajo de contenerdor de info comercio (Tablet-PC) */
function contOne(){
	/*Copiando e Inserción */
	var cln = document.getElementById("rewInfo").cloneNode(true);
	var insB = document.getElementById("eX");
	var parent = insB.parentNode;
		parent.insertBefore(cln,insB);

	/*Removiendo contenedor copiado*/
	var p = document.getElementById("secDiv");
	var c = document.getElementById("rewInfo");
		p.removeChild(c);
}

/*Función para insertar contenedor descripción de recompensa en Moviles*/
function contTwo(){

	var cln2 = document.getElementById("rewInfo").cloneNode(true);
	var insB2 = document.getElementById("divComm");
	var parent2 = insB2.parentNode;

	var p2 = document.getElementById("secDiv");
	var c2 = document.getElementById("rewInfo");

	    parent2.insertBefore(cln2,insB2);
	    p2.removeChild(c2);
}

$(window).load(viewUpdate);
$(window).resize(viewUpdate);