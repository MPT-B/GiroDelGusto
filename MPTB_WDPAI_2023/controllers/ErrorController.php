<?php
class ErrorController
{
    public function __construct()
    {
    }

    public function handle($error)
    {
        switch ($error) {
            case 'wrong_url':
                $this->wrongUrl();
                break;
                // Add more cases as needed
            default:
                $this->defaultError();
                break;
        }
    }

    private function wrongUrl()
    {
        // Handle wrong url error here
        // You can render a view or return a response
        echo "Wrong url!";
        exit();
    }

    // Add more error handling methods as needed

    private function defaultError()
    {
        // Handle default error here
        echo "An error occurred!";
        exit();
    }
}
