-- ============================================================================
-- CREAR USUARIO Y PERMISOS PARA LA BASE DE DATOS
-- ============================================================================
-- Este script crea un usuario específico para la aplicación con permisos limitados
-- ============================================================================

-- IMPORTANTE: Cambia la contraseña antes de ejecutar este script
-- Reemplaza 'TU_CONTRASEÑA_SEGURA' con una contraseña fuerte

-- ============================================================================
-- 1. CREAR USUARIO
-- ============================================================================

-- Crear usuario para la aplicación
-- IMPORTANTE: Cambia 'cuestionario_user' y 'TU_CONTRASEÑA_SEGURA'
CREATE USER IF NOT EXISTS 'cuestionario_user'@'localhost' 
IDENTIFIED BY 'TU_CONTRASEÑA_SEGURA';

-- ============================================================================
-- 2. OTORGAR PERMISOS
-- ============================================================================

-- Dar permisos SOLO a la base de datos del cuestionario
GRANT SELECT, INSERT, UPDATE ON cuestionario_disciplinarias.* 
TO 'cuestionario_user'@'localhost';

-- Dar permiso para ejecutar vistas
GRANT SHOW VIEW ON cuestionario_disciplinarias.* 
TO 'cuestionario_user'@'localhost';

-- Aplicar los cambios
FLUSH PRIVILEGES;

-- ============================================================================
-- 3. VERIFICAR PERMISOS
-- ============================================================================

-- Ver permisos del usuario
SHOW GRANTS FOR 'cuestionario_user'@'localhost';

-- ============================================================================
-- 4. CONFIGURACIÓN PARA PHP
-- ============================================================================

-- Usa estos datos en tu archivo config.php:
-- 
-- <?php
-- define('DB_HOST', 'localhost');
-- define('DB_NAME', 'cuestionario_disciplinarias');
-- define('DB_USER', 'cuestionario_user');
-- define('DB_PASS', 'TU_CONTRASEÑA_SEGURA');
-- ?>

-- ============================================================================
-- 5. COMANDOS ÚTILES
-- ============================================================================

-- Para cambiar la contraseña del usuario más adelante:
-- ALTER USER 'cuestionario_user'@'localhost' IDENTIFIED BY 'NUEVA_CONTRASEÑA';

-- Para eliminar el usuario (si es necesario):
-- DROP USER IF EXISTS 'cuestionario_user'@'localhost';

-- Para ver todos los usuarios:
-- SELECT User, Host FROM mysql.user;

-- ============================================================================
-- NOTAS DE SEGURIDAD
-- ============================================================================

-- 1. NUNCA uses el usuario 'root' en producción
-- 2. Usa contraseñas fuertes (mínimo 12 caracteres, letras, números, símbolos)
-- 3. Guarda las credenciales en un archivo .env (NO lo subas a Git)
-- 4. Este usuario NO tiene permisos para:
--    - Eliminar tablas (DROP)
--    - Crear nuevas tablas (CREATE)
--    - Modificar estructura (ALTER)
--    - Acceder a otras bases de datos
-- 5. Los permisos están limitados a SELECT, INSERT, UPDATE
--    (no puede hacer DELETE masivo)

-- ============================================================================
-- EJEMPLO DE GENERACIÓN DE CONTRASEÑA SEGURA
-- ============================================================================

-- Puedes generar una contraseña segura en:
-- https://passwordsgenerator.net/
-- 
-- O en Linux/Mac con este comando:
-- openssl rand -base64 32
--
-- O en Windows PowerShell:
-- Add-Type -AssemblyName 'System.Web'
-- [System.Web.Security.Membership]::GeneratePassword(16,4)

-- ============================================================================
-- FIN DEL SCRIPT
-- ============================================================================
