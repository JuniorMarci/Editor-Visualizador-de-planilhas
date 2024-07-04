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
            echo "CSV Viewer";
        }
        ?>
    </title>
    
</head>
<body>

<div style="font-family: Arial">
<button class="botaoAcao" onclick="location.href='http://sis-qa.kesug.com'" type="button">
    <
</button>    <h1>
        <?php
        if (isset($_GET['file'])) {
            echo htmlspecialchars(pathinfo($_GET['file'], PATHINFO_FILENAME));
        } else {
            echo "CSV Viewer";
        }
        ?>
    </h1>
        <!-- Adicionar o botão de Download -->
        <?php if (isset($_GET['file'])) : ?>
            <form action="download.php" method="post">
                <input type="hidden" name="file" value="<?php echo htmlspecialchars($_GET['file']); ?>">
                <label for="delimiter">Separador CSV:</label>
                <select name="delimiter" id="delimiter">
                    <option value=",">Vírgula (,)</option>
                    <option value=";">Ponto e vírgula (;)</option>
                    <option value="|">Barra vertical (|)</option>
                </select>
                <label for="encoding">Codificação:</label>
                <select name="encoding" id="encoding">
                    <option value="UTF-8">UTF-8</option>
                    <option value="UTF-16">UTF-16</option>
                    <option value="ISO-8859-1">Latin (ISO-8859-1)</option>
                    <option value="ISO-8859-15">ISO-8859-15</option>
                    <option value="Windows-1252">ANSI (Windows-1252)</option>
                </select>
                <button class="botaoAcao" type="submit">Baixar</button>
            </form>
        <?php endif; ?>
        </div>

    <?php
    if (isset($_GET['file']) && file_exists($_GET['file'])) {
        $file = fopen($_GET['file'], 'r');
        echo "<table id='csvTable'>";
        // Header row
        if (($header = fgetcsv($file)) !== false) {
            echo "<tr>";
            foreach ($header as $index => $col) {
                echo "<th>" . htmlspecialchars($col) . " <button class='filter-btn' onclick='toggleFilter($index)'>⧩</button><br><input class='filter-input' type='text' onkeyup='filterTable()' placeholder='Filter...'></th>";
            }
            echo "</tr>";
        }
        // Data rows
        while (($row = fgetcsv($file)) !== false) {
            echo "<tr>";
            foreach ($row as $col) {
                echo "<td>" . htmlspecialchars($col) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        fclose($file);
    } else {
        echo "<p>File not found.</p>";
    }
    ?>
    <script>
        function toggleFilter(index) {
            var inputs = document.getElementsByClassName('filter-input');
            inputs[index].style.display = inputs[index].style.display === 'none' ? 'block' : 'none';
        }

        function filterTable() {
            var table = document.getElementById("csvTable");
            var tr = table.getElementsByTagName("tr");
            var inputs = document.getElementsByClassName('filter-input');
            var filters = Array.from(inputs).map(input => input.value.toUpperCase());
            
            // Loop through all table rows
            for (var i = 1; i < tr.length; i++) {
                var display = true;
                // Loop through all table cells
                for (var j = 0; j < filters.length; j++) {
                    var td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        var txtValue = td.textContent || td.innerText;
                        if (filters[j] && txtValue.toUpperCase().indexOf(filters[j]) === -1) {
                            display = false;
                            break;
                        }
                    }
                }
                tr[i].style.display = display ? "" : "none";
            }
        }
    </script>
</body>
</html>
