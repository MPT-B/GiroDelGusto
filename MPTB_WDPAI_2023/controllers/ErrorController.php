<?php
class ErrorController
{
    public function __construct()
    {
    }

    public function handle($error)
    {

        error_log("Error occurred: $error");

        switch ($error) {
            case 'wrong_url':
                $this->wrongUrl();
                break;

            default:
                $this->defaultError();
                break;
        }
    }

    private function wrongUrl()
    {

        http_response_code(404);
        echo "Error 404: The requested URL was not found on this server.";
        exit();
    }



    private function defaultError()
    {

        http_response_code(500);
        echo "Error 500: An internal server error occurred.";
        exit();
    }
}
