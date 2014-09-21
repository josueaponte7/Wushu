function CargaPagina(url, titulo, parametros){
	DesMenEme();
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			document.getElementById("divDetContenido").innerHTML=XMLHR.responseText;
			document.getElementById("divTituloContenido").innerHTML=titulo
		}
	};
	XMLHR.open('POST', url, true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send(parametros);
}

function Logout(UsuAct,NomUsuAct){
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			
		}
	};
	XMLHR.open('POST', "modulos/logout.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("UsuAct="+UsuAct+"&NomUsuAct="+NomUsuAct);
}

function Login(url, parametros){
	var XMLHR = false;	
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function CarResLog(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			if (XMLHR.responseText == "Paso"){
				CargaPagina("modulos/mp.php", "Menú Principal","");
			}else if (XMLHR.responseText == "No Paso"){
				MensajeEmergente("Usuario o Clave incorrecto", "", "", 220, 650, "#F00");
			}else if (XMLHR.responseText == "NUEVO"){
				MensajeEmergente("Bienvenido, su cuenta aun no ha sido verificada, por tal razón no puede acceder al sistema.<br><br>Gracias por su atención.", "", "", 175, 415, "#00F");
			}else if (XMLHR.responseText == "RECHAZADO"){
				MensajeEmergente("Su cuenta fue rechazada, para mayor información por favor comunicarse con <a href='mailto:admin@admin.com' target='_blank'>admin@admin.com", "", "", 200, 415, "#FF0");
			}else if (XMLHR.responseText == "INACTIVO"){
				MensajeEmergente("Su cuenta fue desactivada, para mayor información por favor comunicarse con <a href='mailto:admin@admin.com' target='_blank'>admin@admin.com</a>", "", "", 200, 415, "#FF0");
			}
		}
	};

	
	XMLHR.open('POST', url, true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send(parametros);
}

function CargaBuscar(parametros){
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			document.getElementById("TabDetConBus").innerHTML=XMLHR.responseText;			
		}
	};
	XMLHR.open('POST', "modulos/buscar.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send(parametros);
}

function CargaBuscarSec(parametros){	
	var objBVS = document.getElementById("BusValorSec");
	//alert(objBVS.value);
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			document.getElementById("TabDetConBusSec").innerHTML=XMLHR.responseText;			
		}
	};
	XMLHR.open('POST', "modulos/buscarsec.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send(parametros+"&Sector="+objBVS.value);
}

function CargaBuscarRep(parametros){	
	var objBVR = document.getElementById("BusValorRep");
	//alert(objBVS.value);
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			document.getElementById("TabDetConBusRep").innerHTML=XMLHR.responseText;			
		}
	};
	XMLHR.open('POST', "modulos/buscarrep.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send(parametros+"&Descripcion="+objBVR.value);
}

function CargaWidTra(tiporespuesta, recibe, parametros){
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
			//alert(XMLHR.responseText);
			switch(tiporespuesta){
				case "Ninguna":
				break;
				case "innerHTML":
					try{document.getElementById(recibe).innerHTML=XMLHR.responseText;}
					catch(e){return;}
				break;
			}
		}
	};
	XMLHR.open('POST', "modulos/widtra.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send(parametros);
}

function EjecutaTrabajo(tiporespuesta, recibe, parametros){
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
			//alert (XMLHR.responseText);
			var Res = XMLHR.responseText;
			var ResM = Res.split(",");
			switch(tiporespuesta){
				case "Ninguna":
				break;
				case "innerHTML":
					document.getElementById(recibe).innerHTML=XMLHR.responseText;
				break;
				case "Mensaje":					
					//alert(Res[0]);
					//alert(Res[1]);
					if (ResM[0] != "OK"){
						MensajeEmergente("Debe completar los datos de este Formulario","Arriba",ResM[0],0,0,"#FF0");
					}else{						
						document.getElementById(recibe).value = ResM[0];
					}
				break;
				case "Valor":
					document.getElementById(recibe).value = ResM[1];					
				break;
				case "Resultado":
					document.getElementById(recibe).value = ResM[0];					
				break;
			}
		}
	};
	XMLHR.open('POST', "modulos/trabajo.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send(parametros);
}

function CargaSelect(selori,selrec,qry,ord,agrtod){
	var objSO = document.getElementById(selori);
	var objSR = document.getElementById(selrec);
	qry = qry + "'" + objSO.value + "'";
	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
			var Res = XMLHR.responseText;
			ResM = Res.split("-");
			var Valores = ResM[0].split(",");
			var Opciones = ResM[1].split(",");			
			var i = 0;			
			objSR.options.length = 0;
			objSR.options.add(new Option("Seleccione ...", ""));			
			if (agrtod == "Si"){objSR.options.add(new Option("TODOS", "0"));}			
			for(i = 0; i < Valores.length; i++) {
				objSR.options.add(new Option(Opciones[i], Valores[i]))
			}
		}
	};
	XMLHR.open('POST', "modulos/carsel.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("Qry="+qry+"&Ord="+ord);
}

