-- ============================================================================
-- BASE DE DATOS: CUESTIONARIO MEDIDAS DISCIPLINARIAS Y METODOLOGÍAS ACTIVAS
-- ============================================================================
-- Fecha de creación: 21 de enero de 2026
-- Última modificación: 3 de febrero de 2026
-- Descripción: Base de datos para almacenar respuestas del cuestionario
-- IMPORTANTE: Cada código representa una institución y permite múltiples respuestas
-- ============================================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS cuestionario_disciplinarias 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE cuestionario_disciplinarias;

-- ============================================================================
-- TABLA 1: PARTICIPANTES
-- ============================================================================
-- Almacena información básica de cada participante

CREATE TABLE IF NOT EXISTS participantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_participante VARCHAR(100) NOT NULL COMMENT 'Código de la institución - permite múltiples respuestas',
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    INDEX idx_codigo (codigo_participante),
    INDEX idx_fecha (fecha_envio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Cada código representa una institución y permite múltiples participantes';

-- ============================================================================
-- TABLA 2: RESPUESTAS SOCIESCUELA (SECCIÓN 1)
-- ============================================================================
-- Almacena las respuestas de la sección 1 (Sociescuela)

CREATE TABLE IF NOT EXISTS respuestas_sociescuela (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participante_id INT NOT NULL,
    
    -- PREGUNTA 1: ¿Ha utilizado Sociescuela?
    soci_1 TINYINT NOT NULL COMMENT '1=Sí, 0=No',
    
    -- PREGUNTA 2: ¿Para qué ha utilizado Sociescuela? (condicional)
    soci_2_1 TINYINT DEFAULT NULL COMMENT 'Crear grupos de ayuda entre iguales',
    soci_2_2 TINYINT DEFAULT NULL COMMENT 'Trabajar en equipos cooperativos',
    soci_2_3 TINYINT DEFAULT NULL COMMENT 'Modificar la colocación en el aula',
    soci_2_4 TINYINT DEFAULT NULL COMMENT 'Organizar grupos de un curso para el siguiente',
    soci_2_5 TINYINT DEFAULT NULL COMMENT 'Para realizar mediación o resolución de conflictos',
    soci_2_6 TINYINT DEFAULT NULL COMMENT 'Para trabajar el ciberacoso',
    soci_2_7 TINYINT DEFAULT NULL COMMENT 'Para prevención de la violencia',
    soci_2_8 TINYINT DEFAULT NULL COMMENT 'Otra',
    soci_2_8_espec VARCHAR(500) DEFAULT NULL COMMENT 'Especificar otra',
    
    -- PREGUNTA 3: ¿Nueva evaluación? (condicional)
    soci_3 TINYINT DEFAULT NULL COMMENT '1=Sí, 0=No',
    soci_3_resultado TEXT DEFAULT NULL COMMENT '¿Cuál fue el resultado?',
    
    -- PREGUNTA 4: ¿Quién utiliza la herramienta? (condicional)
    soci_4_1 TINYINT DEFAULT NULL COMMENT 'Departamento de orientación',
    soci_4_2 TINYINT DEFAULT NULL COMMENT 'Equipo directivo',
    soci_4_3 TINYINT DEFAULT NULL COMMENT 'Tutores/as',
    soci_4_4 TINYINT DEFAULT NULL COMMENT 'Profesores/as',
    
    -- PREGUNTA 5: Grado de satisfacción (condicional)
    soci_5 TINYINT DEFAULT NULL COMMENT 'Escala 1-10',
    
    -- PREGUNTA 6: Sugerencias (condicional)
    soci_6 TEXT DEFAULT NULL COMMENT 'Sugerencias de mejora',
    
    FOREIGN KEY (participante_id) REFERENCES participantes(id) ON DELETE CASCADE,
    INDEX idx_participante (participante_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA 3: RESPUESTAS DISCIPLINARIAS (SECCIÓN 2)
-- ============================================================================
-- Almacena las respuestas de la sección 2 (Medidas Disciplinarias y Metodologías)

CREATE TABLE IF NOT EXISTS respuestas_disciplinarias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participante_id INT NOT NULL,
    
    -- PREGUNTA 1: Medidas disciplinarias (27 medidas + otro)
    -- Valores: 1=Nunca, 2=Rara vez, 3=A veces, 4=Frecuentemente, 5=Siempre
    
    -- Medidas tradicionales
    disci_1_amonestaciones_escritas TINYINT NOT NULL COMMENT '1-5',
    disci_1_envio_jefatura TINYINT NOT NULL COMMENT '1-5',
    disci_1_apertura_expediente TINYINT NOT NULL COMMENT '1-5',
    disci_1_expulsion_temporal_aula TINYINT NOT NULL COMMENT '1-5',
    disci_1_expulsion_centro TINYINT NOT NULL COMMENT '1-5',
    disci_1_partes_incidencia TINYINT NOT NULL COMMENT '1-5',
    disci_1_suspension_extraescolares TINYINT NOT NULL COMMENT '1-5',
    disci_1_aviso_familia TINYINT NOT NULL COMMENT '1-5',
    disci_1_retirada_movil TINYINT NOT NULL COMMENT '1-5',
    disci_1_castigos TINYINT NOT NULL COMMENT '1-5',
    
    -- Medidas restauradoras
    disci_1_mediacion_iguales TINYINT NOT NULL COMMENT '1-5',
    disci_1_circulos_dialogo TINYINT NOT NULL COMMENT '1-5',
    disci_1_trabajo_equipo TINYINT NOT NULL COMMENT '1-5',
    disci_1_asambleas TINYINT NOT NULL COMMENT '1-5',
    disci_1_autorregulacion TINYINT NOT NULL COMMENT '1-5',
    disci_1_contratos_conducta TINYINT NOT NULL COMMENT '1-5',
    disci_1_planes_personalizados TINYINT NOT NULL COMMENT '1-5',
    disci_1_grupos_convivencia TINYINT NOT NULL COMMENT '1-5',
    disci_1_formacion_habilidades TINYINT NOT NULL COMMENT '1-5',
    
    -- Medidas pedagógicas
    disci_1_refuerzo_positivo TINYINT NOT NULL COMMENT '1-5',
    disci_1_organizacion_aula TINYINT NOT NULL COMMENT '1-5',
    disci_1_normas_visuales TINYINT NOT NULL COMMENT '1-5',
    disci_1_tutoria_valores TINYINT NOT NULL COMMENT '1-5',
    disci_1_timeout_educativo TINYINT NOT NULL COMMENT '1-5',
    
    -- Medidas comunitarias
    disci_1_servicio_comunidad TINYINT NOT NULL COMMENT '1-5',
    disci_1_aprendizaje_servicio TINYINT NOT NULL COMMENT '1-5',
    disci_1_participacion_familias TINYINT NOT NULL COMMENT '1-5',
    disci_1_consejos_estudiantes TINYINT NOT NULL COMMENT '1-5',
    
    -- Otro
    disci_1_otro_frecuencia TINYINT DEFAULT NULL COMMENT '1-5',
    disci_1_otro_especificar VARCHAR(500) DEFAULT NULL COMMENT 'Especificar otra medida',
    
    -- PREGUNTA 2: Medidas adicionales
    disci_2 TEXT NOT NULL COMMENT '¿Existen otras medidas?',
    
    -- PREGUNTA 3: Efectividad de las medidas
    disci_3 ENUM('si', 'no', 'depende') NOT NULL COMMENT 'Efectividad de medidas',
    disci_3_aclaracion TEXT NOT NULL COMMENT 'Aclaración sobre efectividad',
    
    -- PREGUNTA 4: Medidas más efectivas
    disci_4 TEXT NOT NULL COMMENT '¿Qué medidas son más efectivas?',
    
    -- PREGUNTA 5: Desafíos
    disci_5 TEXT NOT NULL COMMENT 'Desafíos en aplicación de medidas',
    
    -- PREGUNTA 6: Metodologías activas (CONDICIONAL - solo si alguna medida != nunca)
    -- Valores: 1=Nivel integral, 2=Una o varias asignaturas, 3=Alguna asignatura, 4=No aplicable
    disci_6_cooperativo TINYINT DEFAULT NULL COMMENT '1-4: Aprendizaje cooperativo',
    disci_6_problemas TINYINT DEFAULT NULL COMMENT '1-4: Aprendizaje basado en problemas',
    disci_6_proyectos TINYINT DEFAULT NULL COMMENT '1-4: Aprendizaje basado en proyectos',
    disci_6_gamificacion TINYINT DEFAULT NULL COMMENT '1-4: Gamificación',
    disci_6_flipped TINYINT DEFAULT NULL COMMENT '1-4: Clase invertida',
    disci_6_servicio TINYINT DEFAULT NULL COMMENT '1-4: Aprendizaje-servicio',
    disci_6_personalizacion TINYINT DEFAULT NULL COMMENT '1-4: Personalización del aprendizaje',
    disci_6_otro TINYINT DEFAULT NULL COMMENT '1-4: Otro',
    disci_6_otro_especificar VARCHAR(500) DEFAULT NULL COMMENT 'Especificar otra metodología',
    
    -- PREGUNTA 7: Información adicional (opcional)
    disci_7 TEXT DEFAULT NULL COMMENT 'Más información sobre aplicación',
    
    -- PREGUNTA 8: Efectividad en aprendizaje
    disci_8 TEXT NOT NULL COMMENT 'Efectividad de metodologías en aprendizaje',
    
    -- PREGUNTA 9: Efectividad en convivencia
    -- Valores: 1=Nada, 2=Poco, 3=Bastante, 4=Mucho
    disci_9 TINYINT NOT NULL COMMENT '1-4: Efectividad en convivencia',
    
    -- PREGUNTA 10: Explicación
    disci_10 TEXT NOT NULL COMMENT 'Explicación sobre efectividad en convivencia',
    
    -- PREGUNTA 11: Desafíos metodologías
    disci_11 TEXT NOT NULL COMMENT 'Desafíos en implementación de metodologías activas',
    
    FOREIGN KEY (participante_id) REFERENCES participantes(id) ON DELETE CASCADE,
    INDEX idx_participante (participante_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- VISTAS ÚTILES PARA ANÁLISIS
-- ============================================================================

-- Vista completa de todas las respuestas
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

-- Vista de resumen de participación
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
-- FIN DEL SCRIPT
-- ============================================================================

-- Para ejecutar este script:
-- 1. Abre phpMyAdmin o tu cliente MySQL
-- 2. Importa este archivo o copia y pega el contenido
-- 3. Ejecuta el script completo
-- 4. Verifica que las tablas se hayan creado correctamente
