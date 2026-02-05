-- ============================================================================
-- CONSULTAS ÚTILES PARA ANÁLISIS DE DATOS
-- ============================================================================
-- Fecha: 21 de enero de 2026
-- ============================================================================

USE cuestionario_disciplinarias;

-- ============================================================================
-- 1. CONSULTAS BÁSICAS DE RESUMEN
-- ============================================================================

-- Contar total de participantes
SELECT COUNT(*) as total_participantes 
FROM participantes;

-- Ver últimas 10 respuestas
SELECT 
    codigo_participante,
    fecha_envio,
    DATE_FORMAT(fecha_envio, '%d/%m/%Y %H:%i') as fecha_formato
FROM participantes
ORDER BY fecha_envio DESC
LIMIT 10;

-- ============================================================================
-- 2. ANÁLISIS SECCIÓN 1: SOCIESCUELA
-- ============================================================================

-- Porcentaje de centros que usan Sociescuela
SELECT 
    soci_1,
    CASE soci_1 
        WHEN 1 THEN 'Sí usa Sociescuela'
        WHEN 0 THEN 'No usa Sociescuela'
    END as uso,
    COUNT(*) as cantidad,
    ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM respuestas_sociescuela), 2) as porcentaje
FROM respuestas_sociescuela
GROUP BY soci_1;

-- Usos más comunes de Sociescuela (solo quienes la usan)
SELECT 
    SUM(soci_2_1) as grupos_ayuda,
    SUM(soci_2_2) as equipos_cooperativos,
    SUM(soci_2_3) as colocacion_aula,
    SUM(soci_2_4) as organizar_grupos,
    SUM(soci_2_5) as mediacion_conflictos,
    SUM(soci_2_6) as ciberacoso,
    SUM(soci_2_7) as prevencion_violencia,
    SUM(soci_2_8) as otros
FROM respuestas_sociescuela
WHERE soci_1 = 1;

-- Promedio de satisfacción con Sociescuela
SELECT 
    AVG(soci_5) as promedio_satisfaccion,
    MIN(soci_5) as minima_satisfaccion,
    MAX(soci_5) as maxima_satisfaccion,
    COUNT(soci_5) as total_respuestas
FROM respuestas_sociescuela
WHERE soci_5 IS NOT NULL;

-- ============================================================================
-- 3. ANÁLISIS SECCIÓN 2: MEDIDAS DISCIPLINARIAS
-- ============================================================================

-- Frecuencia promedio de cada tipo de medida
-- Valores: 1=Nunca, 2=Rara vez, 3=A veces, 4=Frecuentemente, 5=Siempre

SELECT 
    'Amonestaciones escritas' as medida,
    AVG(disci_1_amonestaciones_escritas) as promedio,
    CASE 
        WHEN AVG(disci_1_amonestaciones_escritas) < 2 THEN 'Nunca/Rara vez'
        WHEN AVG(disci_1_amonestaciones_escritas) < 3 THEN 'Rara vez/A veces'
        WHEN AVG(disci_1_amonestaciones_escritas) < 4 THEN 'A veces/Frecuentemente'
        ELSE 'Frecuentemente/Siempre'
    END as interpretacion
FROM respuestas_disciplinarias
UNION ALL
SELECT 
    'Mediación entre iguales' as medida,
    AVG(disci_1_mediacion_iguales) as promedio,
    CASE 
        WHEN AVG(disci_1_mediacion_iguales) < 2 THEN 'Nunca/Rara vez'
        WHEN AVG(disci_1_mediacion_iguales) < 3 THEN 'Rara vez/A veces'
        WHEN AVG(disci_1_mediacion_iguales) < 4 THEN 'A veces/Frecuentemente'
        ELSE 'Frecuentemente/Siempre'
    END as interpretacion
