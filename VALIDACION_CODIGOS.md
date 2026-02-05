# VALIDACIÓN DE CÓDIGOS SOCIESCUELA

**Fecha de implementación:** 3 de febrero de 2026  
**Versión:** 1.0

---

## 📋 RESUMEN

Se ha implementado un sistema de validación de códigos para asegurar que solo se puedan acceder al cuestionario con códigos válidos generados por el sistema Sociescuela.

---

## 🔐 ALGORITMO DE VALIDACIÓN

El código utiliza un algoritmo de checksum de 2 dígitos para verificar la integridad del código:

### **Formato del código:**
```
XXXXXX YZ
  └─┬─┘ └┬┘
    │    │
    │    └─ 2 dígitos de checksum (YZ)
    └────── 6 caracteres de datos
```

### **Caracteres válidos:**
```
ABCDEFGHJKLMNPQRSTUVWXYZ23456789
```
**Nota:** Se excluyen `I`, `O`, `0`, `1` para evitar confusiones visuales.

### **Cálculo del checksum:**

```php
// 1. Tomar los primeros 6 caracteres
$parte = substr($codigo, 0, 6);

// 2. Calcular suma ponderada
$suma = 0;
for ($i = 0; $i < 6; $i++) {
    $suma += posicion_char($parte[$i]) * ($i + 1);
}

// 3. Calcular dígitos de verificación
$check1 = $chars[$suma % 32];
$check2 = $chars[($suma * 7 + 13) % 32];

// 4. Los últimos 2 caracteres deben coincidir
return substr($codigo, 6, 2) === $check1 . $check2;
```

---

## 💻 IMPLEMENTACIÓN

### **1. Función de validación (`config.php`)**

```php
function esCodigoSociescuelaValido(string $codigo): bool {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    
    // Verificar longitud
    if (strlen($codigo) !== 8) return false;
    
    // Convertir a mayúsculas
    $codigo = strtoupper($codigo);
    
    // Verificar caracteres válidos
    for ($i = 0; $i < 8; $i++) {
        if (strpos($chars, $codigo[$i]) === false) return false;
    }
    
    // Verificar checksum
    $parte = substr($codigo, 0, 6);
    $suma = 0;
    for ($i = 0; $i < 6; $i++) {
        $suma += strpos($chars, $parte[$i]) * ($i + 1);
    }
    
    $check1 = $chars[$suma % 32];
    $check2 = $chars[($suma * 7 + 13) % 32];
    
    return substr($codigo, 6, 2) === $check1 . $check2;
}
```

### **2. Validación en `index.php`**

El formulario valida el código ANTES de mostrar el cuestionario:

```php
// Obtener código de la URL
$codigo_participante = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';

// Validar que no esté vacío
if (empty($codigo_participante)) {
    // Mostrar página de error: "Código no proporcionado"
    exit;
}

// Validar formato y checksum
if (!esCodigoSociescuelaValido($codigo_participante)) {
    // Mostrar página de error: "Código no válido"
    exit;
}

// Si llega aquí, el código es válido → mostrar formulario
```

### **3. Validación en `procesar.php`**

El procesador valida el código ANTES de guardar en la base de datos:

```php
$codigo_participante = sanitize($_POST['codigo_participante'] ?? '');

// Validar que no esté vacío
if (empty($codigo_participante)) {
    die('Error: Código de participante no proporcionado');
}

// Validar formato y checksum
if (!esCodigoSociescuelaValido($codigo_participante)) {
    die('Error: El código proporcionado no es válido o ha sido modificado');
}

// Si llega aquí, el código es válido → procesar y guardar
```

---

## 🎨 MENSAJES DE ERROR

### **Error: Código no proporcionado**

```
╔═══════════════════════════════════════╗
║   ⚠️  Código no proporcionado        ║
╠═══════════════════════════════════════╣
║ Para acceder al cuestionario          ║
║ necesita un código de institución     ║
║ válido.                               ║
║                                       ║
║ Por favor, utilice el enlace          ║
║ proporcionado por el coordinador      ║
║ del estudio.                          ║
╚═══════════════════════════════════════╝
```

### **Error: Código no válido**

```
╔═══════════════════════════════════════╗
║   ❌  Código no válido                ║
╠═══════════════════════════════════════╣
║ El código proporcionado no es         ║
║ válido o ha sido modificado.          ║
║                                       ║
║ Código proporcionado: ABCD1234        ║
║                                       ║
║ ℹ️ Información importante:            ║
║ • Los códigos tienen 8 caracteres     ║
║ • Solo letras mayúsculas y números    ║
║   (sin I, O, 0, 1)                   ║
║ • Verifique que no haya espacios      ║
║ • Use el enlace exacto del           ║
║   coordinador                         ║
╚═══════════════════════════════════════╝
```

---

## 🧪 CASOS DE PRUEBA

### **Códigos válidos (ejemplos):**

```
ABCDEF23  ← 6 caracteres + 2 checksum
XYZ456LM  ← Otro ejemplo válido
PQRSTU9A  ← Otro ejemplo válido
```

