<?php
require_once "../../commonVehiculosGrid.php";
$params["sortname"] = "placa";
$params["CRUD"] = array("add" => true, "edit" => true, "del" => true, "view" => false, "excel" => true);
$params["actions"] = array(
                            array("type" => "onSelectRow"
                                      ,"function" => 'function(id) {
                                                        if(id != null) {
                                                                postDataObj = jQuery("#files").jqGrid("getGridParam","postData");
                                                                postDataObj["filter"] = id;
                                                                postDataObj["parent"] = "'.$_GET["view"].'";
                                                                jQuery("#files").jqGrid("setGridParam",{postData: postDataObj})
                                                                                .trigger("reloadGrid");

                                                                jQuery("#vehiculoId").val(id);
                                                        }
                                                    }'
                                    )
                            ,array("type" => "loadComplete"
                                                ,"function" => 'function() { 
                                                                            jQuery("#files").jqGrid().clearGridData(true);
                                                                            
                                                                            jQuery("#vehiculoId").val("");
                                                                }'
                                            )
                        );
$view = new buildView("vehiculos", $params, "vehiculos");
?>
