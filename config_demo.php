<?php
/**
 * CONFIGURACIÓN DE LA BASE DE DATOS
 * 
 * Este archivo contiene la configuración de conexión a MySQL
 * IMPORTANTE: No subir este archivo a repositorios públicos
 */

// ============================================================================
// CONFIGURACIÓN DE LA BASE DE DATOS
// ============================================================================

// Datos de conexión - CAMBIAR EN PRODUCCIÓN
define('DB_HOST', 'localhost');           // Servidor de base de datos
define('DB_NAME', 'cuestionario_disciplinarias'); // Nombre de la base de datos
define('DB_USER', 'root');                 // Usuario de MySQL
define('DB_PASS', '');                     // Contraseña de MySQL (vacía en Laragon por defecto)
define('DB_CHARSET', 'utf8mb4');           // Codificación de caracteres

// ============================================================================
// CONFIGURACIÓN GENERAL
// ============================================================================

// Mostrar errores (SOLO EN DESARROLLO - cambiar a false en producción)
define('SHOW_ERRORS', true);

// Zona horaria
date_default_timezone_set('Europe/Madrid');

// ============================================================================
// FUNCIÓN DE CONEXIÓN A LA BASE DE DATOS
// ============================================================================

/**
 * Obtener conexión PDO a la base de datos
 * 
 * @return PDO Objeto de conexión
 * @throws PDOException Si hay error de conexión
 */
function getDBConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            // Log del error (en producción guardar en archivo de log)
            if (SHOW_ERRORS) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            } else {
                die("Error de conexión a la base de datos. Por favor, contacte al administrador.");
            }
        }
    }
    
    return $pdo;
}

// ============================================================================
// CONFIGURACIÓN DE ERRORES
// ============================================================================

if (SHOW_ERRORS) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ============================================================================
// FUNCIONES AUXILIARES
// ============================================================================

/**
 * Sanitizar entrada de texto
 * 
 * @param string $data Datos a sanitizar
 * @return string Datos sanitizados
 */
function sanitize($data) {
    if ($data === null) {
        return null;
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Convertir valor de checkbox a booleano
 * 
 * @param mixed $value Valor del checkbox
 * @return int|null 1 si está marcado, NULL si no
 */
function checkboxValue($value) {
    return (isset($value) && $value === 'true') ? 1 : null;
}

/**
 * Obtener IP del cliente
 * 
 * @return string IP del cliente
 */
function getClientIP() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }
    
    return $ip;
}

/**
 * Obtener User Agent del cliente
 * 
 * @return string User Agent
 */
function getUserAgent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? '';
}

/**
 * Validar código de institución Sociescuela
 * 
 * Verifica que el código tenga el formato correcto y checksum válido
 * Formato: 8 caracteres (6 + 2 checksum)
 * Caracteres válidos: ABCDEFGHJKLMNPQRSTUVWXYZ23456789 (sin I, O, 0, 1)
 * 
 * @param string $codigo Código a validar
 * @return bool True si el código es válido, false en caso contrario
 */
function esCodigoSociescuelaValido(string $codigo): bool {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    
    // Verificar longitud
    if (strlen($codigo) !== 8) {
        return false;
    }
    
    // Convertir a mayúsculas
    $codigo = strtoupper($codigo);
    
    // Verificar caracteres válidos
    for ($i = 0; $i < 8; $i++) {
        if (strpos($chars, $codigo[$i]) === false) {
            return false;
        }
    }
    
    // Verificar checksum
    $parte = substr($codigo, 0, 6);
    $suma = 0;
    for ($i = 0; $i < 6; $i++) {
        $suma += strpos($chars, $parte[$i]) * ($i + 1);
    }
    
    $check1 = $chars[$suma % 32];
    $check2 = $chars[($suma * 7 + 13) % 32];
    
    return substr($codigo, 6, 2) === $check1 . $check2;
}
