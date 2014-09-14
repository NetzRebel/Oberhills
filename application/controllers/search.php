<?php

class Search extends MY_Controller
{
    public function index()
    {
        require_once FCPATH . 'vendor/autoload.php';
        $client = new GuzzleHttp\Client();
        
        $requests = array(
            $client->createRequest('GET', 'http://httpbin.org'),
            $client->createRequest('DELETE', 'http://httpbin.org/delete'),
            $client->createRequest('PUT', 'http://httpbin.org/put', ['body' => 'test'])
        );

        $client->sendAll($requests, array(
            'complete' => function (GuzzleHttp\Event\CompleteEvent $event) {
                echo 'Completed request to ' . $event->getRequest()->getUrl() . "\n";
                echo 'Response: ' . $event->getResponse()->getBody() . "\n\n";
                // Do something with the completion of the request...
            },
            'error' => function (ErrorEvent $event) {
                echo 'Request failed: ' . $event->getRequest()->getUrl() . "\n";
                echo $event->getException();
                // Do something to handle the error...
            }
        ));
        die();
    }
}