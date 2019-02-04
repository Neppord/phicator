<?php
declare(strict_types=1);
namespace Phocate;


use PDO;

class Database {
    /** @var \PDO */
    public $pdo;

    /** @var \PDOStatement */
    public $insert_namespace;
    /** @var \PDOStatement */
    public $insert_class;
    /** @var \PDOStatement */
    public $insert_use;
    /** @var \PDOStatement */
    public $insert_extends;
    /** @var \PDOStatement */
    public $insert_implements;

    public function __construct(string $dsn)
    {
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    public function begin()
    {
        $this->exec('BEGIN');
    }

    private function exec(string $statement): int
    {
        return $this->pdo->exec($statement);
    }

    public function load_schema()
    {
        $schema = file_get_contents(__DIR__ . '/schema.sql');
        $this->exec($schema);
        $this->insert_namespace = $this->pdo->prepare(
            'INSERT OR REPLACE INTO namespace (namespace_path, namespace)' .
            ' VALUES (:namespace_path, :namespace)'
        );
        $this->insert_class = $this->pdo->prepare(
            'INSERT OR REPLACE INTO class (class_path, namespace, FQN, name)' .
            ' VALUES (:class_path, :namespace, :FQN, :name)'
        );
        $this->insert_use = $this->pdo->prepare(
            'INSERT OR REPLACE INTO use (usage_path, namespace, FQN, name)' .
            ' VALUES (:usage_path, :namespace, :FQN, :name)'
        );
        $this->insert_extends = $this->pdo->prepare(
            'INSERT OR REPLACE INTO extends (FQN, super_FQN)' .
            ' VALUES (:FQN, :super_FQN)'
        );
        $this->insert_implements = $this->pdo->prepare(
            'INSERT OR REPLACE INTO implements (FQN, interface_FQN)' .
            ' VALUES (:FQN, :interface_FQN)'
        );
    }

    public function end(): void
    {
        $this->pdo->exec('END;');
    }
}