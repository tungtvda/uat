<?php
require("../../../public_html/classes/base.model.php");

class AutoDNS
{
    public function request()
    {
        $restapi = new RestAPI();
        // JSON Post
        $data_string = array(
              "sub-auth-id" => '32',
              "auth-password" => 'yessys33###'
        );

        echo "Checkpoint";

        $param = $restapi->makeRequest("https://api.cloudns.net/dns/available-name-servers.json", $data_string, "POST");

        echo "Response:".$param;
    }
}

$test = new AutoDNS();

$test->request();

?>