<?php
/**
 * usom.gov.tr API address checker class
 *
 * @author Levent Emre PAÇAL
 * @web https://leventemre.com
 * @update 10 Feb 2023
*/

class usom {

    private static $usom_api_address = "https://www.usom.gov.tr/api/";
    private static $settings = array(
        "lang" => "tr" // tr or en
    );

    private static function get_description($listeid, $id) {
        $checkerlist = array(
            "desc" => "address-description/index",
            "source" => "address-source/index",
            "connectionType" => "address-connection-type/index"
        );

        $description_info = json_decode(file_get_contents(self::$usom_api_address.$checkerlist[$listeid]), true);
        $description_check = (array_search($id, array_column($description_info["models"], "id")));
        $description = ($description_check==true) ? $description_info["models"][$description_check] : false;

        return $description;
    }

    public static function check($url, $urltype) {

        if($urltype==1) {
    
        $url_parse = parse_url($url);
        if($url_parse["host"]) {
            $realUrl = $url_parse["host"];
        } elseif(filter_var($url, FILTER_VALIDATE_DOMAIN)) {
            $realUrl = $url;
        }

        if(!$realUrl) {
            return [
                "status" => 0
            ];
        } 

        } elseif($urltype==2) {


        if(!filter_var($url, FILTER_VALIDATE_IP)) {
            return [
                "status" => 0
            ];  
        } else {
            $realUrl = $url;
        }


        }

        $usom_info = json_decode(file_get_contents(self::$usom_api_address."address/index?q=".$realUrl), true);
        $description_info = self::get_description("desc", $usom_info["models"][0]["desc"]);
        $source_info = self::get_description("source", $usom_info["models"][0]["source"]);
        $connection_info = self::get_description("connectionType", $usom_info["models"][0]["connectiontype"]);
        if(self::$settings["lang"]=="tr") {
            $searchLang = "tr_";
        } else {
            $searchLang = "en_";
        }

        if($usom_info["totalCount"]) {
            foreach($usom_info["models"] as $model) {
                if($model["url"]==$url) {
                    return [
                        "status" => 0,
                        "url" => $usom_info["models"][0]["url"],
                        "type" => $usom_info["models"][0]["type"],
                        "description" => $description_info[$searchLang."title"],
                        "sourceFrom" => $source_info[$searchLang."title"],
                        "connectionType" => $connection_info[$searchLang."title"],
                        "created_date" => $usom_info["models"][0]["date"],
                        "criticality_level" => $usom_info["models"][0]["criticality_level"]
                    ];
                }
            }

            return [
                "status" => 1
            ];
        } else {
            return [
                "status" => 1
            ];
        }
    }

}
?>