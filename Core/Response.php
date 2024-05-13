<?php

namespace Core;

class Response
{
    private $status = 200;

    /**
     * Get status
     * 
     * @param int $code
     *
     * @return Response
     */
    public function status(int $code)
    {
        $this->status = $code;
        return $this;
    }
    
    /**
     * Data to JSON
     * 
     * @param array $data
     *
     * @return string
     */
    public function toJSON($data = [])
    {
        http_response_code($this->status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}