<html>
<head>
    <meta charset="UTF-8">
    <title>Sopa de letras</title>
    <style>
        p{font-style: Times  New Roman; display: block; font-size: medium; color:blue ;}
        div{font-style: Arial; display: block; font-size: 20px;}
        .resaltado{background-color: yellow;}
    </style>
</head>
<body>
    <h1 style="font-style: Arial; font-size: 50px; color: red;">Sopa de letra en php:</h1>
    <div id="lista">
        <?php
            $sopa = array(
                "Y, R, E, U, Q, J, S, M, A, P, ",
                "R, A, H, L, X, W, P, Q, Z, A, ",
                "E, L, C, M, K, A, A, W, L, H, ",
                "V, B, A, T, P, C, N, W, E, B, ",
                "R, H, P, H, Q, V, G, N, V, Y, ",
                "E, T, A, M, B, F, U, F, A, B, ",
                "S, T, O, U, J, C, L, M, R, L, ",
                "T, P, I, R, C, S, A, V, A, J, ",
                "W, R, H, S, T, A, R, F, L, Q, ",
                "W, H, S, P, Q, G, T, Q, Y, S, "
            );
        ?>
        <?php foreach ($sopa as $fila) { ?>
            <p><?= $fila ?></p>
        <?php } ?>
    </div>
    <div><em>Escribe la palabra que quieres buscar:</em></div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" id="buscador" name="buscador" placeholder="Buscar">
        <button type="submit" id="btnBuscador">Palabra la buscar</button>
    </form>

    <?php
        if (isset($_POST['buscador'])) {
            $buscador = $_POST['buscador'];
            BuscarPalabra($buscador, $sopa);
        }
    ?>

    <?php
        function BuscarPalabra($palabra, $sopa) {
            $filas = count($sopa);
            $columnas = strlen($sopa[0]);

            for ($i = 0; $i < $filas; $i++) {
                for ($j = 0; $j < $columnas; $j++) {
                    // Buscar en diferentes direcciones
                    if (BuscarEnDireccion($i, $j, $palabra, 0, 1, $sopa) || // Derecha
                        BuscarEnDireccion($i, $j, $palabra, 1, 0, $sopa) || // Abajo
                        BuscarEnDireccion($i, $j, $palabra, 0, -1, $sopa) || // Izquierda
                        BuscarEnDireccion($i, $j, $palabra, -1, 0, $sopa) || // Arriba
                        BuscarEnDireccion($i, $j, $palabra, -1, 1, $sopa) || // Diagonal superior derecha
                        BuscarEnDireccion($i, $j, $palabra, 1, 1, $sopa) || // Diagonal inferior derecha
                        BuscarEnDireccion($i, $j, $palabra, 1, -1, $sopa) || // Diagonal inferior izquierda
                        BuscarEnDireccion($i, $j, $palabra, -1, -1, $sopa))  // Diagonal superior izquierda
                    {
                        echo "<p style='background-color: yellow;'>La palabra '$palabra' se encuentra en la sopa de letras.</p>";
                        return;
                    }
                }
            }

            echo "<p>La palabra '$palabra' no se encuentra en la sopa de letras.</p>";
        }

        function BuscarEnDireccion($fila, $columna, $palabra, $dirX, $dirY, $sopa) {
            $longitud = strlen($palabra);
            $finFila = $fila + $dirX * ($longitud - 1);
            $finColumna = $columna + $dirY * ($longitud - 1);

            if ($finFila < 0 || $finFila >= count($sopa) || $finColumna < 0 || $finColumna >= strlen($sopa[0])) {
                return false;
            }

            for ($k = 0; $k < $longitud; $k++) {
                if (substr($sopa[$fila + $k * $dirX], $columna + $k * $dirY, 1) != $palabra[$k]) {
                    return false;
                }
            }

            return true;
        }
    ?>
</body>
</html>