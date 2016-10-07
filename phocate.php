<?php
declare(strict_types=1);

namespace Phocate;

use PDO;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

ini_set('memory_limit', '1024M');


/**
 * @param $path
 * @return RegexIterator
 */
function get_php_files($path)
{
    $directory = new RecursiveDirectoryIterator($path);
    $iterator = new RecursiveIteratorIterator($directory);
    $php_files = new RegexIterator(
        $iterator,
        '/^.+\.php$/i',
        RecursiveRegexIterator::GET_MATCH
    );
    return $php_files;
}
/**
 * @param $file_path
 * @return array
 */
function get_tokens($file_path)
{
    $content = file_get_contents($file_path);
    $tokens = token_get_all($content);
    $content = null;
    $ts = array_filter($tokens, 'is_array');
    $tokens = null;
    $ts_with_name = array_map(function ($t) {
        return [token_name($t[0]), $t[1], $t[2]];
    }, $ts);
    $ts = null;
    return $ts_with_name;
}

$sql = "CREATE TABLE IF NOT EXISTS namespaces (filename, namespace);\n";
$sql .= "BEGIN;\n";
foreach(get_php_files($argv[1]) as $file) {
    $file_path = $file[0];
    $tokens = get_tokens($file_path);
    $in_namespace = false;
    $namespace = '';
    foreach ($tokens as $token) {
        if ($token[0] === 'T_WHITESPACE') {
            continue;
        }
        if ($in_namespace) {
            switch ($token[0]) {
                case 'T_STRING': $namespace .= $token[1]; break;
                case 'T_NS_SEPARATOR': $namespace .= '\\'; break;
                default:
                    $sql .= "INSERT OR REPLACE INTO namespaces VALUES (\"$file_path\", \"$namespace\");\n";
                    $in_namespace = false;
            }
        }
        if ($token[0] === 'T_NAMESPACE') {
            $in_namespace = true;
        }
    }
}
$sql .= 'END;';

$pdo = new PDO('sqlite:phocate.db');
$pdo->exec($sql);