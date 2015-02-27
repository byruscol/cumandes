<?php
require_once "../../commonFilesGrid.php";
$params["postData"]["method"] = "getClientesFiles";
$params["sortname"] = "created";
$params["altclass"] = "stripingRows";
$params["CRUD"] = array("add" => false, "edit" => false, "del" => true, "view" => false, "detail" => false);
$view = new buildView("files", $params, "files");
?>

