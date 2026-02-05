# SISTEMA PHP - CUESTIONARIO DISCIPLINARIAS

## 📋 ARCHIVOS CREADOS

### **Archivos principales:**
```
D:\laragon_8\www\jtest\
├── config.php          # Configuración de conexión a BD
├── funciones.php       # Funciones auxiliares
├── procesar.php        # Procesa y guarda formulario
├── exito.php          # Página de confirmación
├── test_conexion.php  # Prueba de conexión (ELIMINAR en producción)
└── index.php          # Formulario del cuestionario
```

---

## 🚀 INSTALACIÓN Y CONFIGURACIÓN

### **Paso 1: Verificar la base de datos**

1. Asegúrate de que la base de datos esté creada:
   ```
   Nombre: cuestionario_disciplinarias
   ```

2. Verifica que las 3 tablas existan:
   - `participantes`
   - `respuestas_sociescuela`
   - `respuestas_disciplinarias`

### **Paso 2: Configurar la conexión**

Abre `config.php` y verifica/modifica:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cuestionario_disciplinarias');
define('DB_USER', 'root');      // Cambiar en producción
define('DB_PASS', '');          // Cambiar en producción
```

### **Paso 3: Probar la conexión**

1. Abre en tu navegador:
   ```
   http://localhost/jtest/test_conexion.php
   ```

2. Deberías ver:
   - ✅ Conexión exitosa
   - ✅ Todas las tablas existen
   - Información del servidor

3. Si hay errores, verifica:
   - Que Laragon esté ejecutándose
   - Que MySQL esté activo
   - Que las credenciales en `config.php` sean correctas

### **Paso 4: Probar el formulario**

1. Abre el cuestionario:
   ```
   http://localhost/jtest/?codigo=TEST001
   ```

2. Completa el formulario completo

3. Haz clic en "Enviar respuestas"

4. Deberías ser redirigido a `exito.php`

5. Verifica en phpMyAdmin que se guardaron los datos:
   ```sql
   SELECT * FROM participantes;
   SELECT * FROM respuestas_sociescuela;
   SELECT * FROM respuestas_disciplinarias;
   ```

---

## 📁 DESCRIPCIÓN DE ARCHIVOS

### **config.php**
- Configuración de conexión a MySQL
- Función `getDB()` que devuelve conexión PDO
- Configuración de zona horaria y errores
- Función de logging

**Importante:**
- En producción, cambiar `MOSTRAR_ERRORES` a `false`
- Usar credenciales seguras

### **funciones.php**
- Funciones de sanitización de datos
- Funciones de validación
- Procesadores específicos para cada sección
- Utilidades generales

**Funciones principales:**
- `sanitizar_texto()` - Limpia texto
- `sanitizar_numero()` - Valida números
- `sanitizar_checkbox()` - Procesa checkboxes
- `procesar_sociescuela()` - Procesa Sección 1
- `procesar_disciplinarias()` - Procesa Sección 2

### **procesar.php**
- Recibe datos POST del formulario
- Valida campos obligatorios
- Usa transacciones para integridad de datos
- Inserta en las 3 tablas
- Maneja errores
- Redirige a página de éxito

**Flujo:**
1. Validar método POST
2. Obtener código participante
3. Procesar datos de ambas secciones
4. Validar campos obligatorios
5. Iniciar transacción
6. Insertar en `participantes`
7. Insertar en `respuestas_sociescuela`
8. Insertar en `respuestas_disciplinarias`
9. Commit y redirección

### **exito.php**
- Página de confirmación
- Muestra código de participante
- Información importante para el usuario
- Fecha de envío

### **test_conexion.php**
- Prueba conexión a BD
- Verifica tablas
- Muestra últimos registros
- **ELIMINAR en producción**

---

## 🔐 SEGURIDAD

### **Protecciones implementadas:**

1. **Prepared Statements**
   - Todas las queries usan PDO con placeholders
   - Protección contra SQL Injection

2. **Sanitización de datos**
   - Todos los inputs son sanitizados
   - Validación de tipos de datos

3. **Transacciones**
   - Garantizan integridad de datos
   - Rollback automático en caso de error

4. **Código único**
   - Restricción UNIQUE en `codigo_participante`
   - Previene envíos duplicados

5. **Logging**
   - Registro de errores y eventos
   - Carpeta `/logs/` creada automáticamente

### **Recomendaciones adicionales:**

1. **Cambiar credenciales en producción:**
   ```php
   define('DB_USER', 'cuestionario_user');
   define('DB_PASS', 'TU_CONTRASEÑA_SEGURA');
   ```

2. **Desactivar errores en producción:**
   ```php
   define('MOSTRAR_ERRORES', false);
   ```

3. **Eliminar archivos de prueba:**
   ```bash
   rm test_conexion.php
   ```

4. **Configurar permisos de carpetas:**
   ```bash
   chmod 755 /logs/
   chmod 644 *.php
   ```

5. **Usar HTTPS en producción**

---

## 🧪 PRUEBAS

### **Prueba 1: Múltiples respuestas por código**
1. Envía el formulario con código `TEST001`
2. Envía de nuevo con el mismo código `TEST001`
3. Ambas respuestas deben guardarse correctamente (cada código representa una institución)

### **Prueba 2: Campos obligatorios**
1. Deja campos obligatorios vacíos
2. Intenta enviar
3. Debe mostrar error indicando el campo

### **Prueba 3: Validación condicional**
1. Marca "No" en Sociescuela (pregunta 1)
2. Envía el formulario
3. Verifica que campos condicionales sean NULL en BD

### **Prueba 4: Tabla grande**
1. Completa todas las 27 medidas disciplinarias
2. Verifica que se guarden todas

### **Prueba 5: Metodologías activas**
1. Marca al menos una medida diferente de "Nunca"
2. Completa pregunta 6 (metodologías)
3. Verifica que se guarden

---

## 📊 CONSULTAS ÚTILES

### **Ver todos los participantes:**
```sql
SELECT * FROM participantes ORDER BY fecha_envio DESC;
```

### **Ver respuesta completa de un participante:**
```sql
SELECT * FROM vista_respuestas_completas 
WHERE codigo_participante = 'TEST001';
```

### **Contar respuestas:**
```sql
SELECT COUNT(*) as total FROM participantes;
```

### **Últimas 10 respuestas:**
```sql
SELECT codigo_participante, fecha_envio 
FROM participantes 
ORDER BY fecha_envio DESC 
LIMIT 10;
```

### **Exportar datos:**
```sql
SELECT * FROM vista_respuestas_completas 
INTO OUTFILE '/tmp/resultados.csv'
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n';
```

---

## 🐛 SOLUCIÓN DE PROBLEMAS

### **Error: "No se puede conectar a la base de datos"**
- Verifica que Laragon esté ejecutándose
- Verifica credenciales en `config.php`
- Comprueba que MySQL esté activo

### **Error: "Tabla no encontrada"**
- Ejecuta el script `sql/crear_base_datos.sql`
- Verifica nombre de la base de datos

### **Error: "Código ya usado"**
- Cada código solo puede usarse una vez
- Usa un código diferente

### **Error: "Campo X es obligatorio"**
- Completa todos los campos marcados como requeridos
- Revisa el formulario HTML

### **Formulario no guarda datos**
- Abre `test_conexion.php` para diagnosticar
- Revisa `/logs/app.log` para errores
- Verifica permisos de carpeta `/logs/`

---

## 📝 LOGS

Los logs se guardan en:
```
D:\laragon_8\www\jtest\logs\app.log
```

Formato:
```
[2026-01-21 10:30:45] [INFO] Cuestionario guardado. ID: 1, Código: TEST001
[2026-01-21 10:31:12] [WARNING] Intento de duplicado. Código: TEST001
[2026-01-21 10:32:05] [ERROR] Error de BD: ...
```

---

## 🚀 PUESTA EN PRODUCCIÓN

### **Checklist:**

- [ ] Cambiar credenciales de BD en `config.php`
- [ ] Crear usuario específico de BD (no usar root)
- [ ] Configurar `MOSTRAR_ERRORES = false`
- [ ] Eliminar `test_conexion.php`
- [ ] Configurar HTTPS
- [ ] Configurar backup automático de BD
- [ ] Probar en servidor de producción
- [ ] Configurar permisos de archivos
- [ ] Revisar logs de errores

---

## 📞 SOPORTE

Para problemas o dudas, revisa:
1. Los logs en `/logs/app.log`
2. Este README
3. Los comentarios en el código

---

**Última actualización:** 21 de enero de 2026
