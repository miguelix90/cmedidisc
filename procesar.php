<?php
/**
 * PROCESADOR DEL CUESTIONARIO
 * 
 * Este archivo recibe los datos del formulario y los guarda en la base de datos
 */

// Incluir configuración
require_once 'config.php';

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método no permitido');
}

// ============================================================================
// OBTENER Y VALIDAR CÓDIGO DE PARTICIPANTE
// ============================================================================

$codigo_participante = sanitize($_POST['codigo_participante'] ?? '');

// Validar que el código no esté vacío
if (empty($codigo_participante)) {
    die('Error: Código de participante no proporcionado');
}

// Validar formato y checksum del código
if (!esCodigoSociescuelaValido($codigo_participante)) {
    die('Error: El código proporcionado no es válido o ha sido modificado');
}

// ============================================================================
// PROCESAR DATOS DE SECCIÓN 1: SOCIESCUELA
// ============================================================================

$soci_1 = (int)($_POST['soci_1'] ?? 0);

// Variables condicionales (solo si soci_1 = 1)
$soci_2_1 = checkboxValue($_POST['soci_2_1'] ?? null);
$soci_2_2 = checkboxValue($_POST['soci_2_2'] ?? null);
$soci_2_3 = checkboxValue($_POST['soci_2_3'] ?? null);
$soci_2_4 = checkboxValue($_POST['soci_2_4'] ?? null);
$soci_2_5 = checkboxValue($_POST['soci_2_5'] ?? null);
$soci_2_6 = checkboxValue($_POST['soci_2_6'] ?? null);
$soci_2_7 = checkboxValue($_POST['soci_2_7'] ?? null);
$soci_2_8 = checkboxValue($_POST['soci_2_8'] ?? null);
$soci_2_8_espec = sanitize($_POST['soci_2_8_espec'] ?? null);

$soci_3 = isset($_POST['soci_3']) ? (int)$_POST['soci_3'] : null;
$soci_3_resultado = sanitize($_POST['soci_3_resultado'] ?? null);

$soci_4_1 = checkboxValue($_POST['soci_4_1'] ?? null);
$soci_4_2 = checkboxValue($_POST['soci_4_2'] ?? null);
$soci_4_3 = checkboxValue($_POST['soci_4_3'] ?? null);
$soci_4_4 = checkboxValue($_POST['soci_4_4'] ?? null);

$soci_5 = isset($_POST['soci_5']) && $_POST['soci_5'] !== '' ? (int)$_POST['soci_5'] : null;
$soci_6 = sanitize($_POST['soci_6'] ?? null);

// ============================================================================
// PROCESAR DATOS DE SECCIÓN 2: DISCIPLINARIAS
// ============================================================================

// PREGUNTA 1: Medidas disciplinarias (27 medidas)
$disci_1_amonestaciones_escritas = (int)($_POST['disci_1_amonestaciones_escritas'] ?? 1);
$disci_1_envio_jefatura = (int)($_POST['disci_1_envio_jefatura'] ?? 1);
$disci_1_apertura_expediente = (int)($_POST['disci_1_apertura_expediente'] ?? 1);
$disci_1_expulsion_temporal_aula = (int)($_POST['disci_1_expulsion_temporal_aula'] ?? 1);
$disci_1_expulsion_centro = (int)($_POST['disci_1_expulsion_centro'] ?? 1);
$disci_1_partes_incidencia = (int)($_POST['disci_1_partes_incidencia'] ?? 1);
$disci_1_suspension_extraescolares = (int)($_POST['disci_1_suspension_extraescolares'] ?? 1);
$disci_1_aviso_familia = (int)($_POST['disci_1_aviso_familia'] ?? 1);
$disci_1_retirada_movil = (int)($_POST['disci_1_retirada_movil'] ?? 1);
$disci_1_castigos = (int)($_POST['disci_1_castigos'] ?? 1);

$disci_1_mediacion_iguales = (int)($_POST['disci_1_mediacion_iguales'] ?? 1);
$disci_1_circulos_dialogo = (int)($_POST['disci_1_circulos_dialogo'] ?? 1);
$disci_1_trabajo_equipo = (int)($_POST['disci_1_trabajo_equipo'] ?? 1);
$disci_1_asambleas = (int)($_POST['disci_1_asambleas'] ?? 1);
$disci_1_autorregulacion = (int)($_POST['disci_1_autorregulacion'] ?? 1);
$disci_1_contratos_conducta = (int)($_POST['disci_1_contratos_conducta'] ?? 1);
$disci_1_planes_personalizados = (int)($_POST['disci_1_planes_personalizados'] ?? 1);
$disci_1_grupos_convivencia = (int)($_POST['disci_1_grupos_convivencia'] ?? 1);
$disci_1_formacion_habilidades = (int)($_POST['disci_1_formacion_habilidades'] ?? 1);

