<?php

namespace App\Libs;

use Exception;

class ApiResponse
{
    protected $source;

    function newInstance($source)
    {
        $instance = new self();
        $instance->setSource($source);
        return $instance;
    }

    function setSource($source)
    {
        $this->source = $source;
    }

    function getSource()
    {
        if (!$this->source) throw new \Exception('Source is not set.');
        return $this->source;
    }

    function success()
    {
        return ($this->getSource()->STATUS == 'SUCCESS');
    }

    function failed()
    {
        return !$this->success();
    }

    function response()
    {
        return $this->getSource()->RESPONSE;
    }

    function errors()
    {
        return $this->getSource()->ERRORS;
    }

    function hasErrorCode($code)
    {
        $codes = $this->errors();
        $code  = $code.'';
        return property_exists($codes, $code);
    }

    function prettyJson()
    {
        return json_encode($this->getSource(), JSON_PRETTY_PRINT);
    }
}