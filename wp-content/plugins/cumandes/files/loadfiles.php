<?php
try {
    $usuario = "root"; $contraseña = "clinicol";
    $dbh = new PDO('mysql:host=localhost;dbname=cumandes', $usuario, $contraseña);
    $tipoDoc = "";
    $cliente = "";
    
    $query="INSERT INTO `wp_cm_files`
                    (
                    `tipoDocumentoId`,
                    `name`,
                    `fileName`,
                    `ext`,
                    `mime`,
                    `size`,
                    `descripcion`,
                    `created`,
                    `deleted`,
                    `created_by`)
                    VALUES
                    (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?);";
    try { 
        $stmt = $dbh->prepare($query); 
        $dbh->beginTransaction(); 
        $stmt->execute( array($tipoDoc, 'user@example.com')); 
        $dbh->commit(); 
        print $dbh->lastInsertId(); 
    } catch(PDOExecption $e) { 
        $dbh->rollback(); 
        print "Error!: " . $e->getMessage() . "</br>"; 
    } 
    
    
    $q = $gbd->prepare('SELECT f.`fileId`, `ext`, `mime`, `size`, data '
            . 'FROM `wp_sgc_files` f'
            . ' JOIN wp_sgc_files_data d ON d.fileId = f.fileId');
    $q->execute();
    foreach($q as $fila) {
        file_put_contents($fila["fileId"].".".$fila["ext"], $fila["data"]);
        echo $fila["fileId"]."<br/>";
    }
    $gbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>