$disci_1_refuerzo_positivo = (int)($_POST['disci_1_refuerzo_positivo'] ?? 1);
$disci_1_organizacion_aula = (int)($_POST['disci_1_organizacion_aula'] ?? 1);
$disci_1_normas_visuales = (int)($_POST['disci_1_normas_visuales'] ?? 1);
$disci_1_tutoria_valores = (int)($_POST['disci_1_tutoria_valores'] ?? 1);
$disci_1_timeout_educativo = (int)($_POST['disci_1_timeout_educativo'] ?? 1);

$disci_1_servicio_comunidad = (int)($_POST['disci_1_servicio_comunidad'] ?? 1);
$disci_1_aprendizaje_servicio = (int)($_POST['disci_1_aprendizaje_servicio'] ?? 1);
$disci_1_participacion_familias = (int)($_POST['disci_1_participacion_familias'] ?? 1);
$disci_1_consejos_estudiantes = (int)($_POST['disci_1_consejos_estudiantes'] ?? 1);

$disci_1_otro_frecuencia = isset($_POST['disci_1_otro_frecuencia']) && $_POST['disci_1_otro_frecuencia'] !== '' ? (int)$_POST['disci_1_otro_frecuencia'] : null;
$disci_1_otro_especificar = sanitize($_POST['disci_1_otro_especificar'] ?? null);

// PREGUNTAS 2-5
$disci_2 = sanitize($_POST['disci_2'] ?? '');
$disci_3 = sanitize($_POST['disci_3'] ?? '');
$disci_3_aclaracion = sanitize($_POST['disci_3_aclaracion'] ?? '');
$disci_4 = sanitize($_POST['disci_4'] ?? '');
$disci_5 = sanitize($_POST['disci_5'] ?? '');

// PREGUNTA 6: Metodologías activas (condicional)
$disci_6_cooperativo = isset($_POST['disci_6_cooperativo']) && $_POST['disci_6_cooperativo'] !== '' ? (int)$_POST['disci_6_cooperativo'] : null;
$disci_6_problemas = isset($_POST['disci_6_problemas']) && $_POST['disci_6_problemas'] !== '' ? (int)$_POST['disci_6_problemas'] : null;
$disci_6_proyectos = isset($_POST['disci_6_proyectos']) && $_POST['disci_6_proyectos'] !== '' ? (int)$_POST['disci_6_proyectos'] : null;
$disci_6_gamificacion = isset($_POST['disci_6_gamificacion']) && $_POST['disci_6_gamificacion'] !== '' ? (int)$_POST['disci_6_gamificacion'] : null;
$disci_6_flipped = isset($_POST['disci_6_flipped']) && $_POST['disci_6_flipped'] !== '' ? (int)$_POST['disci_6_flipped'] : null;
$disci_6_servicio = isset($_POST['disci_6_servicio']) && $_POST['disci_6_servicio'] !== '' ? (int)$_POST['disci_6_servicio'] : null;
$disci_6_personalizacion = isset($_POST['disci_6_personalizacion']) && $_POST['disci_6_personalizacion'] !== '' ? (int)$_POST['disci_6_personalizacion'] : null;
$disci_6_otro = isset($_POST['disci_6_otro']) && $_POST['disci_6_otro'] !== '' ? (int)$_POST['disci_6_otro'] : null;
$disci_6_otro_especificar = sanitize($_POST['disci_6_otro_especificar'] ?? null);

// PREGUNTAS 7-11
$disci_7 = sanitize($_POST['disci_7'] ?? null);
$disci_8 = sanitize($_POST['disci_8'] ?? '');
$disci_9 = (int)($_POST['disci_9'] ?? 1);
$disci_10 = sanitize($_POST['disci_10'] ?? '');
$disci_11 = sanitize($_POST['disci_11'] ?? '');

// ============================================================================
// VALIDAR CAMPOS OBLIGATORIOS
// ============================================================================

if (empty($disci_2) || empty($disci_3) || empty($disci_3_aclaracion) || 
    empty($disci_4) || empty($disci_5) || empty($disci_8) || 
    empty($disci_10) || empty($disci_11)) {
    die('Error: Todos los campos obligatorios deben estar completos');
}

// ============================================================================
// GUARDAR EN BASE DE DATOS
// ============================================================================

