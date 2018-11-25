<?php

define("included", true);
include_once("configs.php");
include_once("login.php");

function print_arr($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";    
}

function get($param, $default = "") {
    return isset($_GET[$param]) ? trim($_GET[$param]) : $default;
}

function post($param, $default = "") {
    return isset($_POST[$param]) ? trim($_POST[$param]) : $default;
}

function req($param, $default = "") {
    return isset($_REQUEST[$param]) ? trim($_REQUEST[$param]) : $default;
}



class Umsg { //небольшая штука для отправки JSON Данных пользователю.
    private $response; 

    function __construct()
    {
        $this->response = array();
    }

    /**/

    public function sendResponse()
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->response);
    }

    public function addCMD($acmd, $params = null)
    {
        if (!is_array($params))
            $params = array();
        $params['act'] = $acmd;
        $params['srv_time'] = time();

        $this->response[] = $params;
    }

    public function addError($err_text, $params = null)
    {
        if (!is_array($params))
            $params = array();
        $params['text'] = $err_text;
        $this->addCMD("error", $params);
    }

    public function addInfo($info_text, $params = null)
    {
        if (!is_array($params))
            $params = array();
        $params['text'] = $info_text;
        $this->addCMD("info", $params);
    }

    public function clearAll()
    {
        $this->response = array();
    }
}