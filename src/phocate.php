<?php
declare(strict_types=1);

namespace Phocate;

use PDO;
use Phocate\File\Directory;

ini_set('memory_limit', '1024M');

require_once __DIR__ . '/../vendor/autoload.php';

$file_p = new FileParser();

$project_dir = new Directory($argv[1]);
$sql = "BEGIN;\n";
$sql .= "CREATE TABLE IF NOT EXISTS namespaces (path TEXT, namespace TEXT);\n";
$sql .= "CREATE TABLE IF NOT EXISTS classes (path TEXT, namespace TEXT,  class_name TEXT);\n";
foreach($project_dir->getPhpFiles() as $php_file) {
    $path = $php_file->getPath();
    $tokens = $php_file->getTokens();
    echo "parsing: $path\n";
    $result = $file_p->parser($path, $tokens);
    foreach ($result->file->namespaces as $namespace) {
        $namespace_name = $namespace->name;
        $sql .= "INSERT OR REPLACE INTO namespaces (path, namespace) VALUES (\"$path\", \"$namespace_name\");";
        foreach ($namespace->classes as $class) {
            $class_name = $class->name;
            $sql .= "INSERT OR REPLACE INTO classes (path, namespace, class_name) VALUES (\"$path\", \"$namespace_name\", \"$class_name\");";
        }
    }
}
$sql .= 'END;';

$pdo = new PDO('sqlite:phocate.db');
$pdo->exec($sql);