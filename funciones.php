<?php
/**
 * FUNCIONES AUXILIARES
 * ============================================================================
 * Funciones para sanitización, validación y utilidades
 * Fecha: 21 de enero de 2026
 */

// ============================================================================
// FUNCIONES DE SANITIZACIÓN
// ============================================================================

/**
 * Sanitiza una cadena de texto
 * 
 * @param string $texto Texto a sanitizar
 * @return string Texto sanitizado
 */
function sanitizar_texto($texto) {
    if ($texto === null || $texto === '') {
        return null;
    }
    return trim(strip_tags($texto));
}

/**
 * Sanitiza un valor numérico
 * 
 * @param mixed $valor Valor a sanitizar
 * @return int|null Valor numérico o null
 */
function sanitizar_numero($valor) {
    if ($valor === null || $valor === '') {
        return null;
    }
    return filter_var($valor, FILTER_VALIDATE_INT) !== false ? (int)$valor : null;
}

/**
 * Sanitiza un checkbox (true/false)
 * 
 * @param mixed $valor Valor del checkbox
 * @return int|null 1 si está marcado, null si no
 */
function sanitizar_checkbox($valor) {
    return ($valor === 'true' || $valor === '1' || $valor === true) ? 1 : null;
}

/**
 * Sanitiza un valor de radio button o select
 * 
 * @param mixed $valor Valor a sanitizar
 * @param array $valores_validos Array de valores válidos
 * @return string|null Valor sanitizado o null
 */
function sanitizar_opcion($valor, $valores_validos) {
    if ($valor === null || $valor === '') {
        return null;
    }
    return in_array($valor, $valores_validos) ? $valor : null;
}

// ============================================================================
// FUNCIONES DE VALIDACIÓN
// ============================================================================

/**
 * Valida que un campo requerido no esté vacío
 * 
 * @param mixed $valor Valor a validar
 * @return bool True si es válido
 */
function validar_requerido($valor) {
    return $valor !== null && $valor !== '';
}

/**
 * Valida que un número esté en un rango
 * 
 * @param int $valor Valor a validar
 * @param int $min Valor mínimo
 * @param int $max Valor máximo
 * @return bool True si está en rango
 */
function validar_rango($valor, $min, $max) {
    return $valor >= $min && $valor <= $max;
}

/**
 * Valida código de participante
 * 
 * @param string $codigo Código a validar
 * @return bool True si es válido
 */
function validar_codigo_participante($codigo) {
    // Debe tener al menos 3 caracteres
    return strlen($codigo) >= 3 && strlen($codigo) <= 100;
}

// ============================================================================
// FUNCIONES PARA OBTENER DATOS DEL POST
// ============================================================================

/**
 * Obtiene un valor de POST de forma segura
 * 
 * @param string $key Clave del array POST
 * @param mixed $default Valor por defecto si no existe
 * @return mixed Valor obtenido o default
 */
function get_post($key, $default = null) {
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

/**
 * Obtiene múltiples valores de POST
 * 
 * @param array $keys Array de claves a obtener
 * @return array Array asociativo con los valores
 */
function get_post_multiple($keys) {
    $resultado = [];
    foreach ($keys as $key) {
        $resultado[$key] = get_post($key);
    }
    return $resultado;
}

// ============================================================================
// FUNCIONES DE UTILIDAD
// ============================================================================

/**
 * Obtiene la IP del cliente
 * 
 * @return string Dirección IP
 */
function obtener_ip_cliente() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'] ?? 'DESCONOCIDA';
    }
}

/**
 * Obtiene el User Agent del cliente
 * 
 * @return string User Agent
 */
function obtener_user_agent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? 'DESCONOCIDO';
}

/**
 * Redirige a una URL
 * 
 * @param string $url URL de destino
 */
function redirigir($url) {
    header("Location: " . $url);
    exit;
}

/**
 * Genera un mensaje de error en JSON
 * 
 * @param string $mensaje Mensaje de error
 * @param int $codigo Código HTTP
 */
function responder_error($mensaje, $codigo = 400) {
    http_response_code($codigo);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => $mensaje
    ]);
    exit;
}

/**
 * Genera un mensaje de éxito en JSON
 * 
 * @param string $mensaje Mensaje de éxito
 * @param array $data Datos adicionales
 */
function responder_exito($mensaje, $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'mensaje' => $mensaje,
        'data' => $data
    ]);
    exit;
}

// ============================================================================
// FUNCIONES ESPECÍFICAS DEL CUESTIONARIO
// ============================================================================

/**
 * Procesa las respuestas de la sección Sociescuela
 * 
 * @param array $post Datos de POST
 * @return array Datos procesados
 */
