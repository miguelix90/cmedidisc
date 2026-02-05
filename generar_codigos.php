<?php
/**
 * GENERADOR DE CÓDIGOS SOCIESCUELA
 * 
 * Herramienta para generar códigos válidos de institución
 * para pruebas y asignación a centros educativos
 * 
 * USO: http://localhost/jtest/generar_codigos.php?cantidad=10
 */

require_once 'config.php';

/**
 * Generar código Sociescuela válido
 * 
 * @param string $prefijo Prefijo de 6 caracteres (opcional, si no se proporciona se genera aleatorio)
 * @return string Código de 8 caracteres con checksum
 */
function generarCodigoSociescuela(string $prefijo = ''): string {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    
    // Si no hay prefijo, generar uno aleatorio de 6 caracteres
    if (empty($prefijo)) {
        $prefijo = '';
        for ($i = 0; $i < 6; $i++) {
            $prefijo .= $chars[random_int(0, strlen($chars) - 1)];
        }
    } else {
        // Validar prefijo
        $prefijo = strtoupper(substr($prefijo, 0, 6));
        $prefijo = str_pad($prefijo, 6, 'A', STR_PAD_RIGHT);
    }
    
    // Calcular checksum
    $suma = 0;
    for ($i = 0; $i < 6; $i++) {
        $suma += strpos($chars, $prefijo[$i]) * ($i + 1);
    }
    
    $check1 = $chars[$suma % 32];
    $check2 = $chars[($suma * 7 + 13) % 32];
    
    return $prefijo . $check1 . $check2;
}

// ============================================================================
// INTERFAZ WEB
// ============================================================================

$cantidad = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 0;
$prefijo = isset($_GET['prefijo']) ? $_GET['prefijo'] : '';
$codigos_generados = [];

