<?php
include ('conexao.php');
$_FILES['arquivo'];

if (isset($_FILES['arquivo'])) {
    $max_lenght = 2097152;
    $arquivo = $_FILES['arquivo'];
    var_dump($arquivo);

    if ($arquivo['error'])
        die("Falha ao enviar o arquivo");

    if ($arquivo['size'] > $max_lenght)
        die("Arquivo muito grande. Tamanho maximo 2MB");

    $pasta = 'arquivos/';
    $nomeDoArquivo = $arquivo['name'];

    $nomeUnicoArquivo = uniqid();

    $extensao = strtolower((pathinfo($nomeDoArquivo, PATHINFO_EXTENSION)));

    if ($extensao != 'jgp' && $extensao != 'png')
        die("Tipo de arquivo não aceito.");

    //echo `<br> Nome temporario : {$arquivo['']} <br>`;

    $destino = $pasta . $nomeUnicoArquivo . "." . $extensao;

    $deuCerto = move_uploaded_file($arquivo['tmp_name'], $destino);

    if ($deuCerto) {
        $mysqli->query("INSERT INTO arquivos(nome,path) VALUES('$nomeDoArquivo', '$destino')") or die($mysqli->error);
        echo "link para o arquivo-><a target='_blank' href='arquivos/$nomeUnicoArquivo.$extensao'>Clique Aqui</a>";
    } else {
        echo "Falha ao enviar o arquivo";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!--enctype::especificar como os dados do formulário serão codificados 
    antes de serem enviados para o servidor web.
    Usado quando o formulário envia arquivos ou dados binários. 
    Ele divide os dados em várias partes e os codifica em uma forma que pode 
    ser enviada com segurança. 
    Este valor geralmente é usado quando o formulário contém um campo input 
    com o atributo type definido como "file"
    -->
    <form enctype="multipart/form-data" method="post">
        <p><label for="">Selecione o arquivo</label>
            <!--adicionar MULTIPLE para adicionar multiplos arquivos
            alterar nome arquivo para :: arquivo[]
        -->
            <input type="file" name="arquivo">
        </p>
        <button type="submit">Enviar arquivo</button>
    </form>

    <h1>Lista de Arquivos</h1>
    <table border="1" cellpadding="10">
        <thead>
            <th>Preview</th>
            <th>Arquivo</th>
            <th>Data de Envio</th>
            <th>Excluir</th>
        </thead>
        <tbody>
            <?php
            //Consultar arquivos enviados
            $sql_query = $mysqli->query("SELECT * FROM arquivos") or die($mysqli->error);
            while ($arquivo = $sql_query->fetch_assoc()) {
                ?>
                <tr>
                    <td><img height="50" src="<?php echo $arquivo['path']; ?>" alt=""></td>
                    <td><a target="_blank" href="<?php echo $arquivo['path']; ?>"><?php echo $arquivo['nome']; ?></a></td>
                    <td><?php echo date("d/m/Y H:i", strtotime($arquivo['data_upload'])); ?></td>
                    <td><a href="delete.php?path=<?php echo urlencode($arquivo['path']); ?>">excluir</a></td>

                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

</body>

</html>








<!-- 

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <p>
            <label for="">Selecione o arquivo
                <input type="file" name="arquivo" id="">
            </label>
            <button type="submit">Enviar arquivo</button>
        </p>
    </form>
</body>

</html> -->