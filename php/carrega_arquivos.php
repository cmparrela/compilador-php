<?php
include '../config_path.php';

if ($dir = opendir($GLOBALS['PATH'])) {
  while (false !== ($arquivo = readdir($dir))){
    if (strtolower(substr($arquivo, strrpos($arquivo, '.') + 1)) == 'nex'){
      echo "<span class=\"glyphicon glyphicon-file icone\"></span><a onclick=\"carrega_codigo('$arquivo')\"> $arquivo</a><br>";
    }
  }
}

