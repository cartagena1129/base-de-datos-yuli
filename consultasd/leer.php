<?php
$serverName = "netv-psql09-13\\replicasd";
//$connectionInfo = array( "Database"=>"MDB");
$connectionInfo = array( "Database"=>"MDB", "UID"=>"usr_operapps", "PWD"=>"usr_operapps0318");
$conn = sqlsrv_connect( $serverName, $connectionInfo);



if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}

$sql = "SELECT REPLACE(REPLACE(REPLACE(ca.resource_name,CHAR(9),''),CHAR(10),''),CHAR(13),'')as 'nombre'

,am.sym as 'ambiente'

,REPLACE(REPLACE(REPLACE(ca2.resource_name,CHAR(9),''),CHAR(10),''),CHAR(13),'') as 'servicio'

,co.first_name + ', ' + co.last_name as 'contacto1'

,co.email_address as 'correo1'

FROM ca_owned_resource ca

LEFT JOIN usp_owned_resource usp ON ca.own_resource_uuid = usp.owned_resource_uuid

LEFT JOIN ca_owned_resource ca2 ON usp.baseline_uuid = ca2.own_resource_uuid

LEFT JOIN ca_resource_class clase ON clase.id = ca.resource_class

LEFT JOIN ca_resource_family familia ON familia.id = ca.resource_family

LEFT JOIN zAmbiente am ON usp.zAmbiente_id = am.id

LEFT JOIN ca_contact co ON ca.resource_contact_uuid = co.contact_uuid

left join ca_organization org on org.organization_uuid = ca.responsible_org_uuid

left join ca_contact AS vinculado ON vinculado.contact_uuid = ca.support_contact1_uuid

WHERE familia.name = 'Hardware.server'  AND ca.inactive <> 1";

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

//$row_count = sqlsrv_num_rows( $stmt );

//echo "Total de filas: ".$row_count."<br>";

//while( $row = sqlsrv_fetch_array( $stmt) ) {
//    print json_encode($row);
//    echo "<br >Nombre: ".$row['nombre']."<br />"; 
//    echo "Ambiente: ".$row['ambiente']."<br />";
//    echo "Servicio: ".$row['servicio']."<br />";
//    echo "Contacto 1: ".$row['contacto1']."<br />";
//    echo "Correo 1: ".$row['correo1']."<br />";
   
//}

//sqlsrv_close($conn);

//exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <title>Conexión entre HTML y PHP</title>

     <center><h1>Página Yulieth</h1></center>

    <form action="leer.php" method="post"></form>

    <meta charset="UTF-8">

    <style>

        body  {
            background: rgb(166, 208, 221);
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table td {
            border: 1px solid rgb(12, 12, 14);
            text-align: center;
            padding: 1.3rem;
        }
        .button {
            border-radius: .5rem;
            color: white;
            background-color: rgb(49, 46, 240);
            padding: 1rem;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div>
    <table>
    <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">información Adicional</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
        <tr>
            <div clas ><th>Nombre </th></div>
             <div clas ><th>Ambiente</th></div>
             <div clas ><th>Servicio</th></div>
             <div clas ><th>Contacto</th></div>
             <div clas ><th>Correo</th> </div>

        </tr>
        <?php
        while( $row = sqlsrv_fetch_array( $stmt) ) {
        ?>
        <tr>
            
           <td><?php echo $row['nombre']; ?></td>
           <td><?php echo $row['ambiente']; ?></td>
           <td><?php echo $row['servicio']; ?></td>
           <td><?php echo $row['Contacto1']; ?></td>
           <td><?php echo $row['Correo1']; ?></td>
           
        
        </tr>
     <?php
        }
     ?>

    </table>


</div>


