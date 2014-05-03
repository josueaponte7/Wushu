function ProcesaWidget(IDs,TipCams,CmpReqs,TW,Hacer,NRTT,WID,FID,Accion,Tabla,Indice,ValorIndice,Campos,NRegReg,objX,TipoRespuesta,Recibe){
	MensajeEmergente("Ejecutando","Izquierda",objX,0,0,"#F80");
	var objEje = document.getElementById(objX);
	objEje.style.visibility="hidden";	
	var ID = IDs.split(",");
	var TipCam = TipCams.split(",");
	
	if (Hacer == "Modificar" || Hacer == "Eliminar"){
		if (NRTT == ""){
			MensajeEmergente("Debe seleccionar un registro","Izquierda",objX,0,0,"#FF0");
			setTimeout(function(){DesMenEme();setTimeout(function(){objEje.style.visibility="visible";},300);},1000);
			return false;
		}
	}
	
	if (ValidaCamposWidget(IDs,TipCams,CmpReqs)){
		var Valores = "";		
		var i = 0; 
		for (i = 0; i <= (ID.length - 1); i++){	
			var strVal = document.getElementById(ID[i]).value;			
			var strVal = strVal.replace(/[^A-Za-z0-9\Ñ\ñ\-\:\,\.\s\n\@]/g," ");
						
			if (i == 0){				
				Valores = "'" + strVal + "'";
			}else{				
				Valores = Valores + ",'" + strVal + "'";
			}			
		}
		
		switch(Hacer){
			case "Verificar":
			break;
			case "Agregar":
				for (i = 0; i <= (ID.length - 1); i++){	
					document.getElementById(ID[i]).value = "";
				}
			break;
			case "Modificar":
				for (i = 0; i <= (ID.length - 1); i++){	
					document.getElementById(ID[i]).value = "";
				}
			break;
			case "Eliminar":
				for (i = 0; i <= (ID.length - 1); i++){	
					document.getElementById(ID[i]).value = "";
				}
			break;
		}
		
		
		
		CargaWidTra(TipoRespuesta, Recibe, "TW=" + TW + "&Hacer=" + Hacer + "&NRTT=" + NRTT + "&WID=" + WID + "&FID=" + FID + "&Accion=" + Accion + "&Tabla=" + Tabla + "&Indice=" + Indice + "&ValorIndice=" + ValorIndice + "&Campos=" + Campos + "&NRegReg=" + NRegReg + "&Valores=" + Valores);		
		
		//MensajeEmergente("Hecho","Izquierda",objX,0,0,"#0F0");
		setTimeout(
		function(){
				DesMenEme();
				setTimeout(
				function(){
					objEje.style.visibility="visible";
					document.getElementById("ImgOpc9F").style.visibility="visible";
				},300);
		},500);		
		return true;
	}else{
		objEje.style.visibility="visible";
		return false;
	}
	
	
	for (i = 0; i <= (TipCam.length - 1); i++){
		switch(TipCam[i]){
			case "int4": 
				document.getElementById(ID[i]).value = Formato_Numero(document.getElementById(ID[i]).value, 0, ",", ".");					
			break;
			case "float8": 
				document.getElementById(ID[i]).value = Formato_Numero(document.getElementById(ID[i]).value, 2, ",", ".");
			break;
		}			
	}
}

function ValidaCamposWidget(IDs,TipCams,CmpReqs){
	var ID = IDs.split(",");
	var TC = TipCams.split(",");
	var CR = CmpReqs.split(",");
	var i = 0; 
	for (i = 0; i <= (ID.length - 1); i++){	
		if(!ValCam(ID[i],TC[i],"Abajo",CR[i])){return false;}		
	}
	return true;
}

function HacerVisibleID(ID){
	alert(ID);
	document.getElementById(ID).scrollIntoView(true);
}

