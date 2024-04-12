<?php
include('conexao.php');

if(isset($_GET['path'])) {
    $path = urldecode($_GET['path']); 

    $sql = "SELECT * FROM arquivos WHERE path = '$path'";
    $result = $mysqli->query($sql);
    $arquivo = $result->fetch_assoc();

    if($arquivo) {
        if(unlink($arquivo['path'])) {
            $sql = "DELETE FROM arquivos WHERE path = '$path'";
            $result = $mysqli->query($sql);
            if($result) {
                echo "Arquivo e registro excluídos com sucesso.";
                //header('Location: index.php');
                echo "<br><a href='index.php'>Voltar para servidor de arquivos</a>";
            } else {
                echo "Erro ao deletar registro no banco de dados: " . $mysqli->error;
            }
        } else {
            echo "Erro ao excluir o arquivo do diretório.";
        }
    } else {
        echo "Arquivo não encontrado.";
    }
} else {
    echo "Caminho do arquivo não fornecido para exclusão.";
}
?>
