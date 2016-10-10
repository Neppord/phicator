<?php
declare(strict_types=1);

namespace Phocate;

use PDO;
use Phocate\File\Directory;

ini_set('memory_limit', '1024M');

require_once __DIR__ . '/../vendor/autoload.php';

$namespace_stmt_p = new NamespaceStmtParser();
$class_stmt_p = new ClassStmtParser();

$project_dir = new Directory($argv[1]);
$sql = "BEGIN;\n";
$sql .= "CREATE TABLE IF NOT EXISTS namespaces (path TEXT, namespace TEXT);\n";
$sql .= "CREATE TABLE IF NOT EXISTS classes (path TEXT, class_name TEXT);\n";
foreach($project_dir->getPhpFiles() as $php_file) {
    $path = $php_file->getPath();
    $tokens = $php_file->getTokens();
    echo "parsing: $path\n";
    while (!$tokens->nil()) {
        $result = $namespace_stmt_p->parse($tokens);
        if ($result === null) {
            $result = $class_stmt_p->parse($tokens);
            if ($result === null) {
                $tokens = $tokens->tail();
            } else {
                $class_name = $result->result;
                $tokens = $result->tokens;
                $sql .= <<<SQL
INSERT OR REPLACE INTO classes (path, class_name)
VALUES ("$path", "$class_name");\n
SQL;
            }
        } else {
            $namespace = $result->result;
            $tokens = $result->tokens;
            $sql .= <<<SQL
INSERT OR REPLACE INTO namespaces (path, namespace)
VALUES ("$path", "$namespace");\n
SQL;
        }
    }
}
$sql .= 'END;';

$pdo = new PDO('sqlite:phocate.db');
$pdo->exec($sql);