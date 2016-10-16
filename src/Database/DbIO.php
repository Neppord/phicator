<?php


namespace Phocate\Database;

use PDO;

abstract class DbIO
{
    abstract public function run(PDO $pdo): DbResult;
    abstract public function map(callable $closure): DbIO;
    abstract public function biMap(): DbIO;
    abstract public function bind(callable $closure): DbIO;
    abstract public function recover(callable $closure): DbIO;
}