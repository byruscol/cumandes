<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once $pluginPath . "/helpers/dbInstance.php";
$db = new dbInstance();
?>
<div class="row-fluid">
    <div class="span11">
        <div class="jqGrid">
            <div class="wrap">
                <div id="icon-tools" class="icon32"></div>
                <h2><?php echo $resource->getWord("vehiculos"); ?></h2>
            </div>
            <div class="span12">
            <table id="vehiculos"></table>
            <div id="vehiculosPager"></div>
            </div>
        </div>
    </div>
    <br/>
    <div class="span12"></div>
    <div id="tabs" class="span11">
        <ul id="optionsTab" class="nav nav-tabs">
            <li class="active"><a href="#filesTab" data-toggle="tab"><?php echo $resource->getWord("files"); ?></a></li>
        </ul>
        <div id="TabContent" class="tab-content">
            <div class="tab-pane fade active" id="filesTab">
                <div class="spacer10"></div>
                <div class="col-md-7">
                    <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                        <table id="files"></table>
                        <div id="filesPager"></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <form id="uploadFiles" class="form" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <input type="hidden" name="oper" value="add"/>
                            <input type="hidden" id="vehiculoId" name="vehiculoId" required="true">
                            <input type="hidden" id="parentRelationShip" name="parentRelationShip" value="vehiculos">
                            
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo $resource->getWord("file"); ?>
                                <input type="file" id="file" name="file" class="btn btn-default" required="true">
                            </label>
                        </div>
                        <div class="form-group">    
                            <label>
                                <?php echo $resource->getWord("nombre"); ?>
                                <input type="text" id="name" name="name" class="input-default" required="true">
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo $resource->getWord("tipoDocumento"); ?>
                                <?php
                                      $query = "SELECT `tipoDocumentoId`,
                                                        `tipoDocumento`
                                                FROM `".$db->pluginPrefix."tipoDocumento`";  
                                      $result = $db->getDataGrid($query, NULL, NULL, 'tipoDocumento', 'ASC');
                                ?>
                                <select id="tipoDocumentoId" name="tipoDocumentoId">
                                    <?php
                                      foreach ($result["data"] as $key => $value) :
                                    ?>
                                    <option value="<?php echo $value->tipoDocumentoId;?>"><?php echo $value->tipoDocumento;?></option>
                                    <?php endforeach;?>
                                </select>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo $resource->getWord("description"); ?>
                                <textarea id="descripcion" name="descripcion"></textarea>
                            </label>
                        </div>
                        <button id="submit" name="submit" class="btn btn-primary"><?php echo $resource->getWord("accept"); ?></button> 
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>
<div id="loading"><p><?php echo $resource->getWord("LoadingFile"); ?></p></div>
<script>
    jQuery(function () {
        
        jQuery("#loading").dialog({
            closeOnEscape: false,
            autoOpen: false,
            modal: true,
            width: 200,
            height: 100
         });
      var tab = jQuery('#tabs li:eq(0) a').attr("href");
      jQuery(tab).css("opacity", 1);
      jQuery('#descripcion').tinymce({
            mode : "none",
            theme : "modern"
        });
   });
</script>