<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../../commonVehiculosGrid.php";
$params["postData"]["method"] = "getVehiculosCliente";
$params["sortname"] = "placa";
$params["altclass"] = "stripingRows";
$params["CRUD"] = array("add" => true, "edit" => true, "del" => false, "view" => false, "excel" => true);
$view = new buildView("vehiculos", $params, "vehiculos");
?>
