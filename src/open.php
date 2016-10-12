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
$stmt = $pdo->prepare("SELECT path FROM classes WHERE FQN LIKE ?");
$stmt->execute([$like]);
$results = $stmt->fetchAll();
if (empty($results)) {
    echo "No Class matched\n";
} else {
    $path = $results[0]['path'];
    passthru('$EDITOR "' . $path . '"');
}
