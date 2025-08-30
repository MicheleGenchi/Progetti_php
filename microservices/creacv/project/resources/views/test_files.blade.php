<?php

echo 'file count=', count($_FILES),"\n";
if (isset($_FILES) && !empty($_FILES)) {
    //echo json_encode($_FILES, JSON_PRETTY_PRINT);
    print_r($_FILES);
} else {
    echo "$_FILES è vuoto";
}
echo "\n";
?>