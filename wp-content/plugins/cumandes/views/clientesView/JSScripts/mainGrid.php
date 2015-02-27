<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once "../../../helpers/Grid.php";
require_once "../../class.buildView.php";
header('Content-type: text/javascript');
global $pluginURL;
global $siteURL;
$params["altclass"] = "stripingRows";
$params = array("numRows" => 10
                , "sortname" => "nombre"
                , "CRUD" => array("add" => true, "edit" => true, "del" => false, "view" => true, "files" => false, "excel"=>true)
                , "actions" => array(
                                        array("type" => "onSelectRow"
                                                  ,"function" => 'function(id) {
                                                                    if(id != null) {
                                                                            postDataObj = jQuery("#vehiculos").jqGrid("getGridParam","postData");
                                                                            postDataObj["filter"] = id;
                                                                            postDataObj["parent"] = "'.$_GET["view"].'";
                                                                            jQuery("#vehiculos").jqGrid("setGridParam",{postData: postDataObj})
                                                                                            .trigger("reloadGrid");
                                                                                            
                                                                            postDataObj = jQuery("#clientesUsuarios").jqGrid("getGridParam","postData");
                                                                            postDataObj["filter"] = id;
                                                                            postDataObj["parent"] = "'.$_GET["view"].'";
                                                                            jQuery("#clientesUsuarios").jqGrid("setGridParam",{postData: postDataObj})
                                                                                            .trigger("reloadGrid");
                                                                                            
                                                                            postDataObj = jQuery("#files").jqGrid("getGridParam","postData");
                                                                            postDataObj["filter"] = id;
                                                                            postDataObj["parent"] = "'.$_GET["view"].'";
                                                                            jQuery("#files").jqGrid("setGridParam",{postData: postDataObj})
                                                                                            .trigger("reloadGrid");
                                                                            
                                                                            jQuery("#clienteId").val(id);
                                                                    }
                                                                }'
                                                )
                                        ,array("type" => "loadComplete"
                                                ,"function" => 'function() { 
                                                                            jQuery("#vehiculos").jqGrid().clearGridData(true);
                                                                            jQuery("#clientesUsuarios").jqGrid().clearGridData(true);
                                                                            jQuery("#files").jqGrid().clearGridData(true);
                                                                            
                                                                            jQuery("#clienteId").val("");
                                                                }'
                                            )
                                    )
            );
$view = new buildView($_GET["view"], $params, "clientes");
?>
