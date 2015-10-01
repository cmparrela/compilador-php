<!DOCTYPE html>
<?php 
  include '../config_path.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $dir        = $GLOBALS['PATH'];
            $arquivo    = $dir.'/'. basename($_FILES['path_arquivo']['name']);

            if (move_uploaded_file($_FILES['path_arquivo']['tmp_name'], $arquivo)) {
                $mensagem = ['COD'=> '0', 'NOME' => basename($_FILES['path_arquivo']['name'])];
            } else {
                $mensagem = ['COD'=> '1'];
            }
        ?>
    </body>
    <script>
        parent.retorno_upload('<?= json_encode($mensagem); ?>');
    </script>
</html>
