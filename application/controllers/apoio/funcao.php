<?php

function ultimoDiaMes($newData){
			  /*Desmembrando a Data*/
			  list($newAno, $newMes,$newDia ) = explode("-", $newData);
			  return date("Y-m-d", mktime(0, 0, 0, $newMes+1, 0, $newAno));
		   }
		function primeiroDiaMes($newData){
			  /*Desmembrando a Data*/
			  list($newAno, $newMes,$newDia ) = explode("-", $newData);
			  return date("Y-m-d", mktime(0, 0, 0, $newMes, 1, $newAno));
		   }
		function primeiroDiaMesPassado($newData){
			  /*Desmembrando a Data*/
			  list($newAno, $newMes,$newDia ) = explode("-", $newData);
			  return date("Y-m-d", mktime(0, 0, 0, $newMes-1, 1, $newAno));
		   }
		function primeiroDia_a3meses($newData){
			  /*Desmembrando a Data*/
			  list($newAno, $newMes,$newDia ) = explode("-", $newData);
			  return date("Y-m-d", mktime(0, 0, 0, $newMes-3, 1, $newAno));
		   }
		function setimoDiadoMes($newData){
			  /*Desmembrando a Data*/
			  list($newAno, $newMes,$newDia ) = explode("-", $newData);
			  return date("Y-m-d", mktime(0, 0, 0, $newMes, 7, $newAno));
		   }

         function formatoRealPntVrg($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}([.]([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
     function formatoRealVrg($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}(([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
         function formatoRealPnt($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}(([0-9]{3}))*[.]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
    function formatoRealInt($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}(([0-9]{3}))*([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}


    function formatoValor($valorPre) {                                
         if(formatoRealPntVrg($valorPre) == true) 
           {//Verific se o numero digitado é com (.) milhar e (,) decimal
               //serve pra validar  valores acima e abaixo de 1000
                //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                $valorPre  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
           }else if(formatoRealInt($valorPre) == true)
           {//Verific se o numero digitado é inteiro sem ponto nem virgula
               //serve pra validar  valores acima e abaixo de 1000
              //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                $valorPre  =    number_format(str_replace("." , "" ,$valorPre), 2, '.', '');
           }else if(formatoRealPnt($valorPre) == true)
           { 
               //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
               $valorPre  =    $valorPre;
         }else if(formatoRealVrg($valorPre) == true)
           { 
             //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
               $valorPre  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
           }
        return $valorPre;
    }
                                
?>
