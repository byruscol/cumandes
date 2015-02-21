<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');
class files extends DBManagerModel{
	
    public function getList($params = array()){

        if(!array_key_exists('filter', $params))
                $params["filter"] = 0;

        $start = $params["limit"] * $params["page"] - $params["limit"];
        
        if($params["queryType"] == "basic")
            $cols = "`fileId`, tipoDocumento, `name`, `created`,`ext`";
        else
            $cols = "`fileId`, tipoDocumento, `name`, `created`, `ext`, `fileName`, `size`, descripcion, `display_name` AS created_by";
        
        $query = "SELECT ".$cols."
                          FROM  `".$this->pluginPrefix."files` n
                                JOIN ".$this->pluginPrefix."tipoDocumento t ON t.tipoDocumentoId = n.tipoDocumentoId
                                JOIN ".$this->wpPrefix."users u ON u.ID = n.created_by
                          WHERE  `deleted` = 0 AND `fileId` IN ( ". $params["filter"] ." )";
        
        if(array_key_exists('where', $params)){
            if (is_array( $params["where"]->rules )){
                $countRules = count($params["where"]->rules);
                for($i = 0; $i < $countRules; $i++){
                    if($params["where"]->rules[$i]->field == "created_user")
                        $params["where"]->rules[$i]->field = "display_name";
                }
            }
            
           $query .= " AND (". $this->buildWhere($params["where"]) .")";
        }
        $data = $this->getDataGrid($query, $start, $params["limit"] , $params["sidx"], $params["sord"] );
        
        return $data;
    }

    public function getClientesFiles($params = array()){
        $DataArray= array();
        $query = "SELECT  `fileId`
                              FROM  `".$this->pluginPrefix."clientes_files` n
                              WHERE  `clienteId` = " . $params["filter"];

        $responce = $this->getDataGrid($query);

        foreach ( $responce["data"] as $k => $v ){
                $DataArray[] = $responce["data"][$k]->fileId;
        }

        $params["parentRelationShip"] = "clientes";
        $params["parent"] = $params["filter"];
        $params["filter"] = implode(",", $DataArray);

        $data = $this->getList($params);
        return $data;
    }

    public function getVehiculosFiles($params = array()){
        $DataArray= array();
        $query = "SELECT  `fileId`
                              FROM  `".$this->pluginPrefix."vehiculos_files` n
                              WHERE  `vehiculoId` = " . $params["filter"];

        $responce = $this->getDataGrid($query);

        foreach ( $responce["data"] as $k => $v ){
                $DataArray[] = $responce["data"][$k]->fileId;
        }

        $params["parentRelationShip"] = "vehiculos";
        $params["parent"] = $params["filter"];
        $params["filter"] = implode(",", $DataArray);

        $data = $this->getList($params);
        return $data;
    }
    
    public function add(){
        $rtnData = new stdClass();
        $rtnData->error = '';
        try{
            $entityObj = $this->entity();
            $relEntity = $entityObj["relationship"][$_POST["parentRelationShip"]];
            $target_path = $this->pluginPath."/uploadedFiles/";
            $_POST["fileName"] = $_FILES['file']['name'];
            $nameParts = explode(".", $_FILES['file']['name']);
            $_POST["ext"] = end($nameParts);
            $nameArray = array_pop($nameParts);
            $fileName = implode("_",$nameParts);
            $fileName = str_replace(array("'",".",",","*","@","?","!"), "_",$fileName);
            $_POST["size"] =  $_FILES["file"]["size"];

            $file = $target_path.$fileName.".".$_POST["ext"];
            if(move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
                $this->addRecord($entityObj, $_POST, array("mime"=> $_FILES["file"]["type"], "created" => date("Y-m-d H:i:s"), "created_by" => $this->currentUser->ID));
                $id = $this->LastId;
                if(!empty($id)){
                    $this->addRecord($relEntity, array($relEntity["parent"]["Id"] => $_POST["parentId"],"fileId" => $id), array());
                    $this->uploadFile($id,$_POST["ext"],$file);
                    $rtnData->msg = 'success';
                }
                else{
                    unlink($file);
                    $rtnData->msg = 'fail';
                }
            } else{
                $rtnData->msg = 'fail'; 
                $rtnData->error = "There was an error uploading the file, please try again!";
            }
        }
        catch (Exception $e){
            $rtnData->msg = 'fail'; 
            $rtnData->error = $e->getMessage();
        }
        echo json_encode($rtnData);
    }
    public function edit(){
    }
    public function del(){
        $this->delRecord($this->entity(), array("fileId" => $_POST["id"]), array("columnValidateEdit" => "created_by"));
    }
    public function detail(){}
    public function entity($CRUD = array())
    {
        $data = array(
                    "tableName" => $this->pluginPrefix."files"
                    ,"columnValidateEdit" => "created_by"
                    ,"entityConfig" => $CRUD
                    ,"atributes" => array(
                        "fileId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true, "autoIncrement" => true, "downloadFile" => array("show" => true, "cellIcon" => 6, "rowObjectId" => 4, "view" => "files") )
                        ,"tipoDocumentoId" => array("label"=>"tipoDocumento","type" => "int", "required" => false )
                        ,"name" => array("label"=>"nombre","type" => "varchar", "required" => true)
                        ,"created" => array("label"=>"fecha","type" => "datetime", "required" => false, "readOnly" => true )
                        ,"ext" => array("type" => "varchar", "required" => false, "hidden" => true)
                        ,"fileName" => array("label"=>"fileName","type" => "varchar", "required" => true)
                        ,"size" => array("type" => "bigint", "required" => false, "hidden" => true)
                        ,"descripcion" => array("label"=>"description","type" => "text", "required" => false, "hidden" => true, "edithidden" => true)
                        ,"created_by" => array("type" => "int", "required" => false, "readOnly" => true )
                        ,"icon" => array("type" => "varchar", "required" => false, "hidden" => true, "isTableCol" => false)
                    )
                    ,"relationship" => array(
                        "clientes" => array(
                                    "tableName" => $this->pluginPrefix."clientes_files"
                                    ,"parent" => array("tableName" => $this->pluginPrefix."clientes", "Id" => "clienteId")
                                    ,"atributes" => array(
                                            "clienteId" => array("type" => "int", "PK" => 0)
                                            ,"fileId" => array("type" => "int", "PK" => 0)
                                       )
                                )
                        ,"vehiculos" => array(
                                    "tableName" => $this->pluginPrefix."vehiculos_files"
                                    ,"parent" => array("tableName" => $this->pluginPrefix."vehiculos", "Id" => "vehiculoId")
                                    ,"atributes" => array(
                                            "vehiculoId" => array("type" => "int", "PK" => 0)
                                            ,"fileId" => array("type" => "int", "PK" => 0)
                                       )
                                )
                    )
                );
            return $data;
    }
}
?>
