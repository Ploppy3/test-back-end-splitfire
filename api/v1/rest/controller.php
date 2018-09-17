<?php
require 'table.interface.php';

class Controller implements iTable {

    protected $isJSONP = false;
    protected $db;
    protected $urlParams = array();

    //------------------------------------------------------------------------

    protected function getUrlParam($key){
        if(array_key_exists($key, $this->urlParams))
            $value = $this->urlParams[$key];
        else
            throwError(500, "tried to access a missing url argument ($key)");
        return  $value;
    }

    //------------------------------------------------------------------------

    protected function stmt_get($stmt_str, array $params){
        $stmt = $this->db->prepare($stmt_str);
        if(!$stmt->execute($params))
            throwError(500, "couldnt fetch item");
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        if($response == false)
            sendResponse(404, null);
        sendResponse(200, $response);
    }

    protected function stmt_getAll($stmt_str, array $params){
        $stmt = $this->db->prepare($stmt_str);
        if(!$stmt->execute($params))
            throwError(500, "couldnt fetch items");
        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        if($response == false)
            throwError(404, "item not found");
        sendResponse(200, $response);
    }

    //------------------------------------------------------------------------

    protected function stmt_post($stmt_str, array $params){
        $stmt = $this->db->prepare($stmt_str);
        if(!$stmt->execute($params))
            throwError(500, "couldnt insert item");
        return $this->db->lastInsertId();
    }

    //------------------------------------------------------------------------

    protected function stmt_update($stmt_str, array $params){
        $stmt = $this->db->prepare($stmt_str);
        if(!$stmt->execute($params))
            throwError(500, "couldnt udpate item");
    }

    //------------------------------------------------------------------------

    protected function stmt_delete($stmt_str, array $params){
        $stmt = $this->db->prepare($stmt_str);
        if(!$stmt->execute($params))
            throwError(500, "couldnt delete item");
        sendResponse(200, "deleted");
    }

    //------------------------------------------------------------------------

    function GET(){
        throwError(400, 'Method GET is not supported for this controller');
    }

    function POST(){
        throwError(400, 'Method POST is not supported for this controller');
    }

    function PUT(){
        throwError(400, 'Method PUT is not supported for this controller');
    }

    function DELETE(){
        throwError(400, 'Method DELETE is not supported for this controller');
    }

    function OPTIONS(){
        throwError(400, 'Method OPTIONS is not supported for this controller');
    }

    //------------------------------------------------------------------------

    //DO NOT USE nor MODIFY
    function addUrlParam($key="", $value=""){
        $this->urlParams[$key] = $value;
    }

    //DO NOT USE nor MODIFY
    function setJSONP($isJSONP=false){
        $this->isJSONP = $isJSONP;
    }

    //DO NOT USE nor MODIFY
    function __construct($db){
        $this->db = $db;
    }
}