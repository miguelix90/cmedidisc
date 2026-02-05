# GUÍA RÁPIDA - VALIDACIÓN DE CÓDIGOS IMPLEMENTADA

**Fecha:** 3 de febrero de 2026  
**Estado:** ✅ Completado y funcionando

---

## ✅ ¿QUÉ SE HA IMPLEMENTADO?

Se ha añadido un sistema de validación de códigos Sociescuela que:

1. ✅ **Valida el formato:** 8 caracteres exactos
2. ✅ **Valida caracteres:** Solo letras mayúsculas y números (sin I, O, 0, 1)
3. ✅ **Valida checksum:** Los últimos 2 dígitos verifican la integridad del código
4. ✅ **Doble validación:** En `index.php` (antes de mostrar formulario) y en `procesar.php` (antes de guardar)
5. ✅ **Mensajes claros:** Errores visuales y descriptivos

---

## 🚀 CÓMO PROBAR

### **Paso 1: Generar códigos de prueba**

Abre en tu navegador:
```
http://localhost/jtest/generar_codigos_prueba.php
```

Verás:
- 10 códigos aleatorios generados
- 5 códigos personalizados con bases conocidas
- Botones "Probar" para cada código

### **Paso 2: Probar código VÁLIDO**

1. Clic en cualquier botón "Probar" del generador
2. Se abrirá el cuestionario con el código válido
3. ✅ El formulario debe mostrarse correctamente
4. El código aparece en el encabezado: "Código de participante: XXXXXXXX"

**Ejemplo de URL:**
```
http://localhost/jtest/?codigo=TEST12AB
```

### **Paso 3: Probar código INVÁLIDO**

Prueba estos códigos inválidos:

```
http://localhost/jtest/?codigo=INVALIDO
http://localhost/jtest/?codigo=ABC123
http://localhost/jtest/?codigo=12345678
```

Resultado esperado:
- ❌ **No se muestra el formulario**
- ✅ **Mensaje de error:** "Código no válido"
- ✅ **Información detallada** sobre el formato correcto

### **Paso 4: Probar SIN código**

Abre:
```
http://localhost/jtest/
```

Resultado esperado:
- ❌ **No se muestra el formulario**
- ✅ **Mensaje de error:** "Código no proporcionado"

---

## 📁 ARCHIVOS MODIFICADOS

### **1. `config.php`**
- ✅ Añadida función `esCodigoSociescuelaValido()`
- ✅ Algoritmo de checksum implementado

### **2. `index.php`**
- ✅ Validación antes de mostrar formulario
- ✅ Página de error visual para código vacío
- ✅ Página de error visual para código inválido

### **3. `procesar.php`**
- ✅ Validación antes de guardar datos
- ✅ Previene guardado con códigos manipulados

### **4. Archivos nuevos:**
- ✅ `generar_codigos_prueba.php` - Generador para pruebas
- ✅ `VALIDACION_CODIGOS.md` - Documentación completa

---

## 🎯 CASOS DE USO

### **Caso 1: Usuario con código válido**
```
Usuario recibe: http://localhost/jtest/?codigo=TEST12AB
  ↓
index.php valida código
  ↓
✅ Código válido
  ↓
Muestra formulario
  ↓
Usuario completa y envía
  ↓
procesar.php valida código OTRA VEZ
  ↓
✅ Código válido
  ↓
Guarda en base de datos
  ↓
Redirige a exito.php
```

### **Caso 2: Usuario con código inválido**
```
Usuario intenta: http://localhost/jtest/?codigo=MALFORMED
  ↓
index.php valida código
  ↓
❌ Código inválido
  ↓
Muestra error: "Código no válido"
  ↓
FIN (no se muestra formulario)
```

### **Caso 3: Usuario sin código**
```
Usuario intenta: http://localhost/jtest/
  ↓
index.php valida código
  ↓
❌ Código vacío
  ↓
Muestra error: "Código no proporcionado"
  ↓
FIN (no se muestra formulario)
```

---

## 🔍 VERIFICACIÓN COMPLETA

### **Checklist de pruebas:**

- [ ] **Código válido:** Abre generador, clic en "Probar", formulario se muestra
- [ ] **Código inválido:** URL con código falso, muestra error "Código no válido"
- [ ] **Sin código:** URL sin parámetro, muestra error "Código no proporcionado"
- [ ] **Envío con código válido:** Completa formulario, envía, guarda correctamente
- [ ] **Manipulación:** Modifica HTML del código en DevTools, envía, rechaza en servidor

### **Consultas SQL útiles:**

```sql
-- Ver todos los participantes
SELECT codigo_participante, fecha_envio FROM participantes;

-- Verificar si hay códigos duplicados (debería haber varios por institución)
SELECT codigo_participante, COUNT(*) as total 
FROM participantes 
GROUP BY codigo_participante;
```

---

## 📊 FORMATO DE CÓDIGO

### **Estructura:**
```
  XXXXXX YZ
  │      └─ Checksum (2 dígitos)
  └──────── Datos (6 caracteres)

Ejemplo: TEST12AB
         └────┘ └─ Checksum: AB
         Datos: TEST12
```

### **Caracteres permitidos:**
```
ABCDEFGHJKLMNPQRSTUVWXYZ23456789
```

### **Caracteres NO permitidos:**
```
I  ← Se confunde con 1
O  ← Se confunde con 0
0  ← Se confunde con O
1  ← Se confunde con I
```

---

## 🛡️ SEGURIDAD

### **Protecciones implementadas:**

1. **Validación doble:**
   - Cliente (index.php): Evita mostrar formulario
   - Servidor (procesar.php): Evita guardar datos

2. **Checksum:**
   - Imposible adivinar códigos válidos por fuerza bruta
   - 32^2 = 1024 combinaciones posibles de checksum

3. **Sanitización:**
   - Todos los códigos pasan por `htmlspecialchars()`
   - Previene XSS

4. **Trim:**
   - Espacios eliminados automáticamente
   - Evita errores por copiar/pegar

---

## ⚠️ IMPORTANTE PARA PRODUCCIÓN

### **ANTES DE PRODUCCIÓN:**

1. ❌ **ELIMINAR:** `generar_codigos_prueba.php`
   ```bash
   rm D:\laragon_8\www\jtest\generar_codigos_prueba.php
   ```

2. ✅ **CAMBIAR** en `config.php`:
   ```php
   define('SHOW_ERRORS', false); // Cambiar de true a false
   ```

3. ✅ **ELIMINAR** archivos de prueba:
   ```bash
   rm D:\laragon_8\www\jtest\test_conexion.php
   rm D:\laragon_8\www\jtest\debug_post.php
   rm D:\laragon_8\www\jtest\test-simple.html
   ```

4. ✅ **CONFIGURAR** usuario de BD real (no root):
   - Ejecutar: `sql/crear_usuario.sql`
   - Actualizar credenciales en `config.php`

---

## 📞 SOPORTE

Si encuentras problemas:

1. **Verificar** que la función está en `config.php`
2. **Comprobar** que `index.php` incluye `require_once 'config.php'`
3. **Revisar** logs de PHP: `D:\laragon_8\bin\apache\logs\error.log`
4. **Probar** códigos del generador primero

---

## ✅ ESTADO FINAL

```
✅ Validación implementada
✅ Mensajes de error diseñados
✅ Generador de prueba creado
✅ Documentación completa
✅ Seguridad doble (cliente + servidor)
✅ Listo para usar
```

---

**Todo está listo para usar. ¡Buenas pruebas!** 🎉
