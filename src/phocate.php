<?php
declare(strict_types=1);

namespace Phocate;

use PDO;
use Phocate\File\Directory;

ini_set('memory_limit', '1024M');

require_once __DIR__ . '/../vendor/autoload.php';

$project_dir = new Directory($argv[1]);
$sql = "BEGIN;\n";
$sql .= "CREATE TABLE IF NOT EXISTS namespaces (path TEXT, namespace TEXT);\n";
$sql .= "CREATE TABLE IF NOT EXISTS classes (path TEXT, namespace TEXT, classname TEXT);\n";
foreach($project_dir->getPhpFiles() as $php_file) {
    $path = $php_file->getPath();
    $tokens = $php_file->getTokens();
    echo "parsing: $path\n";
    $in_namespace = false;
    $namespace = '';
    while (!$tokens->nil()) {
        $token = $tokens->head();
        if ($in_namespace) {
            switch ($token->type) {
                case T_WHITESPACE: break;
                case T_STRING: $namespace .= $token->contents; break;
                case T_NS_SEPARATOR: $namespace .= '\\'; break;
                default:
                    $sql .= "INSERT OR REPLACE INTO namespaces (path, namespace) VALUES (\"$path\", \"$namespace\");\n";
                    $in_namespace = false;
            }
        }
        if ($token->type === T_NAMESPACE) {
            $in_namespace = true;
        }
        $tokens = $tokens->tail();
    }
}
$sql .= 'END;';

$pdo = new PDO('sqlite:phocate.db');
$pdo->exec($sql);