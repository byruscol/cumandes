<?php
require_once "../../commonFilesGrid.php";
$params["postData"]["method"] = "getVehiculosFiles";
$params["sortname"] = "created";
$params["CRUD"] = array("add" => false, "edit" => false, "del" => true, "view" => false, "detail" => false);
$view = new buildView("files", $params, "files");
?>

