<?php
/**
 * API PARA VALIDACIÓN DE CÓDIGOS
 * 
 * Endpoint JSON para validar códigos Sociescuela
 * Uso: validar_codigo.php?codigo=ABC123XY
 */

header('Content-Type: application/json');
require_once 'config.php';

$codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';

if (empty($codigo)) {
    echo json_encode([
        'valido' => false,
        'mensaje' => 'No se proporcionó ningún código'
    ]);
    exit;
}

$valido = esCodigoSociescuelaValido($codigo);

if ($valido) {
    echo json_encode([
        'valido' => true,
        'mensaje' => 'El código es válido',
        'codigo' => strtoupper($codigo)
    ]);
} else {
    $mensajes_error = [];
    
    if (strlen($codigo) !== 8) {
        $mensajes_error[] = "El código debe tener exactamente 8 caracteres (tiene " . strlen($codigo) . ")";
    }
    
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $codigo_upper = strtoupper($codigo);
    for ($i = 0; $i < strlen($codigo_upper); $i++) {
        if (strpos($chars, $codigo_upper[$i]) === false) {
            $mensajes_error[] = "Carácter no válido: '" . $codigo_upper[$i] . "' (no se permiten I, O, 0, 1)";
            break;
        }
    }
    
    if (empty($mensajes_error)) {
        $mensajes_error[] = "El checksum no es correcto";
    }
    
    echo json_encode([
        'valido' => false,
        'mensaje' => implode('. ', $mensajes_error),
        'codigo' => $codigo
    ]);
}
