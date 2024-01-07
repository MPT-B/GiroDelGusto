<?php
class ErrorController
{
    public function handle($error)
    {
        error_log("Error occurred: $error");

        switch ($error) {
            case 'wrong_url':
                $this->sendErrorResponse(404, "The requested URL was not found on this server.");
                break;

            default:
                $this->sendErrorResponse(500, "An internal server error occurred.");
                break;
        }
    }

    private function sendErrorResponse($code, $message)
    {
        http_response_code($code);
        echo "Error {$code}: {$message}";
        exit();
    }
}
