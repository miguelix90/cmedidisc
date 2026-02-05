# BASE DE DATOS - CUESTIONARIO MEDIDAS DISCIPLINARIAS

## 📋 DESCRIPCIÓN

Base de datos MySQL para almacenar las respuestas del cuestionario sobre medidas disciplinarias y metodologías activas en centros educativos.

**Fecha de creación:** 21 de enero de 2026  
**Última modificación:** 3 de febrero de 2026  
**Nombre BD:** `cuestionario_disciplinarias`  
**Charset:** `utf8mb4_unicode_ci`

---

## ⚠️ IMPORTANTE - MÚLTIPLES RESPUESTAS POR CÓDIGO

**Cada código representa una INSTITUCIÓN educativa**, no un participante individual.

- ✅ Múltiples participantes de la misma institución pueden usar el mismo código
- ✅ Cada respuesta se guarda como un registro independiente
- ✅ No hay límite de respuestas por código

**Ejemplo:**
```
Código: INST001 → Participante A (Profesor de Matemáticas)
Código: INST001 → Participante B (Orientador)
Código: INST001 → Participante C (Director)
```

---

## 🗂️ ARCHIVOS DISPONIBLES

### **Para instalación desde cero (PRUEBAS):**
1. **`RECREAR_BASE_DATOS_COMPLETA.sql`** ⭐ **RECOMENDADO PARA PRUEBAS**
   - Borra completamente la BD si existe
   - Crea todo desde cero
   - Incluye verificaciones al final
   - **⚠️ ADVERTENCIA: Elimina todos los datos existentes**

2. **`crear_base_datos.sql`**
   - Script original de creación
   - Usa `CREATE IF NOT EXISTS` (no borra datos)
   - Para primera instalación

### **Para bases de datos existentes:**
3. **`modificar_permitir_codigos_repetidos.sql`**
   - Solo modifica la restricción UNIQUE
   - Para actualizar sin perder datos
   - Uso: Si ya tienes datos y quieres permitir códigos repetidos

### **Otros archivos:**
4. **`consultas_utiles.sql`** - Consultas para análisis de datos
5. **`crear_usuario.sql`** - Crear usuario específico para producción
6. **`README.md`** - Este archivo

---

## 🚀 INSTALACIÓN RÁPIDA (FASE DE PRUEBAS)

### **Método 1: phpMyAdmin (RECOMENDADO)**

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Clic en pestaña **"SQL"**
3. Clic en **"Importar archivo"** o copia el contenido de `RECREAR_BASE_DATOS_COMPLETA.sql`
4. Clic en **"Continuar"**
5. ✅ Verás mensaje: *"Base de datos creada exitosamente"*

### **Método 2: Consola MySQL**

```bash
# Desde la carpeta jtest
cd D:\laragon_8\www\jtest
mysql -u root -p < sql/RECREAR_BASE_DATOS_COMPLETA.sql
```

---

## 🗄️ ESTRUCTURA DE LA BASE DE DATOS

### **Tabla 1: `participantes`**
Información básica de cada participante/respuesta.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | INT AUTO_INCREMENT | ID único de esta respuesta (PK) |
| `codigo_participante` | VARCHAR(100) | Código de la institución (permite duplicados) |
| `fecha_envio` | TIMESTAMP | Fecha y hora de envío |
| `ip_address` | VARCHAR(45) | Dirección IP |
| `user_agent` | TEXT | Navegador y sistema operativo |

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `idx_codigo` (permite duplicados)
- INDEX: `idx_fecha`

**⚠️ CAMBIO IMPORTANTE:** Ya NO hay restricción UNIQUE en `codigo_participante`

---

### **Tabla 2: `respuestas_sociescuela`**
Respuestas de la Sección 1 (Sociescuela).

**Relación:** `participante_id` → `participantes.id` (CASCADE)

#### **Variables:**

**PREGUNTA 1:** `soci_1` (TINYINT)
- Valores: `1` = Sí, `0` = No
- ¿Ha utilizado Sociescuela?

**PREGUNTA 2:** (Condicional - solo si `soci_1 = 1`)
- `soci_2_1` a `soci_2_8` (TINYINT): Checkboxes de usos
- `soci_2_8_espec` (VARCHAR): Especificar otra

**PREGUNTA 3:** (Condicional)
- `soci_3` (TINYINT): ¿Nueva evaluación? (1=Sí, 0=No)
- `soci_3_resultado` (TEXT): Resultado de la evaluación

**PREGUNTA 4:** (Condicional)
- `soci_4_1` a `soci_4_4` (TINYINT): Quién usa la herramienta

**PREGUNTA 5:** (Condicional)
- `soci_5` (TINYINT): Grado de satisfacción (1-10)

**PREGUNTA 6:** (Condicional)
- `soci_6` (TEXT): Sugerencias de mejora

---

### **Tabla 3: `respuestas_disciplinarias`**
Respuestas de la Sección 2 (Medidas Disciplinarias y Metodologías).

**Relación:** `participante_id` → `participantes.id` (CASCADE)

#### **PREGUNTA 1: Medidas Disciplinarias (28 campos)**

**Valores:** 1-5
- `1` = Nunca
- `2` = Rara vez
- `3` = A veces
- `4` = Frecuentemente
- `5` = Siempre

**Medidas tradicionales (10):**
- `disci_1_amonestaciones_escritas`
- `disci_1_envio_jefatura`
- `disci_1_apertura_expediente`
- `disci_1_expulsion_temporal_aula`
- `disci_1_expulsion_centro`
- `disci_1_partes_incidencia`
- `disci_1_suspension_extraescolares`
- `disci_1_aviso_familia`
- `disci_1_retirada_movil`
- `disci_1_castigos`