try {
    $pdo = getDBConnection();
    
    // Iniciar transacción
    $pdo->beginTransaction();
    
    // Obtener IP y User Agent
    $ip_address = getClientIP();
    $user_agent = getUserAgent();
    
    // --------------------------------------------------
    // 1. INSERTAR PARTICIPANTE
    // --------------------------------------------------
    
    $sql = "INSERT INTO participantes (codigo_participante, ip_address, user_agent) 
            VALUES (:codigo, :ip, :user_agent)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':codigo' => $codigo_participante,
        ':ip' => $ip_address,
        ':user_agent' => $user_agent
    ]);
    
    $participante_id = $pdo->lastInsertId();
    
    // --------------------------------------------------
    // 2. INSERTAR RESPUESTAS SOCIESCUELA
    // --------------------------------------------------
    
    $sql = "INSERT INTO respuestas_sociescuela (
                participante_id, soci_1, soci_2_1, soci_2_2, soci_2_3, soci_2_4,
                soci_2_5, soci_2_6, soci_2_7, soci_2_8, soci_2_8_espec,
                soci_3, soci_3_resultado, soci_4_1, soci_4_2, soci_4_3, soci_4_4,
                soci_5, soci_6
            ) VALUES (
                :participante_id, :soci_1, :soci_2_1, :soci_2_2, :soci_2_3, :soci_2_4,
                :soci_2_5, :soci_2_6, :soci_2_7, :soci_2_8, :soci_2_8_espec,
                :soci_3, :soci_3_resultado, :soci_4_1, :soci_4_2, :soci_4_3, :soci_4_4,
                :soci_5, :soci_6
            )";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':participante_id' => $participante_id,
        ':soci_1' => $soci_1,
        ':soci_2_1' => $soci_2_1,
        ':soci_2_2' => $soci_2_2,
        ':soci_2_3' => $soci_2_3,
        ':soci_2_4' => $soci_2_4,
        ':soci_2_5' => $soci_2_5,
        ':soci_2_6' => $soci_2_6,
        ':soci_2_7' => $soci_2_7,
        ':soci_2_8' => $soci_2_8,
        ':soci_2_8_espec' => $soci_2_8_espec,
        ':soci_3' => $soci_3,
        ':soci_3_resultado' => $soci_3_resultado,
        ':soci_4_1' => $soci_4_1,
        ':soci_4_2' => $soci_4_2,
        ':soci_4_3' => $soci_4_3,
        ':soci_4_4' => $soci_4_4,
        ':soci_5' => $soci_5,
        ':soci_6' => $soci_6
    ]);
    
    // --------------------------------------------------
    // 3. INSERTAR RESPUESTAS DISCIPLINARIAS
    // --------------------------------------------------
    
    $sql = "INSERT INTO respuestas_disciplinarias (
                participante_id,
                disci_1_amonestaciones_escritas, disci_1_envio_jefatura, disci_1_apertura_expediente,
                disci_1_expulsion_temporal_aula, disci_1_expulsion_centro, disci_1_partes_incidencia,
                disci_1_suspension_extraescolares, disci_1_aviso_familia, disci_1_retirada_movil, disci_1_castigos,
                disci_1_mediacion_iguales, disci_1_circulos_dialogo, disci_1_trabajo_equipo, disci_1_asambleas,
                disci_1_autorregulacion, disci_1_contratos_conducta, disci_1_planes_personalizados,
                disci_1_grupos_convivencia, disci_1_formacion_habilidades,
                disci_1_refuerzo_positivo, disci_1_organizacion_aula, disci_1_normas_visuales,
                disci_1_tutoria_valores, disci_1_timeout_educativo,
                disci_1_servicio_comunidad, disci_1_aprendizaje_servicio, disci_1_participacion_familias,
                disci_1_consejos_estudiantes, disci_1_otro_frecuencia, disci_1_otro_especificar,
                disci_2, disci_3, disci_3_aclaracion, disci_4, disci_5,
                disci_6_cooperativo, disci_6_problemas, disci_6_proyectos, disci_6_gamificacion,
                disci_6_flipped, disci_6_servicio, disci_6_personalizacion, disci_6_otro, disci_6_otro_especificar,
                disci_7, disci_8, disci_9, disci_10, disci_11
            ) VALUES (
                :participante_id,
                :disci_1_amonestaciones_escritas, :disci_1_envio_jefatura, :disci_1_apertura_expediente,
                :disci_1_expulsion_temporal_aula, :disci_1_expulsion_centro, :disci_1_partes_incidencia,
                :disci_1_suspension_extraescolares, :disci_1_aviso_familia, :disci_1_retirada_movil, :disci_1_castigos,
                :disci_1_mediacion_iguales, :disci_1_circulos_dialogo, :disci_1_trabajo_equipo, :disci_1_asambleas,
                :disci_1_autorregulacion, :disci_1_contratos_conducta, :disci_1_planes_personalizados,
                :disci_1_grupos_convivencia, :disci_1_formacion_habilidades,
                :disci_1_refuerzo_positivo, :disci_1_organizacion_aula, :disci_1_normas_visuales,
                :disci_1_tutoria_valores, :disci_1_timeout_educativo,
                :disci_1_servicio_comunidad, :disci_1_aprendizaje_servicio, :disci_1_participacion_familias,
                :disci_1_consejos_estudiantes, :disci_1_otro_frecuencia, :disci_1_otro_especificar,
                :disci_2, :disci_3, :disci_3_aclaracion, :disci_4, :disci_5,
                :disci_6_cooperativo, :disci_6_problemas, :disci_6_proyectos, :disci_6_gamificacion,
                :disci_6_flipped, :disci_6_servicio, :disci_6_personalizacion, :disci_6_otro, :disci_6_otro_especificar,
                :disci_7, :disci_8, :disci_9, :disci_10, :disci_11
            )";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':participante_id' => $participante_id,
        ':disci_1_amonestaciones_escritas' => $disci_1_amonestaciones_escritas,
        ':disci_1_envio_jefatura' => $disci_1_envio_jefatura,
        ':disci_1_apertura_expediente' => $disci_1_apertura_expediente,
        ':disci_1_expulsion_temporal_aula' => $disci_1_expulsion_temporal_aula,
        ':disci_1_expulsion_centro' => $disci_1_expulsion_centro,
        ':disci_1_partes_incidencia' => $disci_1_partes_incidencia,
        ':disci_1_suspension_extraescolares' => $disci_1_suspension_extraescolares,
        ':disci_1_aviso_familia' => $disci_1_aviso_familia,
        ':disci_1_retirada_movil' => $disci_1_retirada_movil,
        ':disci_1_castigos' => $disci_1_castigos,
        ':disci_1_mediacion_iguales' => $disci_1_mediacion_iguales,
        ':disci_1_circulos_dialogo' => $disci_1_circulos_dialogo,
        ':disci_1_trabajo_equipo' => $disci_1_trabajo_equipo,
        ':disci_1_asambleas' => $disci_1_asambleas,
        ':disci_1_autorregulacion' => $disci_1_autorregulacion,
        ':disci_1_contratos_conducta' => $disci_1_contratos_conducta,
        ':disci_1_planes_personalizados' => $disci_1_planes_personalizados,
        ':disci_1_grupos_convivencia' => $disci_1_grupos_convivencia,
        ':disci_1_formacion_habilidades' => $disci_1_formacion_habilidades,
        ':disci_1_refuerzo_positivo' => $disci_1_refuerzo_positivo,
        ':disci_1_organizacion_aula' => $disci_1_organizacion_aula,
        ':disci_1_normas_visuales' => $disci_1_normas_visuales,
        ':disci_1_tutoria_valores' => $disci_1_tutoria_valores,
        ':disci_1_timeout_educativo' => $disci_1_timeout_educativo,
        ':disci_1_servicio_comunidad' => $disci_1_servicio_comunidad,
        ':disci_1_aprendizaje_servicio' => $disci_1_aprendizaje_servicio,
        ':disci_1_participacion_familias' => $disci_1_participacion_familias,
        ':disci_1_consejos_estudiantes' => $disci_1_consejos_estudiantes,
        ':disci_1_otro_frecuencia' => $disci_1_otro_frecuencia,
        ':disci_1_otro_especificar' => $disci_1_otro_especificar,
        ':disci_2' => $disci_2,
        ':disci_3' => $disci_3,
        ':disci_3_aclaracion' => $disci_3_aclaracion,
        ':disci_4' => $disci_4,
        ':disci_5' => $disci_5,
        ':disci_6_cooperativo' => $disci_6_cooperativo,
        ':disci_6_problemas' => $disci_6_problemas,
        ':disci_6_proyectos' => $disci_6_proyectos,
        ':disci_6_gamificacion' => $disci_6_gamificacion,
        ':disci_6_flipped' => $disci_6_flipped,
        ':disci_6_servicio' => $disci_6_servicio,
        ':disci_6_personalizacion' => $disci_6_personalizacion,
        ':disci_6_otro' => $disci_6_otro,
        ':disci_6_otro_especificar' => $disci_6_otro_especificar,
        ':disci_7' => $disci_7,
        ':disci_8' => $disci_8,
        ':disci_9' => $disci_9,
        ':disci_10' => $disci_10,
        ':disci_11' => $disci_11
    ]);
    
    // Confirmar transacción
    $pdo->commit();
    
    // Redirigir a página de éxito
    header('Location: exito.php?codigo=' . urlencode($codigo_participante));
    exit;
    
} catch (PDOException $e) {
    // Revertir transacción en caso de error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    // Mostrar error
    if (SHOW_ERRORS) {
        die('Error al guardar los datos: ' . $e->getMessage());
    } else {
        die('Error al guardar los datos. Por favor, contacte al administrador.');
    }
}