function procesar_sociescuela($post) {
    $soci_1 = sanitizar_numero(get_post('soci_1'));
    
    $datos = [
        'soci_1' => $soci_1
    ];
    
    // Solo procesar preguntas condicionales si soci_1 = 1 (Sí)
    if ($soci_1 === 1) {
        // Pregunta 2: Checkboxes
        $datos['soci_2_1'] = sanitizar_checkbox(get_post('soci_2_1'));
        $datos['soci_2_2'] = sanitizar_checkbox(get_post('soci_2_2'));
        $datos['soci_2_3'] = sanitizar_checkbox(get_post('soci_2_3'));
        $datos['soci_2_4'] = sanitizar_checkbox(get_post('soci_2_4'));
        $datos['soci_2_5'] = sanitizar_checkbox(get_post('soci_2_5'));
        $datos['soci_2_6'] = sanitizar_checkbox(get_post('soci_2_6'));
        $datos['soci_2_7'] = sanitizar_checkbox(get_post('soci_2_7'));
        $datos['soci_2_8'] = sanitizar_checkbox(get_post('soci_2_8'));
        $datos['soci_2_8_espec'] = sanitizar_texto(get_post('soci_2_8_espec'));
        
        // Pregunta 3
        $datos['soci_3'] = sanitizar_numero(get_post('soci_3'));
        $datos['soci_3_resultado'] = sanitizar_texto(get_post('soci_3_resultado'));
        
        // Pregunta 4
        $datos['soci_4_1'] = sanitizar_checkbox(get_post('soci_4_1'));
        $datos['soci_4_2'] = sanitizar_checkbox(get_post('soci_4_2'));
        $datos['soci_4_3'] = sanitizar_checkbox(get_post('soci_4_3'));
        $datos['soci_4_4'] = sanitizar_checkbox(get_post('soci_4_4'));
        
        // Pregunta 5
        $datos['soci_5'] = sanitizar_numero(get_post('soci_5'));
        
        // Pregunta 6
        $datos['soci_6'] = sanitizar_texto(get_post('soci_6'));
    } else {
        // Si respondió No, todos los campos condicionales son NULL
        for ($i = 1; $i <= 8; $i++) {
            $datos['soci_2_' . $i] = null;
        }
        $datos['soci_2_8_espec'] = null;
        $datos['soci_3'] = null;
        $datos['soci_3_resultado'] = null;
        for ($i = 1; $i <= 4; $i++) {
            $datos['soci_4_' . $i] = null;
        }
        $datos['soci_5'] = null;
        $datos['soci_6'] = null;
    }
    
    return $datos;
}

/**
 * Procesa las respuestas de la sección Disciplinarias
 * 
 * @param array $post Datos de POST
 * @return array Datos procesados
 */
function procesar_disciplinarias($post) {
    $datos = [];
    
    // PREGUNTA 1: 27 medidas disciplinarias
    $medidas = [
        'amonestaciones_escritas', 'envio_jefatura', 'apertura_expediente',
        'expulsion_temporal_aula', 'expulsion_centro', 'partes_incidencia',
        'suspension_extraescolares', 'aviso_familia', 'retirada_movil', 'castigos',
        'mediacion_iguales', 'circulos_dialogo', 'trabajo_equipo', 'asambleas',
        'autorregulacion', 'contratos_conducta', 'planes_personalizados',
        'grupos_convivencia', 'formacion_habilidades',
        'refuerzo_positivo', 'organizacion_aula', 'normas_visuales',
        'tutoria_valores', 'timeout_educativo',
        'servicio_comunidad', 'aprendizaje_servicio', 'participacion_familias',
        'consejos_estudiantes'
    ];
    
    foreach ($medidas as $medida) {
        $datos['disci_1_' . $medida] = sanitizar_numero(get_post('disci_1_' . $medida));
    }
    
    $datos['disci_1_otro_frecuencia'] = sanitizar_numero(get_post('disci_1_otro_frecuencia'));
    $datos['disci_1_otro_especificar'] = sanitizar_texto(get_post('disci_1_otro_especificar'));
    
    // PREGUNTAS 2-5
    $datos['disci_2'] = sanitizar_texto(get_post('disci_2'));
    $datos['disci_3'] = sanitizar_opcion(get_post('disci_3'), ['si', 'no', 'depende']);
    $datos['disci_3_aclaracion'] = sanitizar_texto(get_post('disci_3_aclaracion'));
    $datos['disci_4'] = sanitizar_texto(get_post('disci_4'));
    $datos['disci_5'] = sanitizar_texto(get_post('disci_5'));
    
    // PREGUNTA 6: Metodologías (condicional)
    $metodologias = [
        'cooperativo', 'problemas', 'proyectos', 'gamificacion',
        'flipped', 'servicio', 'personalizacion', 'otro'
    ];
    
    foreach ($metodologias as $metodologia) {
        $datos['disci_6_' . $metodologia] = sanitizar_numero(get_post('disci_6_' . $metodologia));
    }
    $datos['disci_6_otro_especificar'] = sanitizar_texto(get_post('disci_6_otro_especificar'));
    
    // PREGUNTAS 7-11
    $datos['disci_7'] = sanitizar_texto(get_post('disci_7'));
    $datos['disci_8'] = sanitizar_texto(get_post('disci_8'));
    $datos['disci_9'] = sanitizar_numero(get_post('disci_9'));
    $datos['disci_10'] = sanitizar_texto(get_post('disci_10'));
    $datos['disci_11'] = sanitizar_texto(get_post('disci_11'));
    
    return $datos;
}