function AutoCargaLista(WID,RitAct,AD){
	if (AD == "A"){
		//document.getElementById("ImgAA"+WID).style.visibility="hidden";
		//document.getElementById("ImgDA"+WID).style.visibility="visible";		
		try{				
			TACL = setInterval(
					function(){
						CargaWidTra("innerHTML", "div"+WID, "TW=Lista&WID=" + WID + "&Accion=Dinamico&ValorIndice=" + document.getElementById("ValorIndice"+WID).value);
						//document.getElementById("ImgAA"+WID).style.visibility="hidden";
						//document.getElementById("ImgDA"+WID).style.visibility="visible";
						//if (document.getElementById(WID+"TRS").value != ""){
							//document.getElementById(document.getElementById(WID+"TRS").value).scrollIntoView(true);
						//}
					},RitAct
				);
		}
		catch(e){}
	}else{
		//document.getElementById("ImgAA"+WID).style.visibility="visible";
		//document.getElementById("ImgDA"+WID).style.visibility="hidden";
		try{
			clearInterval(TACL);
		}
		catch(e){}
	}
}

function AutoCargaListaSO(WID,RitAct,AD){		
	if (AD == "A"){
		document.getElementById("ImgAASO"+WID).style.visibility="hidden";
		document.getElementById("ImgDASO"+WID).style.visibility="visible";		
		TACL = setInterval(
				function(){					
					CargaWidTra("innerHTML", "div"+WID, "TW=Lista&WID=" + WID + "&Accion=Dinamico");
					document.getElementById("ImgAASO"+WID).style.visibility="hidden";
					document.getElementById("ImgDASO"+WID).style.visibility="visible";					
				},RitAct
			);
	}else{
		document.getElementById("ImgAASO"+WID).style.visibility="visible";
		document.getElementById("ImgDASO"+WID).style.visibility="hidden";
		clearInterval(TACL);
	}
}

function AgregarFiltro(){
	if(!ValCam("BusCampos","combo","Abajo","s")){return false;}
	if(!ValCam("BusCompa","combo","Abajo","s")){return false;}
	if(!ValCam("BusValor","varchar","Abajo","s")){return false;}	
	
	var objBC = document.getElementById("BusCampos");
	var objBCO = document.getElementById("BusCompa");
	var objBV = document.getElementById("BusValor");
	
	CargaBuscar("Hacer=Agregar&Cam=" + objBC.value + "&Com=" + objBCO.value + "&Val=" + objBV.value);
	
	objBC.options[0].selected = true;
	objBCO.options[0].selected = true;
	objBV.value = "";	
}

var x = 0;
var Temporizador;

function BorBuscar(IDM, Modulo, Titulo){	
	CargaBuscar("Hacer=EliminarTodo");
	CargaPagina("modulos/" + Modulo,Titulo,"idm=" + IDM + "&mod=" + Modulo + "&tit=" + Titulo);	
}

function IniBuscar(Titulos, Campos, IDM, Modulo, Titulo){	
	var objIDMAct = document.getElementById("IDMAct");
	var objModAct = document.getElementById("ModAct");
	var objTitAct = document.getElementById("TitAct");	
	
	var objSel = document.getElementById("BusCampos");
	var MatTitulos = Titulos.split(",");
	var MatCampos = Campos.split(",");
	
	objIDMAct.value = IDM;
	objModAct.value = Modulo;
	objTitAct.value = Titulo;
	
	objSel.options.length = 0;
	opcion = new Option("...","","defauldSelected");
	objSel.options[0] = opcion;	
	var i = 0; 
	for (i = 0; i <=( MatTitulos.length - 1); i++){
		opcion = new Option(MatTitulos[i],MatCampos[i]);
		objSel.options[(i + 1)] = opcion;
	}
	
	CargaBuscar("Hacer=Consulta");
		
	document.getElementById("Buscar").style.left = "10%";
	document.getElementById("Buscar").style.top = "25%";
	document.getElementById("SobreTodo").style.left = "0%";
	document.getElementById("SobreTodo").style.top = "0%";
	
	Temporizador = setInterval("BuscarApa()",1);
}

