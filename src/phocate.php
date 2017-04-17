#! /usr/bin/env php
<?php
declare(strict_types=1);

namespace Phocate;

use PDO;
use Phocate\File\Directory;
use Phocate\Parsing\Data\Usage;
use Phocate\Parsing\FileParser;

ini_set('memory_limit', '1024M');

require_once __DIR__ . '/../vendor/autoload.php';

$file_p = new FileParser();

$project_dir = new Directory($argv[1]);
$pdo = new PDO('sqlite:phocate.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('BEGIN');
$schema = file_get_contents(__DIR__ . '/schema.sql');
$pdo->exec($schema);
$insert_namespace = $pdo->prepare("INSERT OR REPLACE INTO namespace (namespace_path, namespace) VALUES (:namespace_path, :namespace)");
$insert_class = $pdo->prepare("INSERT OR REPLACE INTO class (class_path, namespace, FQN, name) VALUES (:class_path, :namespace, :FQN, :name)");
$insert_use = $pdo->prepare("INSERT OR REPLACE INTO use (usage_path, namespace, FQN, name) VALUES (:usage_path, :namespace, :FQN, :name);");
$insert_extends = $pdo->prepare("INSERT OR REPLACE INTO extends (FQN, super_FQN) VALUES (:FQN, :super_FQN)");
$insert_implements = $pdo->prepare("INSERT OR REPLACE INTO implements (FQN, interface_FQN) VALUES (:FQN, :interface_FQN);");
foreach($project_dir->getPhpFiles() as $php_file) {
    $path = $php_file->getPath();
    $tokens = $php_file->getTokens();
    echo "parsing: $path\n";
    $result = $file_p->parser($path, $tokens);
    foreach ($result->file->namespaces as $namespace) {
        $namespace_name = $namespace->name;
        $insert_namespace->execute([
            ':namespace_path' => $path,
            ':namespace' => $namespace_name
        ]);
        foreach ($namespace->usages as $use) {
            $name = $use->name;
            $FQN = $use->FQN;
            $insert_use->execute([
                ':namespace' => $namespace_name,
                ':usage_path' => $path,
                ':name' => $name,
                ':FQN' => $FQN
            ]);
        }
        foreach ($namespace->classes as $class) {
            $name = $class->name;
            $FQN = "$namespace_name\\$name";
            $insert_class->execute([
                ':class_path' => $path,
                ':namespace' => $namespace_name,
                ':FQN' => $FQN,
                ':name' => $name
            ]);
            if ($class->extends != '') {
                $extends = $class->extends;
                if ($extends[0] === '\\') {
                    $super_FQN = "$extends";
                } else {
                    $usage = $namespace->usages->get($extends);
                    if ($usage instanceof Usage) {
                        $super_FQN = $usage->FQN;
                    } else {
                        $super_FQN = "$namespace_name\\$extends";
                    }
                }
                $insert_extends->execute([
                    ':FQN' => $FQN,
                    ':super_FQN' => $super_FQN
                ]);
            }
            foreach ($class->implements as $interface) {
                if ($interface[0] === '\\') {
                    $interface_FQN = "$interface";
                } else {
                    $usage = $namespace->usages->get($interface);
                    if ($usage instanceof Usage) {
                        $interface_FQN = $usage->FQN;
                    } else {
                        $interface_FQN = "$namespace_name\\$interface";
                    }
                }
                $insert_implements->execute([
                    ':FQN' => $FQN,
                    ':interface_FQN' => $interface_FQN
                ]);
            }
        }
    }
}
$pdo->exec('END;');
