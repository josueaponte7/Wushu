<?php

session_start();
date_default_timezone_set('America/Caracas');
require_once '../../modelo/Conexion.php';
$obj_conexion = new Conexion();

require_once './tcpdf/spa.php';
require_once './tcpdf/MyClass.php';

$sql = "SELECT 
            a.nombre,  
            CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = a.cod_telefono), a.telefono) AS telefono,
            a.representante,  
            CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = a.cod_telrep), a.tel_rep) AS tel_rep, 
            a.estatus 
        FROM asociaciones a   ORDER BY a.nombre;";

$resultado = $obj_conexion->RetornarRegistros($sql);

//$total     = $obj->totalFilas('sociaciones AS a', 'a.nombre',$campos['condicion']);

$pdf = new MyClass("P", "mm", "A4", true, 'UTF-8', false);

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
$titulo = "LISTADO DE ASOCIACIONES";
$pdf->Ln(5);
//mover titulo
$pdf->SetX(60);
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

$w_nombre        = 40;
$w_telefono      = 40;
$w_representante = 40;
$w_tel_rep       = 55;
$w_estatus       = 25;

// Mover a la derecha 
$pdf->SetX(6);

// Color Cabecera de la tabla
$pdf->SetFillColor(222, 222, 222);


// Titulos de la Cabecera
$pdf->Cell($w_nombre, $row_height, 'Asociaciones', 1, 0, 'C', 1);
$pdf->Cell($w_telefono, $row_height, 'Teléfono', 1, 0, 'L', 1);
$pdf->Cell($w_representante, $row_height, 'Representante', 1, 0, 'L', 1);
$pdf->Cell($w_tel_rep, $row_height, 'Teléfono Representante', 1, 0, 'L', 1);
$pdf->Cell($w_estatus, $row_height, 'Estatus', 1, 1, 'L', 1);

// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    // Asignarle variables a los registros
    $nombre        = $resultado[$i]['nombre'];
    $telefono      = $resultado[$i]['telefono'];
    $representante = $resultado[$i]['representante'];
    $tel_rep       = $resultado[$i]['tel_rep'];
    $estatus       = $resultado[$i]['estatus'];

    // verificar que la variable $j no si es mayor se hace un salto de pagina
    if ($j > $max) {
        $pdf->AddPage();

        // color de la letra
        $pdf->SetFillColor(255, 255, 255);

        // salto de linea
        $pdf->Ln(15);
        /*         * ****Imagen del logo de las hojas que continua***** */
        $$pdf->Image('imagenes/logoinicio.png', 3, 18, 45, 15, 'PNG', FALSE);
        // Tipo de letra negrita tamaño 14
        $pdf->SetFont('FreeSerif', 'B', 14);

        $pdf->SetX(60);
        // Titulo del Reporte width:90 heigth:0 text:$titulo alineacion:C
        $pdf->Cell(90, 0, $titulo, 0, 0, 'C', 0);
        $pdf->Ln(15);

        // Color Cabecera de la tabla
//        $pdf->SetFillColor(39, 129, 213);
        $pdf->SetFillColor(222, 222, 222);

        $pdf->SetX(60);
        $pdf->Cell($w_nombre, $row_height, 'Asociaciones', 1, 0, 'C', 1);
        $pdf->Cell($w_telefono, $row_height, 'Teléfono', 1, 0, 'L', 1);
        $pdf->Cell($w_representante, $row_height, 'Representante', 1, 0, 'L', 1);
        $pdf->Cell($w_tel_rep, $row_height, 'Teléfono Representante', 1, 0, 'L', 1);
        $pdf->Cell($w_estatus, $row_height, 'Estatus', 1, 1, 'L', 1);

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
    $pdf->SetX(6);
    $pdf->Cell($w_nombre, $row_height, $nombre, 1, 0, 'C', 1);
    $pdf->Cell($w_telefono, $row_height, $telefono, 1, 0, 'L', 1);
    $pdf->Cell($w_representante, $row_height, $representante, 1, 0, 'L', 1);
    $pdf->Cell($w_tel_rep, $row_height, $tel_rep, 1, 0, 'L', 1);
    $pdf->Cell($w_estatus, $row_height, $estatus, 1, 1, 'L', 1);

    $j++;
}
/* * *************Linea de fin de hoja con la cantidad total de registros********************* */
/* $pdf->setCellMargins(0, 0, 0, 0);
  $linea     = '------------------------------------------------------------------------------------------------------------------------------';
  $pdf->Ln();
  $pdf->SetFillColor(255, 255, 255);
  $pdf->Cell(0, 0, $linea, 0, 0, 'L', 1);
  $pdf->Ln(6);
  //$pdf->Write(14, 'Registros:' . '' . $h);
  $pdf->SetFont('FreeSerif', '', 10);
  //$registros = 'Total de Registros:<span style="color:#FF0000;">' . $total . '</span>';
  //$pdf->writeHTML($registros, true, false, true, false, 'R'); */
$pdf->Output('listado_asociaciones.pdf', 'I');

