<?php

session_start();
date_default_timezone_set('America/Caracas');
require_once '../../modelo/Conexion.php';
$obj_conexion = new Conexion();

require_once './tcpdf/spa.php';
require_once './tcpdf/MyClass.php';

$sql = "SELECT CONCAT_WS('-', atl.nacionalidad, atl.cedula) AS cedula, 
                    atl.nombre, 
                    DATE_FORMAT(atl.fechnac,'%d/%m/%Y') AS fecha,
                    atl.sexo,
                    atl.peso,
                    aso.nombre AS asociacion
                 FROM atletas atl 
                 INNER JOIN asociaciones  aso ON atl.id_asociacion = aso.id_asociacion 
                    ORDER BY atl.cedula;";

$resultado = $obj_conexion->RetornarRegistros($sql);

//$total     = $obj->totalFilas('sociaciones AS a', 'a.nombre',$campos['condicion']);

$pdf = new MyClass("L", "mm", "A4", true, 'UTF-8', false);

// Mostrar Cabecera de titulo en las hojas
$pdf->setPrintHeader(true);
// salto de linea
$pdf->Ln(50);
// Mostrar Cabecera de footer en las hoja
$pdf->setPrintFooter(true);
// mostrar numero de paginas
$pdf->SetAutoPageBreak(true);
//setear margenes 
$pdf->SetMargins(15, 20, 15);
// añadimos la pagina
$pdf->AddPage();

/* * ******Imagen del logo en la primera hoja********* */
$pdf->Image('imagenes/logoinicio.png', 3, 18, 45, 15, 'PNG', FALSE);


// titulo del listado
$titulo = "LISTADO DE ATLETAS";
$pdf->Ln(5);
//mover titulo
$pdf->SetX(80);
// fuente y tamaño de letra 
$pdf->SetFont('FreeSerif', 'B', 14);
// añadimos el titulo
$pdf->Cell(90, 0, $titulo, 0, 0, 'C', 0);
$pdf->Ln(15);

/* * ********************************** */

$j            = 0;
// Cantidad maxima de registros a mostrar por pagina
$max          = 35;
$row_height   = 6;
$backup_group = "";


// width de las filas 

$w_cedula     = 40;
$w_nombre     = 50;
$w_fecha      = 45;
$w_sexo       = 30;
$w_peso       = 30;
$w_asociacion = 50;

// Mover a la derecha 
$pdf->SetX(25);

// Color Cabecera de la tabla
$pdf->SetFillColor(222, 222, 222);


// Titulos de la Cabecera
$pdf->Cell($w_cedula, $row_height, 'Cédula', 1, 0, 'C', 1);
$pdf->Cell($w_nombre, $row_height, 'Nombres', 1, 0, 'L', 1);
$pdf->Cell($w_fecha, $row_height, 'Fecha Nacimiento', 1, 0, 'L', 1);
$pdf->Cell($w_sexo, $row_height, 'Sexo', 1, 0, 'L', 1);
$pdf->Cell($w_peso, $row_height, 'Peso', 1, 0, 'L', 1);
$pdf->Cell($w_asociacion, $row_height, 'Asociación', 1, 1, 'L', 1);


// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    // Asignarle variables a los registros
    $cedula     = $resultado[$i]['cedula'];
    $nombre     = $resultado[$i]['nombre'];
    $fecha      = $resultado[$i]['fecha'];
    $sexo       = $resultado[$i]['sexo'];
    $peso       = $resultado[$i]['peso'];
    $asociacion = $resultado[$i]['asociacion'];

    // verificar que la variable $j no si es mayor se hace un salto de pagina
    if ($j > $max) {
        $pdf->AddPage();

        // color de la letra
        $pdf->SetFillColor(255, 255, 255);

        // salto de linea
        $pdf->Ln(15);
        /*         * ****Imagen del logo de las hojas que continua***** */
        $pdf->Image('imagenes/logoinicio.png', 3, 18, 45, 15, 'PNG', FALSE);
        // Tipo de letra negrita tamaño 14
        $pdf->SetFont('FreeSerif', 'B', 14);

        $pdf->SetX(80);
        // Titulo del Reporte width:90 heigth:0 text:$titulo alineacion:C
        $pdf->Cell(90, 0, $titulo, 0, 0, 'C', 0);
        $pdf->Ln(15);

        // Color Cabecera de la tabla
//        $pdf->SetFillColor(39, 129, 213);
        $pdf->SetFillColor(222, 222, 222);

        $pdf->SetX(25);
        $pdf->Cell($w_cedula, $row_height, 'Cédula', 1, 0, 'C', 1);
        $pdf->Cell($w_nombre, $row_height, 'Nombres', 1, 0, 'L', 1);
        $pdf->Cell($w_fecha, $row_height, 'Fecha Nacimiento', 1, 0, 'L', 1);
        $pdf->Cell($w_sexo, $row_height, 'Sexo', 1, 0, 'L', 1);
        $pdf->Cell($w_peso, $row_height, 'Peso', 1, 0, 'L', 1);
        $pdf->Cell($w_asociacion, $row_height, 'Asociación', 1, 1, 'L', 1);

        $j = 0;
    }

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('FreeSerif', '', 12);
    if ($i % 2 != 0) {
        $pdf->SetFillColor(0, 213, 198);
    }

    /* $pdf->SetTextColor(0, 0, 0);
      if ($id == 20 || $id == 40 || $id == 60) {
      $pdf->SetTextColor(255, 0, 0);
      } */

    // crear los registros a mostrar
    $pdf->SetFont('FreeSerif', '', 12);
    
    $pdf->SetX(25);
    $pdf->Cell($w_cedula, $row_height, $cedula, 1, 0, 'C', 1);
    $pdf->Cell($w_nombre, $row_height, $nombre, 1, 0, 'L', 1);
    $pdf->Cell($w_fecha, $row_height, $fecha, 1, 0, 'L', 1);
    $pdf->Cell($w_sexo, $row_height, $sexo, 1, 0, 'L', 1);
    $pdf->Cell($w_peso, $row_height, $peso, 1, 0, 'L', 1);
    $pdf->Cell($w_asociacion, $row_height, $asociacion, 1, 1, 'L', 1);

    $j++;
}
/* * *************Linea de fin de hoja con la cantidad total de registros********************* */
/* $pdf->setCellMargins(0, 0, 0, 0);
  $linea     = '------------------------------------------------------------------------------------------------------------------------------';
  /* $pdf->Ln();
  $pdf->SetFillColor(255, 255, 255);
  $pdf->Cell(0, 0, $linea, 0, 0, 'L', 1);
  $pdf->Ln(6);
  //$pdf->Write(14, 'Registros:' . '' . $h);
  $pdf->SetFont('FreeSerif', '', 10);
  //$registros = 'Total de Registros:<span style="color:#FF0000;">' . $total . '</span>';
  //$pdf->writeHTML($registros, true, false, true, false, 'R'); */
$pdf->Output('listado_atletas.pdf', 'I');

