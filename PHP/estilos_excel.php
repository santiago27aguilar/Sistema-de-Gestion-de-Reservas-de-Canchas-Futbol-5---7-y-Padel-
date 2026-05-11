<?php
// Evita que errores de PHP ensucien el Excel
error_reporting(0);
ini_set('display_errors', 0);

// BOM para que Excel lea bien los acentos
$bom = "\xEF\xBB\xBF";

// Definimos los colores y estilos CSS que Excel reconoce
$color_morado = "#2b1b54";
$color_blanco = "#ffffff";
$color_gris_claro = "#eeeeee";

$estilo_unico = "
<style>
    .titulo-principal {
        background-color: $color_morado;
        color: $color_blanco;
        font-size: 16pt;
        font-weight: bold;
        text-align: center;
        border: 0.5pt solid #000;
    }
    .cabecera-tabla {
        background-color: $color_morado;
        color: $color_blanco;
        font-weight: bold;
        text-align: center;
        border: 0.5pt solid #000;
    }
    .celda-datos {
        text-align: center;
        border: 0.5pt solid #ccc;
        font-family: Arial, sans-serif;
    }
</style>";
?>