function FinBuscar(){	
	var objIDMAct = document.getElementById("IDMAct");
	var objModAct = document.getElementById("ModAct");
	var objTitAct = document.getElementById("TitAct");	
	
	var IDM = objIDMAct.value;
	var Modulo = objModAct.value;
	var Titulo = objTitAct.value;
	
	Temporizador = setInterval("BuscarDes()",1);
	CargaPagina("modulos/" + Modulo,Titulo,"idm=" + IDM + "&mod=" + Modulo + "&tit=" + Titulo);
}

function BuscarApa(){
	x += 10;
	var objBus = document.getElementById("Buscar");
	var objST = document.getElementById("SobreTodo");
	objBus.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x > 100){clearInterval(Temporizador); x = 100;}
}

function BuscarDes(){	
	x -= 10;
	var objBus = document.getElementById("Buscar");
	var objST = document.getElementById("SobreTodo");
	objBus.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x < 0){
		clearInterval(Temporizador);
		x = 0;
		document.getElementById("Buscar").style.left = '-100%';
		document.getElementById("Buscar").style.top = '-100%';
		document.getElementById("SobreTodo").style.left='-100%';
		document.getElementById("SobreTodo").style.top='-100%';
	}	
}

function IniBuscarRep(Titulos, Campos, IDM, Modulo, Titulo){	
	CargaBuscarRep("Hacer=Consulta");		
	document.getElementById("BuscarRep").style.left = "10%";
	document.getElementById("BuscarRep").style.top = "25%";
	document.getElementById("SobreTodo").style.left = "0%";
	document.getElementById("SobreTodo").style.top = "0%";	
	Temporizador = setInterval("BuscarApaRep()",1);
}

function FinBuscarRep(){	
	Temporizador = setInterval("BuscarDesRep()",1);
}

function BuscarApaRep(){
	x += 10;
	var objBus = document.getElementById("BuscarRep");
	var objST = document.getElementById("SobreTodo");
	objBus.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x > 100){clearInterval(Temporizador); x = 100;}
}

function BuscarDesRep(){	
	x -= 10;
	var objBus = document.getElementById("BuscarRep");
	var objST = document.getElementById("SobreTodo");
	objBus.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x < 0){
		clearInterval(Temporizador);
		x = 0;
		document.getElementById("BuscarRep").style.left = '-100%';
		document.getElementById("BuscarRep").style.top = '-100%';
		document.getElementById("SobreTodo").style.left='-100%';
		document.getElementById("SobreTodo").style.top='-100%';
	}	
}

function CargaCDODEMPS(NRegistro,Categoria,Descripcion,Observaciones,Direccion,Estado,Municipio,Parroquia,Sector){
	document.getElementById("W02").value = Categoria;
	CargaSelect('W02','W03','SELECT NRegistro,Descripcion FROM detmotivos WHERE NRegMot=','Descripcion',"No");
	setTimeout(PCDM,150);
	function PCDM(){
		document.getElementById("W03").value = Descripcion;
	}
	
	document.getElementById("W04").value = Observaciones;
	document.getElementById("W05").value = Direccion;
	
	document.getElementById("W06").value = Estado;
	CargaSelect('W06','W07','SELECT NRegistro,Nombre FROM municipios WHERE NRegEst=','Nombre',"Si");
	setTimeout(PCM,150);
	function PCM(){
		document.getElementById("W07").value = Municipio;
		CargaSelect('W07','W08','SELECT NRegistro,Nombre FROM parroquias WHERE NRegMun=','Nombre','Si');
		setTimeout(PCP,150);
		function PCP(){
			document.getElementById("W08").value = Parroquia;
			CargaSelect('W08','W09','SELECT NRegistro,Nombre FROM sectores WHERE NRegPar=','Nombre','Si');
			setTimeout(PCS,150);
			function PCS(){
				document.getElementById("W09").value = Sector;
				CargaFre("W03","W09");
			}
		}
	}	
	FinBuscarRep();
	CargaRep(NRegistro);
}

