<?php
require_once "../../commonFilesGrid.php";
$params["postData"]["method"] = "getCustomerFiles";
$params["sortname"] = "created";
$params["altclass"] = "stripingRows";
$params["CRUD"] = array("add" => false, "edit" => false, "del" => false, "view" => false, "detail" => false);
$view = new buildView("dashBoard", $params, "dashBoard");
?>

