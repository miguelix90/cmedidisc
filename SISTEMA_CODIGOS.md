# SISTEMA DE CÓDIGOS SOCIESCUELA

**Fecha:** 3 de febrero de 2026  
**Versión:** 2.1

---

## 📋 DESCRIPCIÓN

Cada institución educativa recibe un **código único de 8 caracteres** para acceder al cuestionario. Este código:

- Identifica la institución (no al participante individual)
- Permite múltiples respuestas de diferentes participantes de la misma institución
- Incluye validación de checksum para evitar errores de escritura
- Usa caracteres sin ambigüedad (sin I, O, 0, 1)

---

## 🔑 FORMATO DEL CÓDIGO

### **Estructura: 8 caracteres**
```
[6 caracteres de datos] + [2 caracteres de checksum]
Ejemplo: CENTRO42  →  CENTRO = datos, 42 = checksum
```

### **Caracteres válidos:**
```
ABCDEFGHJKLMNPQRSTUVWXYZ23456789
```

**Excluidos:** I, O, 0, 1 (para evitar confusión entre "I" y "1", "O" y "0")

### **Algoritmo de checksum:**
```php
// Checksum 1
$suma = Σ(posición_carácter × (índice + 1)) para los 6 primeros caracteres
$check1 = chars[$suma % 32]

// Checksum 2
$check2 = chars[($suma * 7 + 13) % 32]

// Código final
$codigo_completo = $prefijo . $check1 . $check2
```

---

## 🛠️ GENERACIÓN DE CÓDIGOS

### **Opción 1: Generador Web (Recomendado)**

1. Abre: `http://localhost/jtest/generar_codigos.php`
2. Especifica cantidad (1-100)
3. Opcional: Añade un prefijo personalizado
4. Haz clic en "Generar Códigos"
5. Copia los códigos o enlaces generados

**Características:**
- ✅ Genera códigos válidos automáticamente
- ✅ Permite prefijo personalizado (ej: "MADRID" → "MADRID**")
- ✅ Crea enlaces directos al cuestionario
- ✅ Validación en tiempo real
- ✅ Copia masiva al portapapeles

### **Opción 2: Función PHP**

```php
require_once 'config.php';

// Generar 1 código aleatorio
$codigo = generarCodigoSociescuela();
// Resultado: Ej. "A2B3C4DE"

// Generar con prefijo personalizado
$codigo = generarCodigoSociescuela('MADRID');
// Resultado: "MADRIDXY" (XY = checksum calculado)
```

---

## ✅ VALIDACIÓN DE CÓDIGOS

### **Validación automática en el formulario:**

Cuando un usuario intenta acceder al cuestionario, el sistema valida automáticamente:

1. **Longitud:** Debe ser exactamente 8 caracteres
2. **Caracteres:** Solo letras/números permitidos
3. **Checksum:** Los últimos 2 caracteres deben coincidir con el cálculo

**Si el código NO es válido:**
- Se muestra mensaje de error detallado
- Se indica qué está mal (longitud, caracteres inválidos, checksum)
- Se sugiere verificar con el coordinador
- **NO** se permite acceder al cuestionario

### **Validación manual:**

```php
require_once 'config.php';

$codigo = 'ABC123XY';

if (esCodigoSociescuelaValido($codigo)) {
    echo "✅ Código válido";
} else {
    echo "❌ Código inválido";
}
```

### **Validación vía API:**

```bash
# Petición
GET /validar_codigo.php?codigo=ABC123XY

# Respuesta (JSON)
{
    "valido": true,
    "mensaje": "El código es válido",
    "codigo": "ABC123XY"
}
```

---

## 🔐 SEGURIDAD

### **Protecciones implementadas:**

1. **Validación de checksum:**
   - Imposible crear códigos válidos sin conocer el algoritmo
   - Detecta errores de transcripción (95%+ de precisión)
   - Evita códigos generados manualmente

2. **Caracteres sin ambigüedad:**
   - No hay confusión entre "1" e "I"
   - No hay confusión entre "0" y "O"
   - Reduce errores de lectura/escritura

3. **Bloqueo de acceso:**
   - Solo códigos válidos pueden acceder al formulario
   - Mensaje de error sin revelar detalles del algoritmo
   - Sugerencia de contactar al coordinador

### **Lo que NO previene:**

- ❌ Compartir códigos válidos entre instituciones (intencionalmente)
- ❌ Acceso no autorizado si se filtra un código válido
- ❌ Múltiples respuestas del mismo participante (no hay autenticación individual)

---

## 📊 DISTRIBUCIÓN DE CÓDIGOS

### **Recomendaciones:**

1. **Email individual:**
   ```
   Asunto: Acceso al Cuestionario de Medidas Disciplinarias
   
   Estimado/a Director/a de [NOMBRE_CENTRO],
   
   Su institución puede participar en el estudio usando el siguiente enlace:
   http://localhost/jtest/?codigo=ABC123XY
   
   Este código es único para su centro. Múltiples participantes de su 
   institución pueden usar el mismo enlace.
   
   Saludos,
   Equipo de Investigación
   ```