function CargaEMPS(Estado,Municipio,Parroquia,Sector){
	document.getElementById("W06").value = Estado;
	CargaSelect('W06','W07','SELECT NRegistro,Nombre FROM municipios WHERE NRegEst=','Nombre',"Si");
	setTimeout(PCM,150);
	function PCM(){
		document.getElementById("W07").value = Municipio;
		CargaSelect('W07','W08','SELECT NRegistro,Nombre FROM parroquias WHERE NRegMun=','Nombre','Si');
		setTimeout(PCP,150);
		function PCP(){
			document.getElementById("W08").value = Parroquia;
			CargaSelect('W08','W09','SELECT NRegistro,Nombre FROM sectores WHERE NRegPar=','Nombre','Si');
			setTimeout(PCS,150);
			function PCS(){
				document.getElementById("W09").value = Sector;
				CargaFre("W03","W09");
			}
		}
	}	
	FinBuscarSec();
}

function IniBuscarSec(Titulos, Campos, IDM, Modulo, Titulo){	
	CargaBuscarSec("Hacer=Consulta");		
	document.getElementById("BuscarSec").style.left = "10%";
	document.getElementById("BuscarSec").style.top = "25%";
	document.getElementById("SobreTodo").style.left = "0%";
	document.getElementById("SobreTodo").style.top = "0%";	
	Temporizador = setInterval("BuscarApaSec()",1);
}

function FinBuscarSec(){	
	Temporizador = setInterval("BuscarDesSec()",1);
}

function BuscarApaSec(){
	x += 10;
	var objBus = document.getElementById("BuscarSec");
	var objST = document.getElementById("SobreTodo");
	objBus.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x > 100){clearInterval(Temporizador); x = 100;}
}

function BuscarDesSec(){	
	x -= 10;
	var objBus = document.getElementById("BuscarSec");
	var objST = document.getElementById("SobreTodo");
	objBus.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x < 0){
		clearInterval(Temporizador);
		x = 0;
		document.getElementById("BuscarSec").style.left = '-100%';
		document.getElementById("BuscarSec").style.top = '-100%';
		document.getElementById("SobreTodo").style.left='-100%';
		document.getElementById("SobreTodo").style.top='-100%';
	}	
}

function IniExportar(Query, TitCam, Titulo, Usuario){
	document.getElementById("QueryExp").value = Query;
	document.getElementById("TitCamExp").value = TitCam;
	document.getElementById("TituloExp").value = Titulo;
	document.getElementById("UsuarioExp").value = Usuario;
	
	document.getElementById("Exportar").style.left = "35%";
	document.getElementById("Exportar").style.top = "30%";
	document.getElementById("SobreTodo").style.left = "0%";
	document.getElementById("SobreTodo").style.top = "0%";
	
	Temporizador = setInterval("ExportarApa()",1);
}

function FinExportar(){	
	Temporizador = setInterval("ExportarDes()",1);	
}

function ExportarApa(){
	x += 10;
	var objEx = document.getElementById("Exportar");
	var objST = document.getElementById("SobreTodo");
	objEx.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x > 100){clearInterval(Temporizador); x = 100;}
}

function ExportarDes(){	
	x -= 10;
	var objEx = document.getElementById("Exportar");
	var objST = document.getElementById("SobreTodo");
	objEx.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x < 0){
		clearInterval(Temporizador);
		x = 0;
		document.getElementById("Exportar").style.left = '-100%';
		document.getElementById("Exportar").style.top = '-100%';
		document.getElementById("SobreTodo").style.left='-100%';
		document.getElementById("SobreTodo").style.top='-100%';
	}	
}

function IniImprimir(Query, TitCam, Titulo, Usuario, TipPap, OriPap, LisAncCol){	
	document.getElementById("QueryImp").value = Query;
	document.getElementById("TitCamImp").value = TitCam;
	document.getElementById("TituloImp").value = Titulo;
	document.getElementById("UsuarioImp").value = Usuario;
	document.getElementById("TipPapImp").value = TipPap;
	document.getElementById("OriPapImp").value = OriPap;
	document.getElementById("LisAncCol").value = LisAncCol;
	
	document.getElementById("Imprimir").style.left = "35%";
	document.getElementById("Imprimir").style.top = "30%";
	document.getElementById("SobreTodo").style.left = "0%";
	document.getElementById("SobreTodo").style.top = "0%";
	
	Temporizador = setInterval("ImprimirApa()",1);
}

