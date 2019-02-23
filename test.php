<?php 
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}

echo ("{
  \"heroesUrl\": \"api/heroes\",
  \"textfile\": \"assets/textfile.txt\"
}");
?>
