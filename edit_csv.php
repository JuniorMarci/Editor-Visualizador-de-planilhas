<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Estilo.css" media="screen" />
    <title>
        <?php
        if (isset($_GET['file'])) {
            echo htmlspecialchars(pathinfo($_GET['file'], PATHINFO_FILENAME));
        } else {
            echo "CSV Editor";
        }
        ?>
    </title>
    <style>
        /* Estilos CSS */
    </style>
</head>
<body>
<button class="botaoAcao" onclick="location.href='http://sis-qa.kesug.com'" type="button">
    <
</button> 
    <h1 style="font-family: Arial">
        <?php
        if (isset($_GET['file'])) {
            echo htmlspecialchars(pathinfo($_GET['file'], PATHINFO_FILENAME));
        } else {
            echo "CSV Editor";
        }
        ?>
    </h1>
    <form method="post">
        <table>
            <?php
            if (isset($_GET['file']) && file_exists($_GET['file'])) {
                $file = fopen($_GET['file'], 'r');
                // Header row
                if (($header = fgetcsv($file)) !== false) {
                    echo "<tr>";
                    foreach ($header as $col) {
                        echo "<th>" . htmlspecialchars($col) . "</th>";
                    }
                    echo "</tr>";
                }
                // Data rows
                $rows = [];
                $rowNumber = 0;
                while (($row = fgetcsv($file)) !== false) {
                    $rows[] = $row;
                    echo "<tr>";
                    foreach ($row as $colIndex => $col) {
                        echo "<td><input type='text' name='data[$rowNumber][$colIndex]' value='" . htmlspecialchars($col) . "'></td>";
                    }
                    echo "</tr>";
                    $rowNumber++;
                }
                fclose($file);

                // Salvamento do arquivo
                if (isset($_POST['save'])) {
                    $file = $_POST['file'];
                    $data = $_POST['data'];
                    $fileHandle = fopen($file, 'w');
                    if ($fileHandle !== false) {
                        // Escrever cabeçalho
                        fputcsv($fileHandle, $header);
                        // Escrever linhas de dados
                        foreach ($data as $row) {
                            fputcsv($fileHandle, $row);
                        }
                        fclose($fileHandle);
                        echo "<p>Arquivo salvo com sucesso.</p>";
                    } else {
                        echo "<p>Falha ao salvar o arquivo.</p>";
                    }
                }
            } else {
                echo "<p>Arquivo não encontrado.</p>";
            }
            ?>
        </table>
        <br><br><br><br><br>
        <input type="hidden" name="file" value="<?php echo htmlspecialchars($_GET['file']); ?>">
        <div style="position: fixed; bottom: 0; left: 0; width: 100%; background-color: #000; color: #fff; padding: 10px 0; text-align: center;">
            <button style="background-color: transparent; border: none; color: #fff; font-size: 18px; cursor: pointer;" type="submit" name="save">Salvar</button>
        </div>
    </form>
</body>
</html>
