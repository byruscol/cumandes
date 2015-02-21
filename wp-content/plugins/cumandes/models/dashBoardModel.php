<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('filesModel.php');
class dashBoard extends files{
    
    public $files;
    function __construct() {
        parent::__construct();
        $this->files = new files();
    }
    
    public function getCustomerFiles($params = array()){
        $DataArray= array();
        
        $user = $this->currentUser->ID;
        
        $query = "SELECT  `fileId`
                  FROM  `".$this->pluginPrefix."clientesUsuarios` u
                    JOIN `".$this->pluginPrefix."clientes_files` n ON n.clienteId = u.clienteId
                  WHERE  u.`ID` = " . $user;

        $responce = $this->getDataGrid($query);

        foreach ( $responce["data"] as $k => $v ){
                $DataArray[] = $responce["data"][$k]->fileId;
        }

        $params["filter"] = implode(",", $DataArray);
        $params["queryType"] = "basic";
        $data = $this->getList($params);
        return $data;
    }
    
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
                    )
                );
            return $data;
    }
}
?>