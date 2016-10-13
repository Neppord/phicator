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
$sql .= "CREATE TABLE IF NOT EXISTS namespaces (namespace_path TEXT, namespace TEXT);\n";
$sql .= "CREATE TABLE IF NOT EXISTS usages (usage_path TEXT, namespace TEXT, FQN TEXT, name TEXT);\n";
$sql .= "CREATE TABLE IF NOT EXISTS classes (class_path TEXT, namespace TEXT, FQN TEXT, name TEXT);\n";
$sql .= "CREATE TABLE IF NOT EXISTS extends (FQN TEXT, super_FQN TEXT);\n";
foreach($project_dir->getPhpFiles() as $php_file) {
    $path = $php_file->getPath();
    $tokens = $php_file->getTokens();
    echo "parsing: $path\n";
    $result = $file_p->parser($path, $tokens);
    foreach ($result->file->namespaces as $namespace) {
        $namespace_name = $namespace->name;
        $sql .= "INSERT OR REPLACE INTO namespaces (namespace_path, namespace) VALUES (\"$path\", \"$namespace_name\");\n";
        foreach ($namespace->usages as $use) {
            $name = $use->name;
            $FQN = $use->FQN;
            $sql .= "INSERT OR REPLACE INTO usages (usage_path, namespace, FQN, name) VALUES (\"$path\", \"$namespace_name\", \"$FQN\", \"$name\");\n";
        }
        foreach ($namespace->classes as $class) {
            $name = $class->name;
            $FQN = "$namespace_name\\$name";
            $sql .= "INSERT OR REPLACE INTO classes (class_path, namespace, FQN, name) VALUES (\"$path\", \"$namespace_name\", \"$FQN\", \"$name\");\n";
            if ($class->extends != '') {
                $extends = $class->extends;
                if ($extends[0] === '\\') {
                    $super_FQN = "$extends";
                } else {
                    $super_FQN = "$namespace_name\\$extends";
                    foreach($namespace->usages as $usage) {
                        if ($usage->name === $extends) {
                            $super_FQN = $usage->FQN;
                        }
                    }
                }
                $sql .= "INSERT OR REPLACE INTO extends VALUES (\"$FQN\", \"$super_FQN\");\n";
            }
        }
    }
}
$sql .= 'END;';

$pdo = new PDO('sqlite:phocate.db');
$pdo->exec($sql);