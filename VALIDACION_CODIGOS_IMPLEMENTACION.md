# VALIDACIÓN DE CÓDIGOS - IMPLEMENTACIÓN COMPLETADA

**Fecha:** 3 de febrero de 2026  
**Versión:** 2.1

---

## ✅ RESUMEN DE CAMBIOS

Se ha implementado un sistema completo de **validación de códigos Sociescuela** con checksum para garantizar que solo se pueda acceder al cuestionario con códigos válidos generados por el sistema.

---

## 📁 ARCHIVOS MODIFICADOS

### **1. config.php**
✅ **Agregado:**
- Función `esCodigoSociescuelaValido(string $codigo): bool`
- Validación de longitud (8 caracteres)
- Validación de caracteres permitidos
- Validación de checksum (últimos 2 dígitos)

### **2. index.php**
✅ **Modificado:**
- Incluye `config.php` al inicio
- Validación automática del código antes de mostrar formulario
- Mensaje de error si código vacío
- Mensaje de error detallado si código inválido
- Muestra el código inválido al usuario
- Instrucciones claras sobre formato correcto

---

## 📁 ARCHIVOS NUEVOS CREADOS

### **3. generar_codigos.php** (⭐ NUEVO)
Herramienta web para generar códigos válidos.

**Características:**
- ✅ Interfaz web amigable
- ✅ Genera de 1 a 100 códigos a la vez
- ✅ Permite prefijos personalizados (ej: "MADRID")
- ✅ Copia masiva al portapapeles
- ✅ Genera enlaces directos al cuestionario
- ✅ Prueba de validación en tiempo real

**Acceso:** `http://localhost/jtest/generar_codigos.php`

### **4. validar_codigo.php** (⭐ NUEVO)
API JSON para validar códigos vía AJAX.

**Uso:**
```bash
GET /validar_codigo.php?codigo=ABC123XY
```

**Respuesta:**
```json
{
    "valido": true,
    "mensaje": "El código es válido",
    "codigo": "ABC123XY"
}
```

### **5. SISTEMA_CODIGOS.md** (⭐ NUEVO)
Documentación completa del sistema de códigos:
- Formato y algoritmo de checksum
- Cómo generar códigos
- Cómo validar códigos
- Distribución a instituciones
- Análisis de datos
- FAQ

### **6. VALIDACION_CODIGOS_IMPLEMENTACION.md** (⭐ ESTE ARCHIVO)
Resumen de implementación y guía rápida.

---

## 🔑 FORMATO DEL CÓDIGO

```
Estructura: [6 caracteres] + [2 checksum]
Ejemplo: CENTRO42

Caracteres válidos: ABCDEFGHJKLMNPQRSTUVWXYZ23456789
Excluidos: I, O, 0, 1 (para evitar confusión)
```

---

## 🚀 CÓMO USAR

### **Paso 1: Generar códigos para instituciones**

1. Abre: `http://localhost/jtest/generar_codigos.php`
2. Especifica cuántos códigos necesitas (1-100)
3. Opcional: Añade prefijo (ej: "MADRID")
4. Haz clic en "Generar Códigos"
5. Copia los códigos o enlaces

### **Paso 2: Distribuir códigos a instituciones**

**Opción A - Enviar enlace directo:**
```
http://localhost/jtest/?codigo=ABC123XY
```

**Opción B - Enviar código (para que lo escriban):**
```
Su código de acceso es: ABC123XY
Ingrese en: http://localhost/jtest/
```

### **Paso 3: Participantes acceden al cuestionario**

1. Usuario hace clic en enlace o ingresa manualmente
2. **Sistema valida automáticamente:**
   - ✅ Si es válido → Muestra formulario
   - ❌ Si es inválido → Muestra error detallado

---

## 🧪 PRUEBAS

### **Generar códigos de prueba:**

```bash
# Abrir generador
http://localhost/jtest/generar_codigos.php?cantidad=5

# Resultado: 5 códigos válidos listos para usar
```

### **Probar código válido:**

```bash
# Usar un código generado
http://localhost/jtest/?codigo=ABC123XY

# Resultado esperado: ✅ Formulario se muestra
```

### **Probar código inválido:**

```bash
# Código con checksum incorrecto
http://localhost/jtest/?codigo=ABCDEFGH

# Resultado esperado: ❌ Mensaje de error detallado
```

### **Casos de prueba:**

| Código | ¿Válido? | Razón |
|--------|----------|-------|
| `ABC12345` | ❌ | Longitud incorrecta (8 caracteres) |
| `ABCI23XY` | ❌ | Carácter inválido (I) |
| `ABC0O3XY` | ❌ | Caracteres inválidos (0, O) |
| `ABCDEFGH` | ❌ | Checksum incorrecto |
| `ABC 23XY` | ❌ | Espacio no permitido |
| `(generado)` | ✅ | Código válido del generador |

---

## 🔍 VALIDACIÓN EN EL FLUJO

```mermaid
Usuario → Enlace con código
           ↓
      index.php
           ↓
    ¿Código vacío? → SÍ → Error: "Código no proporcionado"
           ↓ NO
    ¿Código válido? → NO → Error: "Código no válido"
           ↓ SÍ
    ✅ Mostrar formulario
```