FROM respuestas_disciplinarias
UNION ALL
SELECT 
    'Refuerzo positivo' as medida,
    AVG(disci_1_refuerzo_positivo) as promedio,
    CASE 
        WHEN AVG(disci_1_refuerzo_positivo) < 2 THEN 'Nunca/Rara vez'
        WHEN AVG(disci_1_refuerzo_positivo) < 3 THEN 'Rara vez/A veces'
        WHEN AVG(disci_1_refuerzo_positivo) < 4 THEN 'A veces/Frecuentemente'
        ELSE 'Frecuentemente/Siempre'
    END as interpretacion
FROM respuestas_disciplinarias;

-- Efectividad percibida de las medidas disciplinarias
SELECT 
    disci_3,
    COUNT(*) as cantidad,
    ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM respuestas_disciplinarias), 2) as porcentaje
FROM respuestas_disciplinarias
GROUP BY disci_3;

-- Centros que aplicaron metodologías activas (respondieron pregunta 6)
SELECT 
    COUNT(*) as centros_con_metodologias
FROM respuestas_disciplinarias
WHERE disci_6_cooperativo IS NOT NULL 
   OR disci_6_problemas IS NOT NULL
   OR disci_6_proyectos IS NOT NULL
   OR disci_6_gamificacion IS NOT NULL
   OR disci_6_flipped IS NOT NULL
   OR disci_6_servicio IS NOT NULL
   OR disci_6_personalizacion IS NOT NULL;

-- Nivel de aplicación de metodologías activas
-- Valores: 1=Nivel integral, 2=Una o varias asignaturas, 3=Alguna asignatura, 4=No aplicable
SELECT 
    'Aprendizaje cooperativo' as metodologia,
    AVG(disci_6_cooperativo) as promedio_nivel,
    COUNT(disci_6_cooperativo) as respuestas
FROM respuestas_disciplinarias
WHERE disci_6_cooperativo IS NOT NULL
UNION ALL
SELECT 
    'Aprendizaje basado en problemas' as metodologia,
    AVG(disci_6_problemas) as promedio_nivel,
    COUNT(disci_6_problemas) as respuestas
FROM respuestas_disciplinarias
WHERE disci_6_problemas IS NOT NULL
UNION ALL
SELECT 
    'Gamificación' as metodologia,
    AVG(disci_6_gamificacion) as promedio_nivel,
    COUNT(disci_6_gamificacion) as respuestas
FROM respuestas_disciplinarias
WHERE disci_6_gamificacion IS NOT NULL;

-- Efectividad de metodologías en convivencia
-- Valores: 1=Nada, 2=Poco, 3=Bastante, 4=Mucho
SELECT 
    disci_9,
    CASE disci_9
        WHEN 1 THEN 'Nada'
        WHEN 2 THEN 'Poco'
        WHEN 3 THEN 'Bastante'
        WHEN 4 THEN 'Mucho'
    END as nivel_efectividad,
    COUNT(*) as cantidad,
    ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM respuestas_disciplinarias), 2) as porcentaje
FROM respuestas_disciplinarias
GROUP BY disci_9
ORDER BY disci_9;

-- ============================================================================
-- 4. CONSULTAS CRUZADAS
-- ============================================================================

-- Relación entre uso de Sociescuela y percepción de efectividad de medidas
SELECT 
    s.soci_1,
    CASE s.soci_1 
        WHEN 1 THEN 'Usa Sociescuela'
        WHEN 0 THEN 'No usa Sociescuela'
    END as uso_sociescuela,
    d.disci_3,
    COUNT(*) as cantidad
FROM participantes p
JOIN respuestas_sociescuela s ON p.id = s.participante_id
JOIN respuestas_disciplinarias d ON p.id = d.participante_id
GROUP BY s.soci_1, d.disci_3
ORDER BY s.soci_1, d.disci_3;

-- ============================================================================
-- 5. EXPORTAR DATOS PARA ANÁLISIS ESTADÍSTICO
-- ============================================================================

-- Exportar todas las respuestas en formato tabular
SELECT 
    p.codigo_participante,
    DATE_FORMAT(p.fecha_envio, '%Y-%m-%d') as fecha,
    s.*,
    d.*