function FinImprimir(){	
	Temporizador = setInterval("ImprimirDes()",1);	
}

function ImprimirApa(){
	x += 10;
	var objEx = document.getElementById("Imprimir");
	var objST = document.getElementById("SobreTodo");
	objEx.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x > 100){clearInterval(Temporizador); x = 100;}
}

function ImprimirDes(){	
	x -= 10;
	var objEx = document.getElementById("Imprimir");
	var objST = document.getElementById("SobreTodo");
	objEx.style.opacity = x / 100;
	objST.style.opacity = x / 2 / 100;
	if (x < 0){
		clearInterval(Temporizador);
		x = 0;
		document.getElementById("Imprimir").style.left = '-100%';
		document.getElementById("Imprimir").style.top = '-100%';
		document.getElementById("SobreTodo").style.left='-100%';
		document.getElementById("SobreTodo").style.top='-100%';
	}	
}

function CambiarImagen(ID,NomNueIma){
	try{
		var objIMG = document.getElementById(ID);
		objIMG.src = NomNueIma;
	}
	catch(err){}
}

function Ingresar(){
	if(!ValCam("Usuario","varchar","Derecha","s")){return false;}
	if(!ValCam("Clave","varchar","Derecha","s")){return false;}
	var Usu = document.getElementById("Usuario").value;
	var Cla = document.getElementById("Clave").value;	
	Login("modulos/login.php","Funcion=Login&Usuario="+Usu+"&Clave="+Cla);
	IP();
}

function CamCla(){
	if(!ValCam("Usuario","varchar","Derecha","s")){return false;}
	if(!ValCam("Clave","varchar","Derecha","s")){return false;}
	var Usu = document.getElementById("Usuario").value;
	var Cla = document.getElementById("Clave").value;	
	
	if (Usu != Cla){
		MensajeEmergente("Las claves no son iguales<br />","Arriba","Usuario",0,0,"#F00");
	}else{
		CambiarClave(Cla);
		MensajeEmergente("El cambio fue realizado<br />","Arriba","Usuario",0,0,"#0F0");
		CargaPagina('modulos/mp.php', 'Menú Principal','');		
	}	
}


//var objC = document.getElementById("PJS");
//objC.innerHTML = objME.style.top;

var time;
var transparency = 0;

