<?php
/**
 * GENERADOR DE CÓDIGOS SOCIESCUELA - SOLO PARA PRUEBAS
 * 
 * Este script genera códigos válidos para pruebas del sistema.
 * NO USAR EN PRODUCCIÓN - Solo para desarrollo y pruebas.
 */

require_once 'config.php';

/**
 * Generar código Sociescuela válido
 * 
 * @param string $base Base de 6 caracteres (se completará aleatoriamente si es menor)
 * @return string Código de 8 caracteres con checksum válido
 */
function generarCodigoSociescuela($base = '') {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    
    // Convertir a mayúsculas y tomar máximo 6 caracteres
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

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Códigos de Prueba - Sociescuela</title>
    <link rel="stylesheet" href="css/tailwind-local.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Advertencia -->
        <div class="bg-red-100 border-2 border-red-500 rounded-lg p-6 mb-6">
            <div class="flex items-start gap-4">
                <svg class="w-8 h-8 text-red-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h2 class="text-xl font-bold text-red-900 mb-2">⚠️ ADVERTENCIA - SOLO PARA PRUEBAS</h2>
                    <p class="text-red-800 mb-2">Este script es SOLO para desarrollo y pruebas.</p>
                    <p class="text-red-800 font-semibold">❌ NO USAR EN PRODUCCIÓN</p>
                    <p class="text-sm text-red-700 mt-2">Los códigos reales deben ser generados por el sistema Sociescuela oficial.</p>
                </div>
            </div>
        </div>

        <!-- Título -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Generador de Códigos de Prueba</h1>
            <p class="text-gray-600">Genera códigos válidos para probar el sistema de validación del cuestionario.</p>
        </div>

        <!-- Códigos generados -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Códigos Generados Aleatoriamente</h2>
            
            <?php
            $codigos_aleatorios = [];
            for ($i = 0; $i < 10; $i++) {
                $codigos_aleatorios[] = generarCodigoSociescuela();
            }
            ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <?php foreach ($codigos_aleatorios as $index => $codigo): ?>
                    <div class="bg-gray-50 border-2 border-gray-300 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-600">Código <?php echo $index + 1; ?>:</span>
                            <span class="text-xs text-gray-500">
                                <?php echo esCodigoSociescuelaValido($codigo) ? '✅ Válido' : '❌ Inválido'; ?>
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <code class="text-2xl font-mono font-bold text-blue-600 flex-1"><?php echo $codigo; ?></code>
                            <a href="index.php?codigo=<?php echo $codigo; ?>" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold"
                               target="_blank">
                                Probar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Códigos personalizados -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Códigos Personalizados (con base conocida)</h2>
            
            <?php
            $bases_personalizadas = ['TEST12', 'DEMO99', 'PRUEBA', 'INST23', 'COLE45'];
            ?>
            
            <div class="space-y-4">
                <?php foreach ($bases_personalizadas as $base): ?>
                    <?php $codigo = generarCodigoSociescuela($base); ?>
                    <div class="bg-green-50 border-2 border-green-300 rounded-lg p-4">
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <div class="flex-1">
                                <p class="text-sm text-gray-600 mb-1">Base: <code class="font-mono text-gray-800"><?php echo $base; ?></code></p>
                                <div class="flex items-center gap-2">
                                    <code class="text-2xl font-mono font-bold text-green-700"><?php echo $codigo; ?></code>
                                    <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded">
                                        <?php echo esCodigoSociescuelaValido($codigo) ? '✅ Válido' : '❌ Inválido'; ?>
                                    </span>
                                </div>
                            </div>
                            <a href="index.php?codigo=<?php echo $codigo; ?>" 
                               class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded font-semibold text-center"
                               target="_blank">
                                Probar →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Información del algoritmo -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">ℹ️ Información del Algoritmo</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Formato del código:</h3>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <code class="text-xl font-mono">
                            <span class="text-blue-600">XXXXXX</span><span class="text-red-600">YZ</span>
                        </code>
                        <div class="mt-2 text-sm text-gray-600">
                            <p>• <span class="text-blue-600 font-mono">XXXXXX</span> = 6 caracteres de datos</p>
                            <p>• <span class="text-red-600 font-mono">YZ</span> = 2 dígitos de checksum</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Caracteres válidos:</h3>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <code class="text-lg font-mono text-gray-700">ABCDEFGHJKLMNPQRSTUVWXYZ23456789</code>
                        <p class="text-sm text-gray-600 mt-2">
                            ❌ Excluidos: <code class="font-mono">I O 0 1</code> (para evitar confusiones)
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Validaciones aplicadas:</h3>
                    <ul class="list-disc ml-6 text-gray-700 space-y-1">
                        <li>Longitud exacta: 8 caracteres</li>
                        <li>Solo caracteres permitidos (sin I, O, 0, 1)</li>
                        <li>Checksum válido (últimos 2 dígitos)</li>
                        <li>Automáticamente convertido a mayúsculas</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-500 text-sm mt-6">
            <p>⚠️ Recuerda: Este generador es SOLO para pruebas de desarrollo</p>
            <p>En producción, los códigos deben ser generados por el sistema Sociescuela oficial</p>
        </div>
    </div>
</body>
</html>
