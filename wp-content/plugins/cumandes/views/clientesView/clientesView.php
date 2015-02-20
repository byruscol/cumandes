<?php
require_once $pluginPath . "/helpers/dbInstance.php";
$db = new dbInstance();
?>
<div class="row-fluid">
    <div class="span11">
        <div class="jqGrid">
            <div class="span12">
            <table id="clientes"></table>
            <div id="clientesPager"></div>
            </div>
        </div>
    </div>
    <br/>
    <div class="span12"></div>
    <div id="tabs" class="span11">
        <ul id="optionsTab" class="nav nav-tabs">
            <li class="active"><a href="#filesTab" data-toggle="tab"><?php echo $resource->getWord("files"); ?></a></li>
            <li><a href="#vehiculosTab" data-toggle="tab"><?php echo $resource->getWord("vehiculos"); ?></a></li>
            <li><a href="#usuariosTab" data-toggle="tab"><?php echo $resource->getWord("usuarios"); ?></a></li>
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
                            <input type="hidden" id="clienteId" name="cliente" required="true">
                            <input type="hidden" id="parentRelationShip" name="parentRelationShip" value="clientes">
                            
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
            <div class="tab-pane fade" id="vehiculosTab">
                <div class="spacer10"></div>
                <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                    <table id="vehiculos"></table>
                    <div id="vehiculosPager"></div>
                </div>
            </div>
            <div class="tab-pane fade active" id="usuariosTab">
                <div class="spacer10"></div>
                <div class="ui-jqgrid ui-widget ui-corner-all clear-margin span12" dir="ltr" style="">
                    <table id="clientesUsuarios"></table>
                    <div id="clientesUsuariosPager"></div>
                </div>
            </div>
        </div>
    </div> 
</div>

<div id="loading"><p><?php echo $resource->getWord("LoadingFile"); ?></p></div>
<div aria-hidden="true" aria-labelledby="largeModal" role="dialog" tabindex="-1" id="flotaClienteModal" class="modal fade" style="display: none;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 id="myModalLabel" class="modal-title"></h4>
            
          </div>
          <div class="modal-body">
            <?php  
                $template =  file_get_contents(__DIR__."/../miFlotaUserView/miFlotaUserView.php");
                $template = str_replace("{placa}", $resource->getWord("placa"), $template);
                $template = str_replace("{placasCriticas}", $resource->getWord("placasCriticas"), $template);
                $template = str_replace("{placasExtendidas}", $resource->getWord("placasExtendidas"), $template);
                
                echo $template = str_replace("{buscarPlaca}", $resource->getWord("buscarPlaca"), $template);  
            ?>
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
          </div>
        </div>
      </div>
</div>
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