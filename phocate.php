<?php
ini_set('memory_limit', '1024M');

$pdo = new PDO('sqlite:phocate.db');
$pdo->exec('CREATE TABLE IF NOT EXISTS namespaces (filename, namespace);');

$directory = new RecursiveDirectoryIterator($argv[1]);
$iterator = new RecursiveIteratorIterator($directory);
$php_files = new RegexIterator(
    $iterator,
    '/^.+\.php$/i',
    RecursiveRegexIterator::GET_MATCH
);

$sql = "BEGIN;\n";
foreach($php_files as $file) {
    $file_path = $file[0];
    $content = file_get_contents($file_path);
    $tokens = token_get_all($content);
    $content = null;
    $ts = array_filter($tokens, function ($token) {
        return is_array($token);
    });
    $tokens = null;
    $ts_with_name = array_map(function ($token) {
        return [
            token_name($token[0]),
            $token[1],
            $token[2]
        ];
    }, $ts);
    $ts = null;
    $in_namespace = false;
    $namespace = '';
    foreach ($ts_with_name as $token) {
        if ($token[0] === 'T_WHITESPACE') {
            continue;
        }
        if ($in_namespace) {
            switch ($token[0]) {
                case 'T_STRING': $namespace .= $token[1]; break;
                case 'T_NS_SEPARATOR': $namespace .= '\\'; break;
                default:
                    $sql .= "INSERT OR REPLACE INTO namespaces VALUES (\"$file_path\", \"$namespace\");";
                    $in_namespace = false;
            }
        }
        if ($token[0] === 'T_NAMESPACE') {
            $in_namespace = true;
        }
    }
}
$sql .= 'END;';
$pdo->exec($sql);