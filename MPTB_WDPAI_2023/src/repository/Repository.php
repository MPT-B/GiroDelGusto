<?php
require_once __DIR__ . '/../Database.php';
require_once 'Query.php';

class Repository
{
    protected $database;
    protected $query;

    public function __construct(Query $query)
    {
        $db = Database::getInstance();
        $this->database = $db->connect();
        $this->query = $query;
    }
}
