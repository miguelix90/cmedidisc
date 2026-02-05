# CAMBIOS: MÚLTIPLES RESPUESTAS POR CÓDIGO DE INSTITUCIÓN

**Fecha:** 3 de febrero de 2026  
**Versión:** 2.1

---

## 📋 RESUMEN DEL CAMBIO

Se ha modificado el sistema para permitir **múltiples respuestas por código de institución**. Anteriormente cada código era único y solo permitía una respuesta. Ahora:

- **Cada código representa una institución educativa**
- **Múltiples participantes de la misma institución pueden usar el mismo código**
- **Cada respuesta se guarda como un registro independiente**

---

## 🔧 ARCHIVOS MODIFICADOS

### 1. **Base de datos**
- ✅ Eliminada restricción UNIQUE en `codigo_participante`
- ✅ Mantenido índice para optimización de búsquedas

### 2. **procesar.php**
- ✅ Eliminada validación de código duplicado
- ✅ Ya no muestra error cuando el mismo código se usa múltiples veces

### 3. **exito.php**
- ✅ Actualizado mensaje de confirmación
- ✅ Ahora informa que el código representa la institución y permite múltiples participantes

### 4. **sql/crear_base_datos.sql**
- ✅ Actualizado para nuevas instalaciones
- ✅ Añadidos comentarios explicativos

### 5. **sql/modificar_permitir_codigos_repetidos.sql** (NUEVO)
- ✅ Script para aplicar cambios a bases de datos existentes

---

## 🚀 CÓMO APLICAR LOS CAMBIOS

### Si ya tienes datos en la base de datos:

**Opción 1: Ejecutar script SQL**
```sql
-- En phpMyAdmin o tu cliente MySQL
-- Ejecuta el archivo: sql/modificar_permitir_codigos_repetidos.sql
```

**Opción 2: Comando manual**
```sql
USE cuestionario_disciplinarias;

-- Eliminar restricción UNIQUE
ALTER TABLE participantes DROP INDEX codigo_participante;

-- Recrear índice normal (sin UNIQUE)
ALTER TABLE participantes ADD INDEX idx_codigo_participante (codigo_participante);

-- Verificar
SHOW INDEX FROM participantes;
```

### Si es una instalación nueva:

Simplemente ejecuta `sql/crear_base_datos.sql` - ya incluye los cambios.

---

## 📊 IMPACTO EN LOS DATOS

### **Antes:**
```
Código: INST001 → 1 respuesta máximo
Código: INST002 → 1 respuesta máximo
```

### **Ahora:**
```
Código: INST001 → múltiples respuestas (participante A, B, C...)
Código: INST002 → múltiples respuestas (participante X, Y, Z...)
```

### **Estructura de datos:**
```sql
participantes
├── id: 1,  codigo: "INST001", fecha: 2026-01-20 10:00:00
├── id: 2,  codigo: "INST001", fecha: 2026-01-20 14:30:00  ← Mismo código, diferente participante
├── id: 3,  codigo: "INST002", fecha: 2026-01-21 09:15:00
└── id: 4,  codigo: "INST001", fecha: 2026-01-21 16:45:00  ← Mismo código, diferente participante
```

---

## 📈 CONSULTAS ÚTILES

### Ver cuántas respuestas tiene cada institución:
```sql
SELECT 
    codigo_participante as codigo_institucion,
    COUNT(*) as total_respuestas,
    MIN(fecha_envio) as primera_respuesta,
    MAX(fecha_envio) as ultima_respuesta
FROM participantes
GROUP BY codigo_participante
ORDER BY total_respuestas DESC;
```

### Ver todas las respuestas de una institución específica:
```sql
SELECT 
    p.id,
    p.codigo_participante,
    p.fecha_envio,
    s.soci_1,
    d.disci_3
FROM participantes p
LEFT JOIN respuestas_sociescuela s ON p.id = s.participante_id
LEFT JOIN respuestas_disciplinarias d ON p.id = d.participante_id
WHERE p.codigo_participante = 'INST001'
ORDER BY p.fecha_envio;
```

### Encontrar instituciones con múltiples participantes:
```sql
SELECT 
    codigo_participante,
    COUNT(*) as num_participantes
FROM participantes
GROUP BY codigo_participante
HAVING COUNT(*) > 1
ORDER BY num_participantes DESC;
```

---

## ⚠️ CONSIDERACIONES IMPORTANTES

1. **Identificación de participantes individuales:**
   - Cada respuesta tiene un `id` único en la tabla `participantes`
   - Las respuestas se relacionan por `participante_id` (no por código)

2. **Análisis de datos:**
   - Para análisis por institución: agrupa por `codigo_participante`
   - Para análisis individual: usa el `id` del participante

3. **No hay límite de respuestas:**
   - Una institución puede tener tantas respuestas como necesite
   - Útil para colegios grandes con múltiples departamentos

4. **Compatibilidad hacia atrás:**
   - Los datos existentes siguen siendo válidos
   - Las instituciones con una sola respuesta funcionan igual que antes

---

## 🧪 PRUEBAS RECOMENDADAS

Después de aplicar los cambios:

1. ✅ Enviar 2-3 cuestionarios con el mismo código
2. ✅ Verificar que todos se guarden correctamente
3. ✅ Revisar que el mensaje en `exito.php` sea correcto
4. ✅ Ejecutar las consultas SQL de ejemplo
5. ✅ Verificar que los datos se relacionen correctamente en las vistas

---

## 📝 NOTAS ADICIONALES

- La validación del lado del cliente (JavaScript) no cambia
- Los campos obligatorios siguen siendo los mismos
- La seguridad (prepared statements, sanitización) se mantiene
- El sistema de transacciones SQL sigue funcionando igual

---

**Última actualización:** 3 de febrero de 2026  
**Estado:** ✅ Cambios completados y probados
