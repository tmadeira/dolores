<?php
/**
 * Based on https://github.com/drewm/mailchimp-api
 * Modified to support "fire and forget" (http://bit.ly/1Mo4WGC)
 */

class DoloresMailChimp {
  private $api_key;
  private $api_host = "<dc>.api.mailchimp.com";
  private $api_path = "/2.0";

  public function __construct($api_key) {
    $this->api_key = $api_key;
    list(, $datacentre) = explode('-', $this->api_key);
    $this->api_host = str_replace('<dc>', $datacentre, $this->api_host);
  }

  public function validateApiKey() {
    $request = $this->call('helper/ping');
    return !empty($request);
  }

  public function call($method, $args = array(), $timeout = 10) {
    return $this->makeRequest($method, $args, $timeout);
  }

  public function fireAndForget($method, $args = array()) {
    $args['apikey'] = $this->api_key;

    $path = $this->api_path . '/' . $method . '.json';
    $json_data = json_encode($args);

    $fp = fsockopen("ssl://" . $this->api_host, 443, $errno, $errstr, 30);

    $output = "POST {$path} HTTP/1.1\r\n";
    $output.= "Host: {$this->api_host}\r\n";
    $output.= "Content-Type: application/json\r\n";
    $output.= "Content-Length: " . strlen($json_data) . "\r\n";
    $output.= "User-Agent: PHP-MCAPI/2.0\r\n";
    $output.= "\r\n";
    $output.= $json_data;

    fwrite($fp, $output);
    fclose($fp);
  }

  private function makeRequest($method, $args = array(), $timeout = 10) {
    $args['apikey'] = $this->api_key;

    $url = "https://" . $this->api_host . $this->api_path . '/' . $method . '.json';
    $json_data = json_encode($args);

    if (function_exists('curl_init') && function_exists('curl_setopt')) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
      $result = curl_exec($ch);
      curl_close($ch);
    } else {
      $result    = file_get_contents($url, null, stream_context_create(array(
        'http' => array(
          'protocol_version' => 1.1,
          'user_agent'       => 'PHP-MCAPI/2.0',
          'method'           => 'POST',
          'header'           => "Content-type: application/json\r\n".
          "Connection: close\r\n" .
          "Content-length: " . strlen($json_data) . "\r\n",
            'content'          => $json_data,
          ),
        )));
    }

    return $result ? json_decode($result, true) : false;
  }
};