function MensajeEmergente(Mensaje, PosMen, objX, TopME, LefME, Color){	
	var MenHTML = "";	
	var objME = document.getElementById("divME");
	//objME.style.border="2px solid " + Color;
	objME.style.border="2px inset " + Color;	
		
	if (objX != ""){
		var Pos = document.getElementById(objX).getBoundingClientRect();
		var Ancho = Pos.right - Pos.left;
		var Alto = Pos.bottom - Pos.top;
	}
		
	var TopMen = 0;
	var LefMen = 0;	
	
	switch (PosMen){
		case "":
			objME.innerHTML = Mensaje;
			
			//objME.style.top = TopME+"px";
			//objME.style.left = LefME+"px";			
		break;
		case "Arriba":
			objME.innerHTML = Mensaje + "<br />" + "<img src='img/fab.png' height='16px' width='16px' />";
			
			var Pos2 = document.getElementById("divME").getBoundingClientRect();
			var Ancho2 = Pos2.right - Pos2.left;
			var Alto2 = Pos2.bottom - Pos2.top;
			
			TopMen = Pos.top - Alto2 - 5;
			LefMen = (Pos.left+(Ancho/2));
			LefMen = LefMen - (Ancho2/2);
			//objME.style.top = TopMen+"px";
			//objME.style.left = LefMen+"px";			
		break;
		case "Abajo":
			objME.innerHTML = "<img src='img/far.png' height='16px' width='16px' />" + "<br />" + Mensaje;
			
			var Pos2 = document.getElementById("divME").getBoundingClientRect();
			var Ancho2 = Pos2.right - Pos2.left;
			var Alto2 = Pos2.bottom - Pos2.top;
			
			TopMen = Pos.top + Alto + 5;
			LefMen = (Pos.left+(Ancho/2));
			LefMen = LefMen - (Ancho2/2);
			//objME.style.top = TopMen+"px";
			//objME.style.left = LefMen+"px";			
		break;
		case "Derecha":
			objME.innerHTML = "<img src='img/fiz.png' align='absmiddle' height='16px' width='16px' />&nbsp;&nbsp;" + Mensaje;
			
			var Pos2 = document.getElementById("divME").getBoundingClientRect();
			var Ancho2 = Pos2.right - Pos2.left;
			var Alto2 = Pos2.bottom - Pos2.top;
			
			TopMen = (Pos.top+(Alto/2));
			TopMen = TopMen - (Alto2/2);
			LefMen = Pos.left+Ancho+5;
			//objME.style.top = TopMen+"px";
			//objME.style.left = LefMen+"px";			
		break;
		case "Izquierda":
			objME.innerHTML = Mensaje + "&nbsp;&nbsp;<img src='img/fde.png' align='absmiddle' height='16px' width='16px' /> ";

			var Pos2 = document.getElementById("divME").getBoundingClientRect();
			var Ancho2 = Pos2.right - Pos2.left;
			var Alto2 = Pos2.bottom - Pos2.top;
		
			TopMen = (Pos.top+(Alto/2));
			TopMen = TopMen - (Alto2/2);
			LefMen = Pos.left-Ancho2-5;
			//objME.style.top = TopMen+"px";
			//objME.style.left = LefMen+"px";			
		break;
	}
		
	if (PosMen == ""){
		objME.style.top = TopME+"px";
		objME.style.left = LefME+"px";
	}else{
		objME.style.top = TopMen+"px";
		objME.style.left = LefMen+"px";
	}
	//objME.innerHTML = MenHTML;
	
	clearInterval(time);
	transparency = 1;	
	time = setInterval(function(){fadeIn(objME);},25);
}

function DesMenEme(){
	var obj = document.getElementById("divME");	
		
	clearInterval(time);
	transparency = 91;	
	time = setInterval(function(){fadeOut(obj);},25);	
}

function fadeIn(obj){	
	transparency += 10; 
	if (transparency > 90){clearInterval(time);transparency = 91;}
	obj.style.opacity = transparency / 100;	
}

function fadeOut(obj){	
	transparency -= 10; 
	if (transparency < 2){
		clearInterval(time);
		transparency = 1; 
		obj.style.left="-100%";
		obj.style.top="-100%";
	}
	obj.style.opacity = transparency / 100; 
}


