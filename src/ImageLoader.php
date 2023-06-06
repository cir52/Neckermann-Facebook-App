<?php
echo "<?xml version=\"1.0\" ?>\n";
$ordner = "produktbilder/";

$dh = opendir($ordner);
while ($bild = readdir($dh)){
 if ((stristr($bild,".jpg")) || (stristr($bild,".png"))||(stristr($bild,".bmp"))){ 
  echo "<bild>".$bild."</bild>";
  }
}
?>