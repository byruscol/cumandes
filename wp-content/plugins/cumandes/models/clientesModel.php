<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('DBManagerModel.php');
class clientes extends DBManagerModel{
   
    public function getList($params = array()){
        $entity = $this->entity();
         
        $start = $params["limit"] * $params["page"] - $params["limit"];
        $query = "SELECT `clienteId`,
                        `identificacion`,
                        `nombre`,
                        `ciudadId`,
                        `telefono`,
                        `email`,
                        `contacto`,
                        `observaciones`
                    FROM ".$entity["tableName"]." i"
                . " WHERE deleted = 0";
        
        if(array_key_exists('where', $params)){
            if (is_array( $params["where"]->rules )){
                $countRules = count($params["where"]->rules);
                for($i = 0; $i < $countRules; $i++){
                    switch($params["where"]->rules[$i]->field ){
                        case "created_by": $params["where"]->rules[$i]->field = "display_name"; break;
                        case "edad": $params["where"]->rules[$i]->field = "DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), fechaNacimiento)), '%Y')+0"; break;
                    }
                }
            }
            
           $query .= " AND (". $this->buildWhere($params["where"]) .")";
        }
        
        return $this->getDataGrid($query, $start, $params["limit"] , $params["sidx"], $params["sord"]);
    }

    public function getCities($params){
        $query = "SELECT ciudadId, ciudad 
                  FROM ".$this->pluginPrefix."ciudades c
                  WHERE `departamentoId` = ". $params["filter"];
        
        $cities = $this->getDataGrid($query, NULL, NULL , "ciudad", "ASC");
        $responce = array("metaData" => array("key" => "ciudadId", "value" => "ciudad"), "data" => $cities["data"]);
        return $cities;
    }
    
    public function add(){
        $entity = $this->entity();
        $this->addRecord($entity, $_POST, array("date_entered" => date("Y-m-d H:i:s"), "created_by" => $this->currentUser->ID));
    
        if($this->LastId > 0 && !empty($this->LastId)){
            $userdata = array(
                            'user_login'  =>  $_POST["identificacion"],
                            'user_pass'   =>  $_POST["identificacion"],
                            'user_nicename' => $_POST["nombre"],
                            'display_name' => $_POST["nombre"]
                        ); 
            $user_id = wp_insert_user($userdata);
            
            $this->addRecord($entity["relationship"]["clientesUsuarios"], array("clienteId" => $this->LastId, "ID" => $user_id), array("date_entered" => date("Y-m-d H:i:s"), "created_by" => $this->currentUser->ID));
        }
    }
    public function edit(){ 
        $this->updateRecord($this->entity(), $_POST, array("clienteId" => $_POST["clienteId"]), null);
    }
    public function del(){
        $this->delRecord($this->entity(), array("clienteId" => $_POST["id"]));
    }

    public function detail($params = array()){
        $entity = $this->entity();
        $query = "  SELECT `clienteId`,
                            `identificacion`,
                            `nombre`,
                            `ciudad` ciudadId,
                            `telefono`,
                            `email`,
                            `contacto`,
                            `observaciones`
                    FROM ".$entity["tableName"]." c
                            JOIN ".$this->pluginPrefix."ciudades i ON i.ciudadId = c.ciudadId
                    WHERE c.`clienteId` = " . $params["filter"];
        $this->queryType = "row";
        return $this->getDataGrid($query);
    }
    
    public function entity($CRUD = array())
    {
        $data = array(
                    "tableName" => $this->pluginPrefix."clientes"
                    ,"entityConfig" => $CRUD
                    ,"atributes" => array(
                        "clienteId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true, "autoIncrement" => true, "toolTip" => array("type" => "cell", "cell" => 2) )
                        ,"identificacion" => array("type" => "varchar", "required" => true)
                        ,"nombre" => array("type" => "varchar", "required" => true)
                        ,"ciudadId" => array("type" => "int", "required" => true, "references" => array("table" => $this->pluginPrefix."ciudades", "id" => "ciudadId", "text" => "ciudad"))
                        ,"telefono" => array("type" => "varchar", "required" => true)
                        ,"email" => array("type" => "email", "required" => true)
                        ,"contacto" => array("type" => "varchar")
                        ,"observaciones" => array("type" => "text")
                    )
                    ,"relationship" => array(
                                "clientesUsuarios" => array(
                                    "tableName" => $this->pluginPrefix."clientesUsuarios"
                                    ,"atributes" => array(
                                        "clientesUsuariosId" => array("type" => "int", "PK" => 0, "required" => false, "readOnly" => true, "autoIncrement" => true, "toolTip" => array("type" => "cell", "cell" => 2) )
                                        ,"clienteId" => array("type" => "int", "required" => true)
                                        ,"ID" => array("type" => "int", "required" => true)
                                    )
                                )
                            )
                );
        return $data;
    }
}
?>