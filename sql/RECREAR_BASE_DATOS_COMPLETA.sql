-- ============================================================================
-- SCRIPT DE LIMPIEZA Y RECREACIÓN COMPLETA
-- ============================================================================
-- Fecha: 3 de febrero de 2026
-- Uso: Para borrar completamente la base de datos y crearla desde cero
-- ADVERTENCIA: Este script BORRA TODOS LOS DATOS
-- ============================================================================

-- Borrar la base de datos si existe (¡CUIDADO! Elimina todos los datos)
DROP DATABASE IF EXISTS cuestionario_disciplinarias;

-- Crear la base de datos desde cero
CREATE DATABASE cuestionario_disciplinarias 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE cuestionario_disciplinarias;

-- ============================================================================
-- TABLA 1: PARTICIPANTES
-- ============================================================================

CREATE TABLE participantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_participante VARCHAR(100) NOT NULL COMMENT 'Código de la institución - permite múltiples respuestas',
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    INDEX idx_codigo (codigo_participante),
    INDEX idx_fecha (fecha_envio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
COMMENT='Cada código representa una institución y permite múltiples participantes';

-- ============================================================================
-- TABLA 2: RESPUESTAS SOCIESCUELA
-- ============================================================================

CREATE TABLE respuestas_sociescuela (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participante_id INT NOT NULL,
    
    -- PREGUNTA 1
    soci_1 TINYINT NOT NULL COMMENT '1=Sí, 0=No',
    
    -- PREGUNTA 2 (condicional)
    soci_2_1 TINYINT DEFAULT NULL COMMENT 'Crear grupos de ayuda entre iguales',
    soci_2_2 TINYINT DEFAULT NULL COMMENT 'Trabajar en equipos cooperativos',
    soci_2_3 TINYINT DEFAULT NULL COMMENT 'Modificar la colocación en el aula',
    soci_2_4 TINYINT DEFAULT NULL COMMENT 'Organizar grupos de un curso para el siguiente',
    soci_2_5 TINYINT DEFAULT NULL COMMENT 'Para realizar mediación o resolución de conflictos',
    soci_2_6 TINYINT DEFAULT NULL COMMENT 'Para trabajar el ciberacoso',
    soci_2_7 TINYINT DEFAULT NULL COMMENT 'Para prevención de la violencia',
    soci_2_8 TINYINT DEFAULT NULL COMMENT 'Otra',
    soci_2_8_espec VARCHAR(500) DEFAULT NULL COMMENT 'Especificar otra',
    
    -- PREGUNTA 3 (condicional)
    soci_3 TINYINT DEFAULT NULL COMMENT '1=Sí, 0=No',
    soci_3_resultado TEXT DEFAULT NULL COMMENT '¿Cuál fue el resultado?',
    
    -- PREGUNTA 4 (condicional)
    soci_4_1 TINYINT DEFAULT NULL COMMENT 'Departamento de orientación',
    soci_4_2 TINYINT DEFAULT NULL COMMENT 'Equipo directivo',
    soci_4_3 TINYINT DEFAULT NULL COMMENT 'Tutores/as',
    soci_4_4 TINYINT DEFAULT NULL COMMENT 'Profesores/as',
    
    -- PREGUNTA 5 (condicional)
    soci_5 TINYINT DEFAULT NULL COMMENT 'Escala 1-10',
    
    -- PREGUNTA 6 (condicional)
    soci_6 TEXT DEFAULT NULL COMMENT 'Sugerencias de mejora',
    
    FOREIGN KEY (participante_id) REFERENCES participantes(id) ON DELETE CASCADE,
    INDEX idx_participante (participante_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA 3: RESPUESTAS DISCIPLINARIAS
-- ============================================================================

CREATE TABLE respuestas_disciplinarias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participante_id INT NOT NULL,
    
    -- PREGUNTA 1: Medidas disciplinarias (valores 1-5)
    -- Tradicionales
    disci_1_amonestaciones_escritas TINYINT NOT NULL,
    disci_1_envio_jefatura TINYINT NOT NULL,
    disci_1_apertura_expediente TINYINT NOT NULL,
    disci_1_expulsion_temporal_aula TINYINT NOT NULL,
    disci_1_expulsion_centro TINYINT NOT NULL,
    disci_1_partes_incidencia TINYINT NOT NULL,
    disci_1_suspension_extraescolares TINYINT NOT NULL,
    disci_1_aviso_familia TINYINT NOT NULL,
    disci_1_retirada_movil TINYINT NOT NULL,
    disci_1_castigos TINYINT NOT NULL,
    
    -- Restauradoras
    disci_1_mediacion_iguales TINYINT NOT NULL,
    disci_1_circulos_dialogo TINYINT NOT NULL,
    disci_1_trabajo_equipo TINYINT NOT NULL,
    disci_1_asambleas TINYINT NOT NULL,
    disci_1_autorregulacion TINYINT NOT NULL,
    disci_1_contratos_conducta TINYINT NOT NULL,
    disci_1_planes_personalizados TINYINT NOT NULL,
    disci_1_grupos_convivencia TINYINT NOT NULL,
    disci_1_formacion_habilidades TINYINT NOT NULL,
    
    -- Pedagógicas
    disci_1_refuerzo_positivo TINYINT NOT NULL,
    disci_1_organizacion_aula TINYINT NOT NULL,
    disci_1_normas_visuales TINYINT NOT NULL,
    disci_1_tutoria_valores TINYINT NOT NULL,
    disci_1_timeout_educativo TINYINT NOT NULL,
    
    -- Comunitarias
    disci_1_servicio_comunidad TINYINT NOT NULL,
    disci_1_aprendizaje_servicio TINYINT NOT NULL,
    disci_1_participacion_familias TINYINT NOT NULL,
    disci_1_consejos_estudiantes TINYINT NOT NULL,
    
    -- Otro
    disci_1_otro_frecuencia TINYINT DEFAULT NULL,
    disci_1_otro_especificar VARCHAR(500) DEFAULT NULL,
    
    -- PREGUNTAS 2-5
    disci_2 TEXT NOT NULL,
    disci_3 ENUM('si', 'no', 'depende') NOT NULL,
    disci_3_aclaracion TEXT NOT NULL,
    disci_4 TEXT NOT NULL,
    disci_5 TEXT NOT NULL,
    
    -- PREGUNTA 6: Metodologías activas (condicional, valores 1-4)
    disci_6_cooperativo TINYINT DEFAULT NULL,
    disci_6_problemas TINYINT DEFAULT NULL,
    disci_6_proyectos TINYINT DEFAULT NULL,
    disci_6_gamificacion TINYINT DEFAULT NULL,
    disci_6_flipped TINYINT DEFAULT NULL,
    disci_6_servicio TINYINT DEFAULT NULL,
    disci_6_personalizacion TINYINT DEFAULT NULL,
    disci_6_otro TINYINT DEFAULT NULL,
    disci_6_otro_especificar VARCHAR(500) DEFAULT NULL,
    
    -- PREGUNTAS 7-11
    disci_7 TEXT DEFAULT NULL,
    disci_8 TEXT NOT NULL,
    disci_9 TINYINT NOT NULL,
    disci_10 TEXT NOT NULL,
    disci_11 TEXT NOT NULL,
    
    FOREIGN KEY (participante_id) REFERENCES participantes(id) ON DELETE CASCADE,
    INDEX idx_participante (participante_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- VISTAS
-- ============================================================================

CREATE OR REPLACE VIEW vista_respuestas_completas AS
SELECT 
    p.id as participante_id,
    p.codigo_participante,
    p.fecha_envio,
    p.ip_address,
    p.user_agent,
    s.soci_1, s.soci_2_1, s.soci_2_2, s.soci_2_3, s.soci_2_4, s.soci_2_5, s.soci_2_6, s.soci_2_7, s.soci_2_8, s.soci_2_8_espec,
    s.soci_3, s.soci_3_resultado,
    s.soci_4_1, s.soci_4_2, s.soci_4_3, s.soci_4_4,
    s.soci_5, s.soci_6,
    d.disci_1_amonestaciones_escritas, d.disci_1_envio_jefatura, d.disci_1_apertura_expediente,
    d.disci_1_expulsion_temporal_aula, d.disci_1_expulsion_centro, d.disci_1_partes_incidencia,
    d.disci_1_suspension_extraescolares, d.disci_1_aviso_familia, d.disci_1_retirada_movil, d.disci_1_castigos,
    d.disci_1_mediacion_iguales, d.disci_1_circulos_dialogo, d.disci_1_trabajo_equipo, d.disci_1_asambleas,
    d.disci_1_autorregulacion, d.disci_1_contratos_conducta, d.disci_1_planes_personalizados,
    d.disci_1_grupos_convivencia, d.disci_1_formacion_habilidades,
    d.disci_1_refuerzo_positivo, d.disci_1_organizacion_aula, d.disci_1_normas_visuales,
    d.disci_1_tutoria_valores, d.disci_1_timeout_educativo,
    d.disci_1_servicio_comunidad, d.disci_1_aprendizaje_servicio, d.disci_1_participacion_familias,
    d.disci_1_consejos_estudiantes, d.disci_1_otro_frecuencia, d.disci_1_otro_especificar,
    d.disci_2, d.disci_3, d.disci_3_aclaracion, d.disci_4, d.disci_5,
    d.disci_6_cooperativo, d.disci_6_problemas, d.disci_6_proyectos, d.disci_6_gamificacion,
    d.disci_6_flipped, d.disci_6_servicio, d.disci_6_personalizacion, d.disci_6_otro, d.disci_6_otro_especificar,
    d.disci_7, d.disci_8, d.disci_9, d.disci_10, d.disci_11
FROM participantes p
LEFT JOIN respuestas_sociescuela s ON p.id = s.participante_id
LEFT JOIN respuestas_disciplinarias d ON p.id = d.participante_id;

CREATE OR REPLACE VIEW vista_resumen_participacion AS
SELECT 
    p.codigo_participante,
    p.fecha_envio,
    s.soci_1 as uso_sociescuela,
    CASE 
        WHEN s.soci_1 = 1 THEN 'Sí'
        WHEN s.soci_1 = 0 THEN 'No'
        ELSE 'No respondió'
    END as uso_sociescuela_texto,
    d.disci_3 as efectividad_medidas
FROM participantes p
LEFT JOIN respuestas_sociescuela s ON p.id = s.participante_id
LEFT JOIN respuestas_disciplinarias d ON p.id = d.participante_id;

-- ============================================================================
-- VERIFICACIÓN
-- ============================================================================

-- Mostrar las tablas creadas
SHOW TABLES;

-- Mostrar estructura de participantes
SHOW CREATE TABLE participantes;

-- Confirmar que NO hay restricción UNIQUE en codigo_participante
SHOW INDEX FROM participantes WHERE Column_name = 'codigo_participante';

-- ============================================================================
-- FIN DEL SCRIPT
-- ============================================================================
SELECT '✅ Base de datos creada exitosamente - Permite múltiples respuestas por código de institución' as Resultado;
