<?php
class AppController
{
    private static $instance = null;
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new AppController();
        }
        return self::$instance;
    }

    public function isGet(): bool
    {
        return $this->request === 'GET';
    }

    public function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'src/views/' . $template . '.php';

        $output = 'File not found';

        if (file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }

    protected function checkSession()
    {
        session_start();

        $inactive = 3600; // 1 hour

        if (isset($_SESSION['timeout'])) {
            $session_life = time() - $_SESSION['timeout'];
            if ($session_life > $inactive) {
                session_destroy();
                header('Location: /login');
                exit;
            }
        }

        $_SESSION['timeout'] = time();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $fullUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/';
            header('Location: ' . $fullUrl . 'login');
            exit;
        }
    }
}