function ValCam(objX,tipoX,PosMen,CamReq){
	var obj = document.getElementById(objX);	
	var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
	var filter2B=/^[A-Za-z]*-[0-9]/;
	var filter2=/^[0-9]/;	
	var filter3=/^[A-Za-z]/;
	var filter4=/^[0-9]$/;
	var filter5=/^([0-2]\d):([0-5]\d):([0-5]\d)$/;
	var filter6=/^[0-9]{2}-[0-9]{2}/;
	var filter7=/^[0-9]{1,3},[0-9]{3}/;
	
	if (CamReq != "s" && obj.value == ""){obj.style.border = "1px solid #7f9db9"; return true;}
	
	switch (tipoX) {
		case 'combo':			
			if (obj.value!=""){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Debe selecionar un valor");
				MensajeEmergente("Debe selecionar un valor",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'varchar':			
			if (obj.value!=""){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Debe ingresar un valor");
				MensajeEmergente("Debe ingresar un valor",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'rngeda':
			if (filter6.test(obj.value)){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Ingrese solo letras");
				MensajeEmergente("Ingrese un rango de edad valido Ejemplo: 09-14",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'peso':
			if (filter7.test(obj.value)){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Ingrese solo letras");
				MensajeEmergente("Ingrese un valido Ejemplo: 123,456",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'sollet':
			if (filter3.test(obj.value)){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Ingrese solo letras");
				MensajeEmergente("Ingrese solo letras",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'solnum':
			if (!isNaN(obj.value)){
				if (obj.value != ""){
					obj.style.border = "1px solid #7f9db9";
					return true;
				}else{
					MensajeEmergente("Ingrese solo numeros",PosMen,objX,0,0,"#F00");
					obj.style.border = "1px solid #FF0000";
					return false;
				}				
			}else{
				//alert("Ingrese solo numeros");
				MensajeEmergente("Ingrese solo numeros",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
				
		case 'email':
			if (filter.test(obj.value)){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Ingrese una dirección de correo válida");
				MensajeEmergente("Ingrese una dirección de correo válida",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'cedrif':
			if (filter2.test(obj.value)){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Ingrese una Cedula o RIF válido Ejemplo: V-00000000 o J-00000000-0");
				MensajeEmergente("Ingrese una Cedula válida Ejemplo: 00000000",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'rif':
			if (filter2B.test(obj.value)){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Ingrese una Cedula o RIF válido Ejemplo: V-00000000 o J-00000000-0");
				MensajeEmergente("Ingrese un RIF válido Ejemplo: J-00000000-0",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		
		case 'int4':					
			if (isNaN(parseInt(obj.value))){
				//alert('Ingrese solo números enteros');
				MensajeEmergente("Ingrese solo números enteros",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}else{				
				//obj.value = parseInt(obj.value);				
				var TF = obj.value
				TF = TF.replace(".","");
				TF = TF.replace(",",".");				
				obj.value = TF;
				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}
		break;
		
		case 'date':
			if (!isDate(obj.value)){
				MensajeEmergente("Por favor Ingrese la fecha <br /> con formato dd-mm-yyyy",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}else{
				obj.style.border = "1px solid #7f9db9";
				return true;
			}
		break;
		
		case 'time':
			if (filter5.test(obj.value)){				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				//alert("Ingrese solo letras");
				MensajeEmergente("Ingrese solo hora valida hh:mm:ss",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}
		break;
		
		case 'float8':			
			if (isNaN(parseFloat(obj.value))){
				//alert('Ingrese solo números');
				MensajeEmergente("Ingrese solo números",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}else{
				//obj.value = parseFloat(obj.value);
				var TF = obj.value
				TF = TF.replace(".","");
				TF = TF.replace(",",".");				
				obj.value = TF;
				
				obj.style.border = "1px solid #7f9db9";
				return true;
			}
		break;
		
		case 'bool':
			if ((obj.value!='1') && (obj.value!='0')){
				//alert('Ingrese solo Si o No');
				MensajeEmergente("Ingrese solo Si o No",PosMen,objX,0,0,"#F00");
				obj.style.border = "1px solid #FF0000";
				return false;
			}else{
				obj.style.border = "1px solid #7f9db9";
				return true;
			}
		break;
		
		default:			
			return true;
		break;			
	}	
}

function isDate(dateStr) {

var datePat = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
var matchArray = dateStr.match(datePat); // is the format ok?

	if (matchArray == null) {
		//alert('Por favor Ingrese la fecha con formato dd-mm-yyyy');
		return false;
	}
	
	month = matchArray[3]; // p@rse date into variables
	day = matchArray[1];
	year = matchArray[5];
	
	if (day < 1 || day > 31) {
		alert('Los días deben estar entre 1 y 31');
		return false;
	}

	if (month < 1 || month > 12) { // check month range
		alert('Los meses deben estar entre 1 y 12');
		return false;
	}

	if ((month==4 || month==6 || month==9 || month==11) && day==31) {
		alert('El mes '+month+' no tiene 31 días')
		return false;
	}

	if (month == 2) { // check for february 29th
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day > 29 || (day==29 && !isleap)) {
			alert('Febrero ' + year + ' no tiene ' + day + ' días');
			return false;
		}
	}
	return true; // date is valid
}

function Formato_Numero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    numero=parseFloat(numero);
    if(isNaN(numero)){return "";}
    if(decimales!==undefined){numero=numero.toFixed(decimales);}
    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}