#! /usr/bin/env php
<?php
declare(strict_types=1);

namespace Phocate;

use PDO;

ini_set('memory_limit', '1024M');

require_once __DIR__ . '/../vendor/autoload.php';
$in = $argv[1];
$like = '%';
for($i = 0; isset($in[$i]); $i += 1) {
    $like .= $in[$i] . '%';
}
$pdo = new PDO('sqlite:phocate.db');
$stmt = $pdo->prepare(
    "SELECT class_path, usage_path, FQN FROM use JOIN class USING (FQN) WHERE FQN LIKE ? "
);
$stmt->execute([$like]);
$results = $stmt->fetchAll();
if (empty($results)) {
    echo "No usages found\n";
} else {
    foreach($results as $result) {
        $FQN = $result['FQN'];
        $class_path = $result['class_path'];
        $usage_path = $result['usage_path'];
        echo "class $FQN in file $class_path is used in $usage_path\n";
    }
}