FROM participantes p
LEFT JOIN respuestas_sociescuela s ON p.id = s.participante_id
LEFT JOIN respuestas_disciplinarias d ON p.id = d.participante_id
ORDER BY p.fecha_envio DESC;

-- ============================================================================
-- 6. LIMPIEZA Y MANTENIMIENTO
-- ============================================================================

-- Ver respuestas incompletas (sin respuestas en alguna sección)
SELECT 
    p.codigo_participante,
    p.fecha_envio,
    CASE WHEN s.id IS NULL THEN 'Falta Sociescuela' ELSE 'OK' END as estado_sociescuela,
    CASE WHEN d.id IS NULL THEN 'Falta Disciplinarias' ELSE 'OK' END as estado_disciplinarias
FROM participantes p
LEFT JOIN respuestas_sociescuela s ON p.id = s.participante_id
LEFT JOIN respuestas_disciplinarias d ON p.id = d.participante_id
WHERE s.id IS NULL OR d.id IS NULL;

-- Eliminar respuestas de prueba (si es necesario)
-- DELETE FROM participantes WHERE codigo_participante LIKE 'TEST%';

-- ============================================================================
-- 7. ESTADÍSTICAS AVANZADAS
-- ============================================================================

-- Distribución de frecuencia de todas las medidas tradicionales
SELECT 
    'Nunca (1)' as frecuencia,
    SUM(CASE WHEN disci_1_amonestaciones_escritas = 1 THEN 1 ELSE 0 END) as amonestaciones,
    SUM(CASE WHEN disci_1_envio_jefatura = 1 THEN 1 ELSE 0 END) as envio_jefatura,
    SUM(CASE WHEN disci_1_expulsion_centro = 1 THEN 1 ELSE 0 END) as expulsion
FROM respuestas_disciplinarias
UNION ALL
SELECT 
    'Rara vez (2)' as frecuencia,
    SUM(CASE WHEN disci_1_amonestaciones_escritas = 2 THEN 1 ELSE 0 END) as amonestaciones,
    SUM(CASE WHEN disci_1_envio_jefatura = 2 THEN 1 ELSE 0 END) as envio_jefatura,
    SUM(CASE WHEN disci_1_expulsion_centro = 2 THEN 1 ELSE 0 END) as expulsion
FROM respuestas_disciplinarias
UNION ALL
SELECT 
    'A veces (3)' as frecuencia,
    SUM(CASE WHEN disci_1_amonestaciones_escritas = 3 THEN 1 ELSE 0 END) as amonestaciones,
    SUM(CASE WHEN disci_1_envio_jefatura = 3 THEN 1 ELSE 0 END) as envio_jefatura,
    SUM(CASE WHEN disci_1_expulsion_centro = 3 THEN 1 ELSE 0 END) as expulsion
FROM respuestas_disciplinarias
UNION ALL
SELECT 
    'Frecuentemente (4)' as frecuencia,
    SUM(CASE WHEN disci_1_amonestaciones_escritas = 4 THEN 1 ELSE 0 END) as amonestaciones,
    SUM(CASE WHEN disci_1_envio_jefatura = 4 THEN 1 ELSE 0 END) as envio_jefatura,
    SUM(CASE WHEN disci_1_expulsion_centro = 4 THEN 1 ELSE 0 END) as expulsion
FROM respuestas_disciplinarias
UNION ALL
SELECT 
    'Siempre (5)' as frecuencia,
    SUM(CASE WHEN disci_1_amonestaciones_escritas = 5 THEN 1 ELSE 0 END) as amonestaciones,
    SUM(CASE WHEN disci_1_envio_jefatura = 5 THEN 1 ELSE 0 END) as envio_jefatura,
    SUM(CASE WHEN disci_1_expulsion_centro = 5 THEN 1 ELSE 0 END) as expulsion
FROM respuestas_disciplinarias;

-- ============================================================================
-- FIN DE CONSULTAS
-- ============================================================================
