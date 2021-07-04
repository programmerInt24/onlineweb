<?php
  /**
 * Autor: Rodrigo Chambi Q.
 * Mail:  filvovmax@gmail.com
 * web:   www.gitmedio.com
 * Paginador datos para PHP y Mysql, HTML5
 */
$CantidadMostrar=5;
//Conexion  al servidor mysql
$conetar = new mysqli("localhost", "root", "system456", "turl");
if ($conetar->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conetar->connect_errno . ") " . $conetar->connect_error;
}else{
                    // Validado  la variable GET
    $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
	$TotalReg       =$conetar->query("SELECT * FROM ejemplo_paginacion");
	//Se divide la cantidad de registro de la BD con la cantidad a mostrar 
	$TotalRegistro  =ceil($TotalReg->num_rows/$CantidadMostrar);
	echo "<b>La cantidad de resgistro se dividio a: </b>".$TotalRegistro." para mostrar 5 en 5<br>";
	//Consulta SQL
	$consultavistas ="SELECT
						ejemplo_paginacion.id,
						ejemplo_paginacion.Nombre,
						ejemplo_paginacion.Apellido
						FROM
						ejemplo_paginacion
						ORDER BY
						ejemplo_paginacion.id ASC
						LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
                       // echo $consultavistas;
	$consulta=$conetar->query($consultavistas);
         echo "<table><tr><th>Codigo</th><th>Nombre</th><th>Apellido</th></tr>";
	while ($lista=$consulta->fetch_row()) {
	     echo "<tr><td>".$lista[0]."</td><td>".$lista[1]."</td><td>".$lista[2]."</td></tr>";
	}
	    echo "</table>";
     
    /*Sector de Paginacion */
    
    //Operacion matematica para boton siguiente y atras 
	$IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):1;
  	$DecrementNum =(($compag -1))<1?1:($compag -1);
  
	echo "<ul><li class=\"btn\"><a href=\"?pag=".$DecrementNum."\">◀</a></li>";
    //Se resta y suma con el numero de pag actual con el cantidad de 
    //numeros  a mostrar
     $Desde=$compag-(ceil($CantidadMostrar/2)-1);
     $Hasta=$compag+(ceil($CantidadMostrar/2)-1);
     
     //Se valida
     $Desde=($Desde<1)?1: $Desde;
     $Hasta=($Hasta<$CantidadMostrar)?$CantidadMostrar:$Hasta;
     //Se muestra los numeros de paginas
     for($i=$Desde; $i<=$Hasta;$i++){
     	//Se valida la paginacion total
     	//de registros
     	if($i<=$TotalRegistro){
     		//Validamos la pag activo
     	  if($i==$compag){
           echo "<li class=\"active\"><a href=\"?pag=".$i."\">".$i."</a></li>";
     	  }else {
     	  	echo "<li><a href=\"?pag=".$i."\">".$i."</a></li>";
     	  }     		
     	}
     }
	echo "<li class=\"btn\"><a href=\"?pag=".$IncrimentNum."\">▶</a></li></ul>";
  
}
?>