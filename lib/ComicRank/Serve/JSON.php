<?php
namespace ComicRank\Serve;

/**
 * Represents a JSON page generated for client
 */
class JSON extends HTTP
{
    /**
     * Initiate HTTP headers
     */
    public function __construct()
    {
        parent::__construct();
        $this->headers['Content-Type'] = 'text/json';
    }

    /**
     * Set HTTP status code, display info
     *
     * Must only be called before anything has been output
     *
     * @param int $statuscode   HTTP statuscode to apply
     * @param array $output     Output info
     */
    public function exitDisplay($statuscode, array $output = array())
    {
        $this->statuscode = $statuscode;
        $this->outputHeaders();
        echo json_encode($output);
        exit;
    }
}
