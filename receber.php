<?php
if(isset($_POST['upload'])) {
    $nome_arquivo = basename($_FILES["file"]["name"]);
    $diretorio_atual = getcwd();

    // Caminho do arquivo a ser carregado
    $caminho_arquivo = $diretorio_atual . '/' . $nome_arquivo;

    // Tenta mover o arquivo para o diretório atual
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $caminho_arquivo)) {
        echo "O arquivo ". $nome_arquivo . " foi carregado com sucesso.";
    } else {
        echo "Desculpe, houve um erro ao carregar seu arquivo.";
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<form method="post" enctype="multipart/form-data">
    Selecione o arquivo para fazer upload:
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload" name="upload">
</form>

</body>
</html>
