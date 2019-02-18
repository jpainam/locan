<?php

header("Content-type:application/force-download");
header("Content-Description: Transfer de fichier");
header("Content-Disposition:attachment;filename=".  basename($lien));
header("Content-Transfer-Encoding: binary");  
header('Content-Length: ' . filesize($lien));
readfile($lien);