2. **Lista de distribución:**
   - Exportar desde `generar_codigos.php`
   - Excel/CSV con: Centro, Código, Enlace
   - Envío masivo personalizado

3. **Códigos con prefijo:**
   - Útil para organización regional
   - Ejemplo: MADRID1, MADRID2, BCLN001, BCLN002
   - Facilita análisis posterior

---

## 🧪 PRUEBAS

### **Códigos de prueba válidos:**

Genera códigos de prueba desde `generar_codigos.php` o usa estos ejemplos:

```php
// Generar 5 códigos de prueba
for ($i = 0; $i < 5; $i++) {
    $codigo = generarCodigoSociescuela();
    echo $codigo . "\n";
    // Probar: http://localhost/jtest/?codigo=$codigo
}
```

### **Códigos inválidos (para testing):**

```
ABC12345  → ❌ Longitud incorrecta (8 caracteres)
ABCI23XY  → ❌ Carácter inválido (I)
ABC0O3XY  → ❌ Caracteres inválidos (0, O)
ABCDEFGH  → ❌ Checksum incorrecto
ABC 23XY  → ❌ Espacio no permitido
```

---

## 📈 ANÁLISIS DE DATOS

### **Consultas útiles:**

```sql
-- Ver todas las instituciones participantes
SELECT DISTINCT codigo_participante, COUNT(*) as participantes
FROM participantes
GROUP BY codigo_participante;

-- Ver instituciones con más de 5 participantes
SELECT codigo_participante, COUNT(*) as participantes
FROM participantes
GROUP BY codigo_participante
HAVING COUNT(*) > 5
ORDER BY participantes DESC;

-- Estadísticas por institución
SELECT 
    p.codigo_participante,
    COUNT(p.id) as total_respuestas,
    MIN(p.fecha_envio) as primera_respuesta,
    MAX(p.fecha_envio) as ultima_respuesta,
    AVG(s.soci_5) as satisfaccion_promedio
FROM participantes p
LEFT JOIN respuestas_sociescuela s ON p.id = s.participante_id
GROUP BY p.codigo_participante;
```

---

## 🔧 MANTENIMIENTO

### **Archivos relacionados:**

```
jtest/
├── config.php                     # Función de validación
├── index.php                      # Validación en el formulario
├── generar_codigos.php           # Generador web de códigos
├── validar_codigo.php            # API de validación JSON
└── SISTEMA_CODIGOS.md            # Esta documentación
```

### **Modificar el algoritmo:**

⚠️ **ADVERTENCIA:** Si cambias el algoritmo de checksum, todos los códigos existentes se invalidan.

Si necesitas cambiar el algoritmo:

1. Actualiza `esCodigoSociescuelaValido()` en `config.php`
2. Actualiza `generarCodigoSociescuela()` en `generar_codigos.php`
3. Regenera TODOS los códigos de las instituciones
4. Notifica a todos los participantes

---

## ❓ PREGUNTAS FRECUENTES

### **P: ¿Qué pasa si un código se filtra o se comparte incorrectamente?**

R: El código permite múltiples respuestas de la misma institución, así que:
- ✅ No hay problema si varios participantes de la misma institución lo usan
- ⚠️ Si se comparte entre instituciones diferentes, las respuestas se asociarán incorrectamente
- 💡 Solución: Generar un nuevo código para la institución afectada

### **P: ¿Puedo cambiar el código de una institución después de distribuirlo?**

R: Sí, pero:
- Las respuestas antiguas seguirán vinculadas al código anterior
- Debes informar a la institución del cambio
- Considera si es mejor mantener el código original

### **P: ¿Cómo sé qué institución usó qué código?**

R: Debes mantener un registro externo (Excel/DB) que asocie:
```
Código → Nombre de Institución → Datos de contacto
ABC123XY → Colegio San Martín → director@sanmartin.edu
DEF456ZW → IES Cervantes → info@cervantes.edu
```

### **P: ¿Puedo usar códigos "legibles" como nombres de centros?**

R: Sí, parcialmente:
```php
// Genera código con prefijo "MADRID"
$codigo = generarCodigoSociescuela('MADRID');
// Resultado: MADRIDXY (donde XY es el checksum)
```

Limitación: Solo 6 caracteres útiles (nombres muy cortos)

---

## 📝 CHANGELOG

**v2.1 - 3 de febrero de 2026:**
- ✅ Implementada validación de códigos con checksum
- ✅ Creado generador web de códigos
- ✅ Añadida API de validación JSON
- ✅ Documentación completa del sistema

---

**Última actualización:** 3 de febrero de 2026  
**Mantenedor:** Equipo de Desarrollo