if ($cantidad > 0 && $cantidad <= 100) {
    for ($i = 0; $i < $cantidad; $i++) {
        $codigo = generarCodigoSociescuela($prefijo);
        $codigos_generados[] = $codigo;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Códigos Sociescuela</title>
    <link rel="stylesheet" href="css/tailwind-local.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        
        <!-- Encabezado -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🔑 Generador de Códigos Sociescuela</h1>
            <p class="text-gray-600">Herramienta para generar códigos válidos de institución para el cuestionario</p>
        </div>

        <!-- Formulario de generación -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Generar Códigos</h2>
            
            <form method="GET" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Cantidad de códigos a generar (1-100)
                    </label>
                    <input 
                        type="number" 
                        name="cantidad" 
                        min="1" 
                        max="100" 
                        value="10"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Prefijo personalizado (opcional, máx 6 caracteres)
                    </label>
                    <input 
                        type="text" 
                        name="prefijo" 
                        maxlength="6"
                        placeholder="Ej: CENTRO"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <p class="text-xs text-gray-500 mt-1">
                        Si no se especifica, se generará aleatoriamente. Solo letras y números (sin I, O, 0, 1)
                    </p>
                </div>
                
                <button 
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                >
                    Generar Códigos
                </button>
            </form>
        </div>

        <?php if (!empty($codigos_generados)): ?>
        <!-- Códigos generados -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">
                    ✅ Códigos Generados (<?php echo count($codigos_generados); ?>)
                </h2>
                <button 
                    onclick="copiarTodos()"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition duration-200"
                >
                    📋 Copiar Todos
                </button>
            </div>
            
            <!-- Lista de códigos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-4">
                <?php foreach ($codigos_generados as $index => $codigo): ?>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <span class="font-mono font-bold text-lg text-gray-900"><?php echo $codigo; ?></span>
                        <button 
                            onclick="copiarCodigo('<?php echo $codigo; ?>')"
                            class="text-blue-600 hover:text-blue-700 text-sm"
                            title="Copiar código"
                        >
                            📋
                        </button>
                    </div>
                    <a 
                        href="?codigo=<?php echo $codigo; ?>" 
                        target="_blank"
                        class="text-xs text-blue-600 hover:text-blue-700 block mt-1"
                    >
                        Probar enlace →
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Área de texto con todos los códigos -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Todos los códigos (para copiar)
                </label>
                <textarea 
                    id="todosCodigos"
                    readonly
                    rows="6"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                ><?php echo implode("\n", $codigos_generados); ?></textarea>
            </div>
        </div>

        <!-- Enlaces generados -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">🔗 Enlaces al Cuestionario</h2>
            <p class="text-gray-600 mb-3">
                Estos son los enlaces directos que debes proporcionar a cada institución:
            </p>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                <?php foreach ($codigos_generados as $codigo): 
                    $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?codigo=" . $codigo;
                ?>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-mono text-sm text-gray-700 break-all flex-1"><?php echo $url; ?></span>
                        <button 
                            onclick="copiarTexto('<?php echo addslashes($url); ?>')"
                            class="text-blue-600 hover:text-blue-700 text-sm whitespace-nowrap"
                        >
                            📋 Copiar
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Información -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
            <h3 class="text-lg font-bold text-blue-900 mb-2">ℹ️ Información sobre los códigos</h3>
            <ul class="text-sm text-blue-800 space-y-2 ml-4 list-disc">
                <li><strong>Formato:</strong> 8 caracteres (6 de datos + 2 de checksum)</li>
                <li><strong>Caracteres válidos:</strong> ABCDEFGHJKLMNPQRSTUVWXYZ23456789 (sin I, O, 0, 1 para evitar confusiones)</li>
                <li><strong>Validación:</strong> Los últimos 2 caracteres son un checksum calculado automáticamente</li>
                <li><strong>Único por institución:</strong> Cada código representa una institución educativa</li>
                <li><strong>Múltiples respuestas:</strong> Varios participantes de la misma institución pueden usar el mismo código</li>
            </ul>
        </div>

        <!-- Prueba de validación -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">🧪 Probar Validación de Código</h2>
            
            <form onsubmit="return probarCodigo(event)" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Introduce un código para validar
                    </label>
                    <input 
                        type="text" 
                        id="codigoProbar"
                        maxlength="8"
                        placeholder="Ej: ABC123XY"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>
                
                <button 
                    type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                >
                    Validar Código
                </button>
            </form>
            
            <div id="resultadoValidacion" class="mt-4"></div>
        </div>

    </div>

    <script>
    function copiarCodigo(codigo) {
        navigator.clipboard.writeText(codigo).then(() => {
            alert('Código copiado: ' + codigo);
        });
    }

    function copiarTodos() {
        const textarea = document.getElementById('todosCodigos');
        textarea.select();
        document.execCommand('copy');
        alert('Todos los códigos copiados al portapapeles');
    }

    function copiarTexto(texto) {
        navigator.clipboard.writeText(texto).then(() => {
            alert('Enlace copiado al portapapeles');
        });
    }

    function probarCodigo(event) {
        event.preventDefault();
        const codigo = document.getElementById('codigoProbar').value.trim();
        const resultado = document.getElementById('resultadoValidacion');
        
        if (codigo === '') {
            resultado.innerHTML = '<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4"><p class="text-yellow-800">Por favor, introduce un código.</p></div>';
            return false;
        }
        
        // Hacer petición AJAX para validar
        fetch('validar_codigo.php?codigo=' + encodeURIComponent(codigo))
            .then(response => response.json())
            .then(data => {
                if (data.valido) {
                    resultado.innerHTML = `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-green-800 font-bold mb-2">✅ Código VÁLIDO</p>
                            <p class="text-green-700 text-sm">El código <code class="font-mono font-bold">${codigo}</code> es correcto y puede usarse.</p>
                            <a href="index.php?codigo=${codigo}" target="_blank" class="inline-block mt-2 text-blue-600 hover:text-blue-700 text-sm">
                                Ir al cuestionario →
                            </a>
                        </div>
                    `;
                } else {
                    resultado.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-red-800 font-bold mb-2">❌ Código NO VÁLIDO</p>
                            <p class="text-red-700 text-sm">${data.mensaje}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                resultado.innerHTML = '<div class="bg-red-50 border border-red-200 rounded-lg p-4"><p class="text-red-800">Error al validar el código.</p></div>';
            });
        
        return false;
    }
    </script>
</body>
</html>
