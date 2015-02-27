<?php
require_once "../../commonVehiculosGrid.php";
$params["postData"]["method"] = "getMyVehicles";
$params["sortname"] = "placa";
$params["altclass"] = "stripingRows";
$params["CRUD"] = array("add" => false, "edit" => false, "del" => false, "view" => false, "excel" => false);
$params["actions"] = array(
                            array("type" => "onSelectRow"
                                      ,"function" => 'function(id) {
                                                        if(id != null) {
                                                                postDataObj = jQuery("#vehiclesFiles").jqGrid("getGridParam","postData");
                                                                postDataObj["filter"] = id;
                                                                postDataObj["parent"] = "'.$_GET["view"].'";
                                                                jQuery("#vehiclesFiles").jqGrid("setGridParam",{postData: postDataObj})
                                                                                .trigger("reloadGrid");

                                                                jQuery("#vehiculoId").val(id);
                                                        }
                                                    }'
                                    )
                            ,array("type" => "loadComplete"
                                                ,"function" => 'function() { 
                                                                            jQuery("#vehiclesFiles").jqGrid().clearGridData(true);
                                                                            
                                                                            jQuery("#vehiculoId").val("");
                                                                }'
                                            )
                        );
$view = new buildView("vehiculos", $params, "vehiculos");
?>
jQuery(document).ready(function($){
    $("#vehiculos").jqGrid().hideCol("clienteId");
    $("#vehiculos").jqGrid().setGridWidth($("#vehiculos_dashboard_widget").width()-30);
});

