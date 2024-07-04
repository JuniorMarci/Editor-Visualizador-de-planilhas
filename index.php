<?php
$files = glob("*.csv");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Estilo.css" media="screen" />
    <title>CSV Viewer</title>
</head>
<body>
    <h1>CSV Files</h1>

    <label for="prefixFilter" style="font-family:Arial">Mostrar:</label>
    <select id="prefixFilter" style="font-family:Arial">
        <option value="" style="font-family:Arial">Todos</option>
    </select>

    <table id="csvTable">
        <tbody>
            <?php
            foreach ($files as $file) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $pref = explode("_", $fileName)[0];
                echo "<tr><td class='prefix'>$pref</td> <td><a href='view_csv.php?file=$file'>$fileName</a></td> <td><a href='edit_csv.php?file=$file'>editar</a></td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const prefixFilter = document.getElementById('prefixFilter');
            const table = document.getElementById('csvTable');
            const rows = Array.from(table.getElementsByTagName('tr'));
            const prefixes = new Set();

            // Collect unique prefixes
            rows.forEach(row => {
                const prefix = row.getElementsByClassName('prefix')[0].innerText;
                prefixes.add(prefix);
            });

            // Populate the filter dropdown with unique prefixes
            prefixes.forEach(prefix => {
                const option = document.createElement('option');
                option.value = prefix;
                option.textContent = prefix;
                prefixFilter.appendChild(option);
            });

            // Add event listener to filter the table based on selected prefix
            prefixFilter.addEventListener('change', function() {
                const selectedPrefix = prefixFilter.value;

                rows.forEach(row => {
                    const prefix = row.getElementsByClassName('prefix')[0].innerText;
                    if (selectedPrefix === "" || prefix === selectedPrefix) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>
</body>
</html>
