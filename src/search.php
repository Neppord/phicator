<?php
// Save screen
fwrite(STDOUT, "\033[?47h");
// Save position
fwrite(STDOUT, "\0337");
$chars = [];
$c = '';
while ($c !== "\n") {
    $c = fgetc(STDIN);
    $chars[] = $c;
}
// Clear line
fwrite(STDOUT, "\033[2K");
// Restore position
fwrite(STDOUT, "\0338");
// Save position
fwrite(STDOUT, "\0337");
fwrite(STDOUT, implode('%', $chars));
fgetc(STDIN);
// Restore screen
fwrite(STDOUT, "\033[?47l");
