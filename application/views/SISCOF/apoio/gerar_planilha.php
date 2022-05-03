<!--**
 * @author Cesar Szpak - Celke -   cesar@celke.com.br
 * @pagina desenvolvida usando framework bootstrap,
 * o código é aberto e o uso é free,
 * porém lembre -se de conceder os créditos ao desenvolvedor.
 *-->
 <?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Contato</title>
    </head>
	<body>
		<?php
        $contaP = $_SESSION["caixaP"] ;
        switch ($contaP) 
			{
				case 1:	$contaNome = "1444-3"; break;    
				case 2:	$contaNome = "22360-3"; break;  
				case 3:	$contaNome = "ILPI"; break;  
				case 4:	$contaNome = "BR214"; break;  
				case 5:	$contaNome = "BR518"; break;  
				case 6:	$contaNome = "BR542"; break;  
				case 7:	$contaNome = "BR549"; break;  
				case 8:	$contaNome = "BR579"; break;  
				case 9:	$contaNome = "BB 28965-5"; break;  
				case 10:$contaNome = "CEF 1948-4"; break;
				case 99:$contaNome = "Todas contas"; break;  				
			}			
         $admP = $_SESSION["admP"];  
         $anoP = $_SESSION["anoP"]  ;	 
         $mesP = $_SESSION["mesNP"] ;
         if( $admP == "cod_assoc" ){$admN = "IEADALPE"; }  
             else if( $admP == "cod_compassion" ){$admN = "Comp"; }
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'relat_'.$admN.'_'.$contaNome.'_'.$mesP.'-'.$anoP.'.xls';
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $_SESSION['html'];
		exit; ?>
	</body>
</html>