function CargaFre(selori,selsec){
	var objSO = document.getElementById(selori);
	var objSS = document.getElementById(selsec);
	var objVI = document.getElementById("ValorIndiceW3");
	var objA = document.getElementById("AccionW3");
	
	if (objSO.value == ""){return false;}
	if (objSS.value == ""){return false;}
	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){			
			document.getElementById("divW3").innerHTML=XMLHR.responseText;
		}
	};
	XMLHR.open('POST', "modulos/carfre.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("Valor="+objSO.value+"&Sector="+objSS.value+"&ValorIndice="+objVI.value+"&Accion="+objA.value);
}

function CargaRep(NRegistro){	
	var objVI = document.getElementById("ValorIndiceW5");
	var objA = document.getElementById("AccionW5");	
	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){			
			document.getElementById("divW5").innerHTML=XMLHR.responseText;
		}
	};
	XMLHR.open('POST', "modulos/carrep.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NRegistro="+NRegistro+"&ValorIndice="+objVI.value+"&Accion="+objA.value);
}

function ActEstatusSolicitud(nregistro,nuevoestatus){	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			
		}
	};
	XMLHR.open('POST', "modulos/actestsol.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NRegistro="+nregistro+"&NueEst="+nuevoestatus);
}

function ActEstatusFrecuencia(nregfre,nregdes,und,am,pro){	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			
		}
	};
	XMLHR.open('POST', "modulos/actestfre.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NRegFre="+nregfre+"&NRegDes="+nregdes+"&Und="+und+"&AM="+am+"&Pro="+pro);
}

function ActEstatusUnidad(nregistro,nuevoestatus){	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			
		}
	};
	XMLHR.open('POST', "modulos/actestund.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NRegistro="+nregistro+"&NueEst="+nuevoestatus);
}

function VerProCom(recibe,nregistro){	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){			
			//alert(XMLHR.responseText);
			document.getElementById(recibe).value = XMLHR.responseText;
		}
	};
	XMLHR.open('POST', "modulos/verprocom.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NRegistro="+nregistro);
}

function BusPriPen(recibe,nregistro){	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			//alert(XMLHR.responseText);
			document.getElementById(recibe).value = XMLHR.responseText;
		}
	};
	XMLHR.open('POST', "modulos/buspripen.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NRegistro="+nregistro);
}

function BusSinPro(recibe,nregistro){	
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){			
			//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
			document.getElementById(recibe).value = XMLHR.responseText;
		}
	};
	XMLHR.open('POST', "modulos/bussinpro.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NRegistro="+nregistro);
}

function IP(){
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
			document.getElementById("ImpIP").value = XMLHR.responseText;			
		}
	};
	XMLHR.open('POST', "modulos/ip.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send();
}

function RevisaNumEnt(){
	try{
		//return;
		if (document.getElementById("W00").value == "" || document.getElementById("W00").value == "No Ready"){
			var XMLHR = false;
			XMLHR = new XMLHttpRequest();	
			XMLHR.onreadystatechange=function(){
				if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
					//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
					var VR = XMLHR.responseText;
					if (VR.length < 12){
						document.getElementById("W00").value = XMLHR.responseText;
						EstadisticasNumEnt(XMLHR.responseText);
					}			
				}
			};
			XMLHR.open('POST', "modulos/revisanument.php", true);
			XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			XMLHR.send("IP=" + document.getElementById("ImpIP").value);
		}
	}
	catch(e){}
}

function EstadisticasNumEnt(numero){
	try{
		if (!isNaN(numero)){
			if (numero != ""){
				var XMLHR = false;
				XMLHR = new XMLHttpRequest();	
				XMLHR.onreadystatechange=function(){
					if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
						//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
						//document.getElementById("ImpIP").value = XMLHR.responseText;
						MensajeEmergente(XMLHR.responseText,"Arriba","W00",0,0,"#F77");
					}
				};
				XMLHR.open('POST', "modulos/estadisticasnument.php", true);
				XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				XMLHR.send("Numero="+numero);
			}
		}
	}
	catch(e){}
}

function CambiarClave(NueCla){
	var XMLHR = false;
	XMLHR = new XMLHttpRequest();	
	XMLHR.onreadystatechange=function(){
		if (XMLHR.readyState==4 && (XMLHR.status==200 || window.location.href.indexOf("http")==-1)){
			//document.getElementById("divTitulo").innerHTML=XMLHR.responseText;
			//document.getElementById("ImpIP").value = XMLHR.responseText;			
		}
	};
	XMLHR.open('POST', "modulos/camcla.php", true);
	XMLHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	XMLHR.send("NueCla="+NueCla);
}