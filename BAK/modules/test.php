<?php

class RestAPI
{
    /*
     *  Custom REST API class for Vivace Framework
     */

    protected $method;
	protected $request_data;

    public function __construct()
    {
        // Determine HTTP method
        $this->verifyMethod();
    }

    // Functions for Making RESTful API Requests (text/json/xml)
    public function makeRequest($url, $data_string, $method="GET", $content_type="form")
    {
        $ch = curl_init();

        // GET Request via PHP Curl
        if ($method=='GET')
        {
            curl_setopt($ch, CURLOPT_URL, $url."?".$data_string);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }

        // POST Request via PHP Curl
        if ($method=='POST')
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Determine the correct content type
            if ($content_type=="form")
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/x-www-form-urlencoded')
                );
            }
            else if ($content_type=="json")
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );
            }
            else if ($content_type=="xml")
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: text/xml',
                    'Content-Length: ' . strlen($data_string))
                );
            }
            else
            {
                $this->setResponse('415', 'Unsupported Content Type');
            }
        }

        $result = curl_exec($ch);

        if (curl_errno($ch))
        {
            echo "CURL Error: ".curl_errno($ch);
            exit();
        }

        return $result;
    }

    // Functions for Receiving RESTful API Requests
    public function getMethod()
    {
        return $this->method;
    }

    public function getRequestData()
    {
        return $this->request_data;
    }

    public function verifyMethod()
    {
        // Set HTTP method of request
        if ($_SERVER['REQUEST_METHOD']=="GET")
        {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->request_data = $_GET;
        }
        else if ($_SERVER['REQUEST_METHOD']=="POST")
        {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->request_data = json_decode(file_get_contents("php://input"),1);
        }
        else
        {
            $this->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

    public function authenticate()
    {
        Core::requireModel('app');

        $app = new AppModel();
        $verify = $app->verifyCredentials($this->request_data);

        if ($verify['Status']=="OK")
        {
            return "OK";
        }
        else if ($verify['Status']=="INVALID_IP")
        {
            $this->setResponse('401', 'Invalid Client IP Address');
        }
        else if ($verify['Status']=="INVALID_REQUEST")
        {
            $this->setResponse('401', 'Invalid Request');
        }
        else if ($verify['Status']=="INVALID_APP")
        {
            $this->setResponse('401', 'Invalid App Credentials');
        }
    }

    public function setResponse($code, $message, $content=NULL, $exit=TRUE)
    {
        header('HTTP/1.1 '.$code.' '.$message);
        header('Content-Type: application/json; charset=utf-8');

        if ($code=="200")
        {
            // Return content
            echo $content;
        }
        else
        {
            // Return error
            $error = array("Code" => $code, "Message" => $message);
            $error = json_encode($error);

            echo $error;
        }

        if ($exit==TRUE)
        {
            exit();
        }
    }
}


function sendSMS()
{
    $restapi = new RestAPI();
    // JSON Post
    $url = $_SERVER["SERVER_NAME"];

    $parsedUrl = parse_url($url);

    $host = explode('.', $parsedUrl['host']);

    $subdomain = $host[0];
    
    $data_string = "subdomain=".$subdomain;

    $param = $restapi->makeRequest("http://yessys33.com/api/config/getdata", $data_string, "GET");
}

sendSMS();