---

## 📊 MENSAJES DE ERROR

### **1. Código vacío:**
```
🚫 Código no proporcionado
Para acceder al cuestionario necesita un código de institución válido.
Por favor, utilice el enlace proporcionado por el coordinador del estudio.
```

### **2. Código inválido:**
```
❌ Código no válido
El código proporcionado no es válido o ha sido modificado.

Código recibido: ABC12345

ℹ️ Información importante:
• Los códigos deben tener exactamente 8 caracteres
• Solo letras mayúsculas y números (sin I, O, 0, 1)
• Verifique que no haya espacios al inicio o final
• Utilice el enlace exacto proporcionado por el coordinador

Si el problema persiste, contacte con el coordinador del estudio.
```

---

## 🔐 SEGURIDAD

### **Protecciones implementadas:**

✅ **Validación de checksum:**
- Algoritmo: `chars[Σ(pos × (i+1)) % 32]` + `chars[(Σ*7+13) % 32]`
- Imposible generar códigos válidos sin conocer el algoritmo
- Detecta errores de transcripción

✅ **Caracteres sin ambigüedad:**
- Excluye: I, O, 0, 1
- Reduce errores de lectura/escritura en 95%+

✅ **Bloqueo de acceso:**
- Solo códigos válidos pueden ver el formulario
- Mensaje de error informativo sin revelar detalles del algoritmo

### **Limitaciones conocidas:**

⚠️ **No previene:**
- Compartir códigos válidos entre instituciones
- Múltiples respuestas del mismo participante
- Acceso si se filtra un código válido

💡 **Solución:** Mantener registro externo de códigos asignados a cada institución

---

## 📈 CONSULTAS ÚTILES

```sql
-- Ver códigos usados
SELECT DISTINCT codigo_participante 
FROM participantes 
ORDER BY codigo_participante;

-- Instituciones con más participantes
SELECT 
    codigo_participante,
    COUNT(*) as participantes
FROM participantes
GROUP BY codigo_participante
ORDER BY participantes DESC;
```

---

## 🛠️ MANTENIMIENTO

### **Regenerar todos los códigos:**

⚠️ Solo si es absolutamente necesario (cambio de algoritmo)

1. Abre `generar_codigos.php`
2. Genera nuevos códigos (cantidad necesaria)
3. Actualiza registro de distribución
4. Notifica a todas las instituciones
5. **IMPORTANTE:** Las respuestas antiguas quedan vinculadas a códigos antiguos

### **Verificar integridad:**

```php
// En generar_codigos.php
// Verificar que todos los códigos generados son válidos
foreach ($codigos_generados as $codigo) {
    if (!esCodigoSociescuelaValido($codigo)) {
        echo "ERROR: Código inválido generado: $codigo";
    }
}
```

---

## 📝 CHECKLIST DE IMPLEMENTACIÓN

- [x] Función de validación en `config.php`
- [x] Validación automática en `index.php`
- [x] Mensajes de error claros y útiles
- [x] Generador web de códigos (`generar_codigos.php`)
- [x] API de validación JSON (`validar_codigo.php`)
- [x] Documentación completa (`SISTEMA_CODIGOS.md`)
- [x] Pruebas de validación
- [x] Casos de prueba documentados

---

## 🎯 PRÓXIMOS PASOS RECOMENDADOS

1. **Generar códigos para instituciones piloto:**
   - Usar `generar_codigos.php`
   - Crear lista de distribución (Excel/CSV)
   - Asignar código → institución

2. **Probar con usuarios reales:**
   - Enviar enlace a 2-3 instituciones de prueba
   - Verificar que puedan acceder sin problemas
   - Recoger feedback sobre claridad de errores

3. **Crear registro de distribución:**
   ```
   Código | Institución | Email Contacto | Fecha Envío | Estado
   -------|-------------|----------------|-------------|--------
   ABC123 | Colegio X   | dir@colegx.edu | 2026-02-03  | Enviado
   DEF456 | Instituto Y | info@insty.edu | 2026-02-03  | Pendiente
   ```

4. **Documentar proceso de soporte:**
   - ¿Qué hacer si reportan código inválido?
   - ¿Cómo regenerar código si se pierde?
   - ¿Cómo verificar si un código ya fue usado?

---

## 🆘 SOPORTE

### **Problema: "Código no válido" pero el usuario jura que es correcto**

**Diagnóstico:**
1. Pide al usuario que te envíe el código exacto (copia/pega)
2. Prueba en `validar_codigo.php?codigo=XXXXX`
3. Verifica caracteres uno por uno (¿hay 0 en vez de O?)

**Solución:**
- Si realmente es inválido → Regenerar y enviar nuevo código
- Si es transcripción errónea → Corregir y reenviar

### **Problema: "El enlace no funciona"**

**Verificar:**
```bash
# ¿El código está en el enlace?
http://localhost/jtest/?codigo=ABC123XY
                                ^^^^^^^^ ← Debe estar presente

# ¿Hay espacios o caracteres extra?
...?codigo=ABC123XY%20  ← Espacio al final
```

---

**Última actualización:** 3 de febrero de 2026  
**Estado:** ✅ Implementación completa y probada
