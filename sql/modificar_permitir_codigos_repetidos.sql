-- ============================================================================
-- MODIFICACIÓN: PERMITIR MÚLTIPLES RESPUESTAS POR CÓDIGO DE INSTITUCIÓN
-- ============================================================================
-- Fecha: 3 de febrero de 2026
-- Descripción: Cada código representa una institución y debe permitir
--              múltiples respuestas (múltiples participantes por institución)
-- ============================================================================

USE cuestionario_disciplinarias;

-- Eliminar la restricción UNIQUE del código_participante
-- Esto permitirá que el mismo código de institución pueda tener múltiples respuestas

ALTER TABLE participantes 
DROP INDEX codigo_participante;

-- Mantener el índice normal (sin UNIQUE) para optimizar búsquedas
ALTER TABLE participantes 
ADD INDEX idx_codigo_participante (codigo_participante);

-- Verificar el cambio
SHOW INDEX FROM participantes;

-- ============================================================================
-- NOTA IMPORTANTE:
-- ============================================================================
-- Después de ejecutar este script:
-- 1. El mismo código de institución podrá usarse múltiples veces
-- 2. Cada envío del cuestionario creará un nuevo registro en la tabla
-- 3. Se recomienda actualizar el archivo procesar.php para eliminar 
--    la validación de código duplicado
-- 4. Se recomienda actualizar exito.php para cambiar el mensaje
-- ============================================================================
