<?php


namespace Ling\Light\Http;


/**
 * The HttpJsonResponse class.
 *
 */
class HttpJsonResponse extends HttpResponse
{

    /**
     * Creates and returns the http json response instance.
     *
     *
     * @param mixed $data
     * The raw data. Note: this method will convert it to json internally.
     *
     *
     *
     * Note: this method has no benefit over a regular constructor, but I keep it for legacy purpose.
     *
     *
     * @return $this
     */
    public static function create($data)
    {
        return new static($data);
    }


    /**
     * @overrides
     */
    protected function displayBody()
    {
        echo json_encode((string)$this->body);
    }


    /**
     * @overrides
     */
    protected function sendHeaders()
    {
        $this->setHeader("Content-type", 'application/json');
        return parent::sendHeaders();
    }


}