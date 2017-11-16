<?php

namespace NucleusPhp\DataHub;

class App
{

    /**
     * @var \Psr\Http\Message\RequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Run app
     */
    public function run()
    {
        $this->request = new Http\Request();
        $this->response = new Http\Response();
        $this->response->setRequest($this->request);

        try {
            $this->handle();
            $this->output();

        } catch(\Exception $exception) {
            $this->error($exception);
        }
    }

    protected function getRequest()
    {

    }

    /**
     * Handle application request and build response
     */
    public function handle()
    {
        // Handle request
    }

    /**
     * Output response
     */
    public function output()
    {
        // Send output
    }

    /**
     * Handle application errors
     *
     * @param \Exception $exception
     */
    public function error(\Exception $exception)
    {
        // Handle errors
    }

}
