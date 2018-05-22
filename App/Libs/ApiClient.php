<?php

namespace App\Libs;

use Exception;
use GuzzleHttp;

class ApiClient
{
    protected $httpClient,
                $params,
                $fixedParams,
                $endpoint;

    function __construct($endpoint=null,$fixedParams = [])
    {
        
        $this->httpClient  = new GuzzleHttp\Client();
        $this->apiResponse = new ApiResponse();
        $this->endpoint    = env('api_url','http://sewerage-api.com/v1');
        $this->fixedParams = array_merge([
                                '_app_id'       => 'GPS_API',
                                '_company_id'   => 'FREELANCER',
                                ],
                                $fixedParams);
       
    }

    function set($key, $value)
    {
            
        $this->params[$key] = $value;
        return $this;
    }

    function params($params)
    {
        $this->params = $params;
        return $this;
    }

    function getParams()
    {
        if (!$this->params) throw new Exception('Params are not set.');
        $params = array_merge($this->params,$this->fixedParams);
        return $params;
    }

    function convertToQueryStringArray($arr, $valueCallback = null)
    {
      
        $builtArgs = explode('&', http_build_query($arr));
        $vals      = [];
        foreach ($builtArgs as $arg) {
            $args                  = explode('=', $arg);
            if (count($args) != 2) continue;
            list($key, $val) = $args;
            $value                 = urldecode($val);
            $value                 = is_callable($valueCallback) ? call_user_func($valueCallback,
                    $value) : $value;
            $vals[urldecode($key)] = $value;
        }
        return $vals;
    }

    function getMultipart()
    {
        $params = $this->convertToQueryStringArray($this->getParams());

        $multipart   = [];
        foreach ($params as $fieldName => $fieldValue)
            $multipart[] = [
                'name' => $fieldName,
                'contents' => $fieldValue,
            ];
        return $multipart;
    }

    function reset()
    {
        $this->params = null;
        return $this;
    }

    function target($string){
        list($object,$api) = explode('/',str_replace('\\', '/', $string));
        return $this->set('api',$api)
                    ->set('object',$object);
    }

    function exec($toArray=false)
    {
        $response = $this->httpClient->request('POST', $this->endpoint, [
            'multipart' => $this->getMultipart(),
            'curl'      => [CURLOPT_SSL_VERIFYPEER => false]
        ]);
        
        $this->reset();

        $contents = $response->getBody()->getContents();
        $parsed   = json_decode($contents, $toArray);
        if ($toArray) {
            return $parsed;
        }
        if (!$parsed)
                throw new Exception('Unable to parse json response > '.$contents);
        return $this->apiResponse->newInstance($parsed);
    }
}