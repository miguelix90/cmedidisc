<?php
/**
 * DEBUG - VER DATOS ENVIADOS
 * Este archivo muestra todos los datos que se envían desde el formulario
 * ELIMINAR EN PRODUCCIÓN
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Este archivo solo funciona con método POST');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Datos del Formulario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                🔍 Debug - Datos Recibidos del Formulario
            </h1>
            
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-yellow-800 font-semibold">⚠️ ADVERTENCIA</p>
                <p class="text-yellow-700">Este archivo es solo para debug. ELIMINAR en producción.</p>
            </div>
            
            <!-- Resumen -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h2 class="text-xl font-bold text-blue-900 mb-2">Resumen</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="font-semibold">Total de campos:</span> 
                        <?php echo count($_POST); ?>
                    </div>
                    <div>
                        <span class="font-semibold">Código:</span> 
                        <?php echo htmlspecialchars($_POST['codigo_participante'] ?? 'NO ENVIADO'); ?>
                    </div>
                </div>
            </div>
            
            <!-- SECCIÓN 1: SOCIESCUELA -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-blue-600 mb-4">SECCIÓN 1: SOCIESCUELA</h2>
                
                <table class="w-full border-collapse border border-gray-300 mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Campo</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $campos_soci = ['soci_1', 'soci_2_1', 'soci_2_2', 'soci_2_3', 'soci_2_4', 
                                       'soci_2_5', 'soci_2_6', 'soci_2_7', 'soci_2_8', 'soci_2_8_espec',
                                       'soci_3', 'soci_3_resultado', 
                                       'soci_4_1', 'soci_4_2', 'soci_4_3', 'soci_4_4',
                                       'soci_5', 'soci_6'];
                        
                        foreach ($campos_soci as $campo) {
                            $valor = isset($_POST[$campo]) ? $_POST[$campo] : '<span class="text-red-600">NO ENVIADO</span>';
                            if ($valor === 'true') $valor = '✓ Marcado';
                            if ($valor === '') $valor = '<span class="text-gray-400">(vacío)</span>';
                            
                            echo '<tr>';
                            echo '<td class="border border-gray-300 px-4 py-2 font-mono text-sm">' . $campo . '</td>';
                            echo '<td class="border border-gray-300 px-4 py-2">' . $valor . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- SECCIÓN 2: DISCIPLINARIAS -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-green-600 mb-4">SECCIÓN 2: DISCIPLINARIAS</h2>
                
                <!-- PREGUNTA 1: Tabla de medidas -->
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pregunta 1: Medidas Disciplinarias</h3>
                <table class="w-full border-collapse border border-gray-300 mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Medida</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Valor (1-5)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $medidas = [
                            'amonestaciones_escritas' => 'Amonestaciones escritas',
                            'envio_jefatura' => 'Envío a jefatura',
                            'apertura_expediente' => 'Apertura de expediente',
                            'expulsion_temporal_aula' => 'Expulsión temporal del aula',
                            'expulsion_centro' => 'Expulsión del centro',
                            'partes_incidencia' => 'Partes de incidencia',
                            'suspension_extraescolares' => 'Suspensión extraescolares',
                            'aviso_familia' => 'Aviso a la familia',
                            'retirada_movil' => 'Retirada de móvil',
                            'castigos' => 'Castigos',
                            'mediacion_iguales' => 'Mediación entre iguales',
                            'circulos_dialogo' => 'Círculos de diálogo',
                            'trabajo_equipo' => 'Trabajo en equipo',
                            'asambleas' => 'Asambleas',
                            'autorregulacion' => 'Autorregulación',
                            'contratos_conducta' => 'Contratos de conducta',
                            'planes_personalizados' => 'Planes personalizados',
                            'grupos_convivencia' => 'Grupos de convivencia',
                            'formacion_habilidades' => 'Formación en habilidades',
                            'refuerzo_positivo' => 'Refuerzo positivo',
                            'organizacion_aula' => 'Organización del aula',
                            'normas_visuales' => 'Normas visuales',
                            'tutoria_valores' => 'Tutoría sobre valores',
                            'timeout_educativo' => 'Timeout educativo',
                            'servicio_comunidad' => 'Servicio a la comunidad',
                            'aprendizaje_servicio' => 'Aprendizaje-servicio',
                            'participacion_familias' => 'Participación de familias',
                            'consejos_estudiantes' => 'Consejos de estudiantes'
                        ];
                        
                        foreach ($medidas as $key => $nombre) {
                            $campo = 'disci_1_' . $key;
                            $valor = isset($_POST[$campo]) ? $_POST[$campo] : '<span class="text-red-600">NO ENVIADO</span>';
                            
                            echo '<tr>';
                            echo '<td class="border border-gray-300 px-4 py-2">' . $nombre . '</td>';
                            echo '<td class="border border-gray-300 px-4 py-2 text-center font-bold">' . $valor . '</td>';
                            echo '</tr>';
                        }
                        
                        // Otro
                        $otro_frec = isset($_POST['disci_1_otro_frecuencia']) ? $_POST['disci_1_otro_frecuencia'] : '<span class="text-gray-400">N/A</span>';
                        $otro_espec = isset($_POST['disci_1_otro_especificar']) ? htmlspecialchars($_POST['disci_1_otro_especificar']) : '<span class="text-gray-400">N/A</span>';
                        
                        echo '<tr class="bg-yellow-50">';
                        echo '<td class="border border-gray-300 px-4 py-2">Otro: ' . $otro_espec . '</td>';
                        echo '<td class="border border-gray-300 px-4 py-2 text-center font-bold">' . $otro_frec . '</td>';
                        echo '</tr>';
                        ?>
                    </tbody>
                </table>
                
                <!-- Preguntas 2-5 -->
                <h3 class="text-xl font-bold text-gray-800 mb-2">Preguntas 2-5</h3>
                <table class="w-full border-collapse border border-gray-300 mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Campo</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $preguntas_texto = [
                            'disci_2' => 'Pregunta 2: Medidas adicionales',
                            'disci_3' => 'Pregunta 3: Efectividad',
                            'disci_3_aclaracion' => 'Pregunta 3: Aclaración',
                            'disci_4' => 'Pregunta 4: Medidas efectivas',
                            'disci_5' => 'Pregunta 5: Desafíos'
                        ];
                        
                        foreach ($preguntas_texto as $campo => $label) {
                            $valor = isset($_POST[$campo]) ? htmlspecialchars($_POST[$campo]) : '<span class="text-red-600">NO ENVIADO</span>';
                            if ($valor === '') $valor = '<span class="text-gray-400">(vacío)</span>';
                            
                            echo '<tr>';
                            echo '<td class="border border-gray-300 px-4 py-2 font-semibold">' . $label . '</td>';
                            echo '<td class="border border-gray-300 px-4 py-2">' . $valor . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                
                <!-- Pregunta 6: Metodologías -->
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pregunta 6: Metodologías Activas</h3>
                <table class="w-full border-collapse border border-gray-300 mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Metodología</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Valor (1-4)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $metodologias = [
                            'cooperativo' => 'Aprendizaje cooperativo',
                            'problemas' => 'Basado en problemas',
                            'proyectos' => 'Basado en proyectos',
                            'gamificacion' => 'Gamificación',
                            'flipped' => 'Clase invertida',
                            'servicio' => 'Aprendizaje-servicio',
                            'personalizacion' => 'Personalización',
                            'otro' => 'Otro'
                        ];
                        
                        foreach ($metodologias as $key => $nombre) {
                            $campo = 'disci_6_' . $key;
                            $valor = isset($_POST[$campo]) ? $_POST[$campo] : '<span class="text-gray-400">N/A</span>';
                            
                            echo '<tr>';
                            echo '<td class="border border-gray-300 px-4 py-2">' . $nombre . '</td>';
                            echo '<td class="border border-gray-300 px-4 py-2 text-center font-bold">' . $valor . '</td>';
                            echo '</tr>';
                        }
                        
                        $otro_metod = isset($_POST['disci_6_otro_especificar']) ? htmlspecialchars($_POST['disci_6_otro_especificar']) : '<span class="text-gray-400">N/A</span>';
                        echo '<tr class="bg-yellow-50">';
                        echo '<td colspan="2" class="border border-gray-300 px-4 py-2"><strong>Especificar otro:</strong> ' . $otro_metod . '</td>';
                        echo '</tr>';
                        ?>
                    </tbody>
                </table>
                
                <!-- Preguntas 7-11 -->
                <h3 class="text-xl font-bold text-gray-800 mb-2">Preguntas 7-11</h3>
                <table class="w-full border-collapse border border-gray-300 mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Campo</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $preguntas_finales = [
                            'disci_7' => 'Pregunta 7: Información adicional',
                            'disci_8' => 'Pregunta 8: Efectividad en aprendizaje',
                            'disci_9' => 'Pregunta 9: Efectividad en convivencia',
                            'disci_10' => 'Pregunta 10: Explicación',
                            'disci_11' => 'Pregunta 11: Desafíos metodologías'
                        ];
                        
                        foreach ($preguntas_finales as $campo => $label) {
                            $valor = isset($_POST[$campo]) ? htmlspecialchars($_POST[$campo]) : '<span class="text-red-600">NO ENVIADO</span>';
                            if ($valor === '') $valor = '<span class="text-gray-400">(vacío/opcional)</span>';
                            
                            echo '<tr>';
                            echo '<td class="border border-gray-300 px-4 py-2 font-semibold">' . $label . '</td>';
                            echo '<td class="border border-gray-300 px-4 py-2">' . $valor . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- TODOS LOS DATOS RAW -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-purple-600 mb-4">Todos los Datos (RAW)</h2>
                <div class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-auto max-h-96 font-mono text-sm">
                    <pre><?php print_r($_POST); ?></pre>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex gap-4 justify-center">
                <a href="index.php?codigo=TEST001" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                    Volver al formulario
                </a>
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg">
                    Imprimir esta página
                </button>
            </div>
        </div>
    </div>
</body>
</html>
