<?php

function geraExcel() {
	
	/* $objPHPExcel = new PHPExcel();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$xlsName.'"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');*/
 header("Content-type: application/vnd.ms-excel"); 
						   header("Content-type: application/force-download");
						   header("Content-Disposition: attachment; filename=file.xls"); 
						   header("Pragma: no-cache");
						   echo $html;
}
 
?>