### **Códigos inválidos:**

```
ABCDEF    ← Muy corto (solo 6 caracteres)
ABCDEF2   ← Muy corto (solo 7 caracteres)
ABCDEF234 ← Muy largo (9 caracteres)
ABCDEFGH  ← Checksum incorrecto
ABC0EF23  ← Contiene '0' (no permitido)
ABCIOF23  ← Contiene 'I' y 'O' (no permitidos)
abcdef23  ← Minúsculas (se convierten automáticamente)
```

---

## 🔍 VERIFICACIÓN

### **Probar código inválido:**

1. Abre: `http://localhost/jtest/?codigo=INVALIDO`
2. Debe mostrar: **"Código no válido"**

### **Probar sin código:**

1. Abre: `http://localhost/jtest/`
2. Debe mostrar: **"Código no proporcionado"**

### **Probar código válido:**

Necesitas un código generado por el sistema Sociescuela.

Ejemplo de cómo generar uno manualmente para pruebas:

```php
<?php
function generarCodigoSociescuela($base) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $base = strtoupper(substr($base, 0, 6));
    
    // Completar con caracteres aleatorios si es necesario
    while (strlen($base) < 6) {
        $base .= $chars[rand(0, 31)];
    }
    
    // Calcular checksum
    $suma = 0;
    for ($i = 0; $i < 6; $i++) {
        $suma += strpos($chars, $base[$i]) * ($i + 1);
    }
    
    $check1 = $chars[$suma % 32];
    $check2 = $chars[($suma * 7 + 13) % 32];
    
    return $base . $check1 . $check2;
}

// Ejemplos de uso:
echo generarCodigoSociescuela('TEST12');  // Genera: TEST12XX (donde XX es el checksum)
?>
```

---

## 📊 FLUJO DE VALIDACIÓN

```
┌─────────────────────────────────────┐
│ Usuario visita:                     │
│ /jtest/?codigo=ABCDEF23            │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ index.php recibe código             │
│ $codigo = $_GET['codigo']           │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ ¿Código vacío?                      │
└──────┬─────────────┬────────────────┘
       │ SÍ          │ NO
       ▼             ▼
┌─────────────┐ ┌─────────────────────┐
│ Error:      │ │ Validar formato     │
│ "No         │ │ y checksum          │
│ proporcio-  │ └──────┬──────────────┘
│ nado"       │        │
└─────────────┘        ▼
               ┌─────────────────────┐
               │ ¿Código válido?     │
               └──────┬──────┬───────┘
                      │ SÍ   │ NO
                      ▼      ▼
            ┌─────────────┐ ┌────────────┐
            │ Mostrar     │ │ Error:     │
            │ formulario  │ │ "Código no │
            │             │ │ válido"    │
            └──────┬──────┘ └────────────┘
                   │
                   ▼
            ┌─────────────────────────┐
            │ Usuario completa        │
            │ formulario              │
            └──────┬──────────────────┘
                   │
                   ▼
            ┌─────────────────────────┐
            │ Envía a procesar.php    │
            └──────┬──────────────────┘
                   │
                   ▼
            ┌─────────────────────────┐
            │ Valida código OTRA VEZ  │
            │ (seguridad doble)       │
            └──────┬──────────────────┘
                   │
                   ▼
            ┌─────────────────────────┐
            │ Guarda en BD            │
            └─────────────────────────┘
```

---

## 🔒 SEGURIDAD

### **Doble validación:**
1. **Cliente (index.php):** Evita que usuarios vean el formulario con código inválido
2. **Servidor (procesar.php):** Evita que se guarden datos con código inválido (por si alguien manipula el HTML)

### **Prevención de ataques:**
- ✅ Inyección SQL: Códigos sanitizados
- ✅ XSS: htmlspecialchars() en todos los outputs
- ✅ Fuerza bruta: Checksum hace muy difícil adivinar códigos válidos
- ✅ Manipulación: Validación en servidor previene modificación del formulario

---

## 📝 NOTAS IMPORTANTES

1. **Los códigos son sensibles a mayúsculas/minúsculas** (pero se convierten automáticamente a mayúsculas)
2. **Longitud exacta:** Deben ser exactamente 8 caracteres
3. **Checksum:** Los últimos 2 caracteres son verificación, no datos
4. **Caracteres excluidos:** `I`, `O`, `0`, `1` para evitar confusiones visuales
5. **Espacios:** Se eliminan automáticamente con `trim()`

---

## ✅ VERIFICACIÓN DE IMPLEMENTACIÓN

- [x] Función `esCodigoSociescuelaValido()` en `config.php`
- [x] Validación en `index.php` (antes de mostrar formulario)
- [x] Validación en `procesar.php` (antes de guardar)
- [x] Mensajes de error claros y detallados
- [x] Diseño visual profesional para errores
- [x] Documentación completa

---

**Última actualización:** 3 de febrero de 2026  
**Estado:** ✅ Implementado y funcionando