**Medidas restauradoras (9):**
- `disci_1_mediacion_iguales`
- `disci_1_circulos_dialogo`
- `disci_1_trabajo_equipo`
- `disci_1_asambleas`
- `disci_1_autorregulacion`
- `disci_1_contratos_conducta`
- `disci_1_planes_personalizados`
- `disci_1_grupos_convivencia`
- `disci_1_formacion_habilidades`

**Medidas pedagógicas (5):**
- `disci_1_refuerzo_positivo`
- `disci_1_organizacion_aula`
- `disci_1_normas_visuales`
- `disci_1_tutoria_valores`
- `disci_1_timeout_educativo`

**Medidas comunitarias (4):**
- `disci_1_servicio_comunidad`
- `disci_1_aprendizaje_servicio`
- `disci_1_participacion_familias`
- `disci_1_consejos_estudiantes`

**Otro:**
- `disci_1_otro_frecuencia` (TINYINT)
- `disci_1_otro_especificar` (VARCHAR)

#### **PREGUNTA 2-5:**
- `disci_2` (TEXT): Medidas adicionales
- `disci_3` (ENUM): Efectividad ('si', 'no', 'depende')
- `disci_3_aclaracion` (TEXT): Aclaración
- `disci_4` (TEXT): Medidas más efectivas
- `disci_5` (TEXT): Desafíos

#### **PREGUNTA 6: Metodologías Activas (CONDICIONAL)**

**Valores:** 1-4
- `1` = Nivel integral a nivel de centro
- `2` = En una o varias asignaturas
- `3` = En alguna asignatura
- `4` = No aplicable

**Campos:**
- `disci_6_cooperativo`
- `disci_6_problemas`
- `disci_6_proyectos`
- `disci_6_gamificacion`
- `disci_6_flipped`
- `disci_6_servicio`
- `disci_6_personalizacion`
- `disci_6_otro`
- `disci_6_otro_especificar` (VARCHAR)

#### **PREGUNTA 7-11:**
- `disci_7` (TEXT): Información adicional
- `disci_8` (TEXT): Efectividad en aprendizaje
- `disci_9` (TINYINT): Efectividad en convivencia (1-4)
- `disci_10` (TEXT): Explicación
- `disci_11` (TEXT): Desafíos metodologías

---

## 📊 VISTAS CREADAS

### `vista_respuestas_completas`
Une las 3 tablas para ver todas las respuestas de un participante.

### `vista_resumen_participacion`
Resumen básico por respuesta: código, fecha, uso de Sociescuela, efectividad.

---

## 🔍 VERIFICACIÓN POST-INSTALACIÓN

```sql
USE cuestionario_disciplinarias;

-- Ver tablas creadas
SHOW TABLES;

-- Verificar que NO hay UNIQUE en codigo_participante
SHOW INDEX FROM participantes WHERE Column_name = 'codigo_participante';
-- Resultado esperado: Key_name = 'idx_codigo' (no 'codigo_participante')

-- Probar inserción de múltiples códigos
INSERT INTO participantes (codigo_participante) VALUES ('TEST001');
INSERT INTO participantes (codigo_participante) VALUES ('TEST001');
-- Ambas deberían ejecutarse SIN error

-- Verificar
SELECT * FROM participantes WHERE codigo_participante = 'TEST001';
-- Deberías ver 2 registros
```

---

## 📈 CONSULTAS ÚTILES

### Ver respuestas por institución:
```sql
SELECT 
    codigo_participante as institucion,
    COUNT(*) as total_respuestas,
    MIN(fecha_envio) as primera_respuesta,
    MAX(fecha_envio) as ultima_respuesta
FROM participantes
GROUP BY codigo_participante
ORDER BY total_respuestas DESC;
```

### Ver todas las respuestas de una institución:
```sql
SELECT * FROM vista_respuestas_completas 
WHERE codigo_participante = 'INST001'
ORDER BY fecha_envio;
```

### Instituciones con múltiples participantes:
```sql
SELECT 
    codigo_participante,
    COUNT(*) as participantes
FROM participantes
GROUP BY codigo_participante
HAVING COUNT(*) > 1;
```

Más consultas en: `consultas_utiles.sql`

---

## 🔐 SEGURIDAD

### **Desarrollo (Laragon):**
- Usuario: `root`
- Contraseña: (vacía)
- OK para desarrollo local

### **Producción:**
1. Crear usuario específico: `consultas/crear_usuario.sql`
2. Contraseña fuerte
3. Permisos limitados
4. Backups automáticos

---

## 🎯 FLUJO DE TRABAJO (PRUEBAS)

1. **Reiniciar desde cero:**
   ```bash
   mysql -u root < sql/RECREAR_BASE_DATOS_COMPLETA.sql
   ```

2. **Probar cuestionario:**
   - `http://localhost/jtest/?codigo=TEST001`
   - Completar y enviar
   - Repetir con mismo código → ✅ Debe funcionar

3. **Verificar datos:**
   ```sql
   SELECT * FROM participantes;
   ```

4. **Limpiar y volver a empezar:**
   - Ejecutar de nuevo `RECREAR_BASE_DATOS_COMPLETA.sql`

---

## 📝 CAMBIOS RECIENTES

**v2.1 - 3 de febrero de 2026:**
- ✅ Eliminada restricción UNIQUE en `codigo_participante`
- ✅ Ahora permite múltiples respuestas por código
- ✅ Añadido script `RECREAR_BASE_DATOS_COMPLETA.sql`
- ✅ Actualizada documentación

**v2.0 - 21 de enero de 2026:**
- ✅ Script inicial de creación de base de datos

---

**Última actualización:** 3 de febrero de 2026
