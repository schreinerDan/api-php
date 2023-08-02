<?php 

namespace Core;

class Messages {

    public static function methodNotAllowed(){
         echo json_encode(array("message" => "Method not allowed."));
    }
    public static function invalidRequestData(){
        echo json_encode(array("message" => "Invalid request data."));
    }
    public static function actionSuccess($action,$model){
        echo json_encode(array("message" => "$model $action successfully."));
    }
    public static function actionFailed($action,$model){
        echo json_encode(array("message" => "Failed to $action $model."));
    }
    public static function notFound($model){
        echo json_encode(array("message" => "$model not found."));
    }
    
}
