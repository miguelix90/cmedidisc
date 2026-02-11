<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario sobre Medidas Disciplinarias y Metodologías Activas</title>
    <link rel="stylesheet" href="css/tailwind-local.css?v=1769000469">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-gray-50">
    <script>
    function toggleSociescuelaQuestions() {
        const soci1 = document.querySelector('input[name="soci_1"]:checked');
        if (soci1 && soci1.value === '1') {
            document.getElementById('soci_2_container').classList.remove('hidden');
            document.getElementById('soci_3_container').classList.remove('hidden');
            document.getElementById('soci_4_container').classList.remove('hidden');
            document.getElementById('soci_5_container').classList.remove('hidden');
            document.getElementById('soci_6_container').classList.remove('hidden');
            
        } else {
            document.getElementById('soci_2_container').classList.add('hidden');
            document.getElementById('soci_3_container').classList.add('hidden');
            document.getElementById('soci_4_container').classList.add('hidden');
            document.getElementById('soci_5_container').classList.add('hidden');
            document.getElementById('soci_6_container').classList.add('hidden');
            document.querySelectorAll('#soci_2_container input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.querySelectorAll('#soci_3_container input[type="radio"]').forEach(r => r.checked = false);
            document.querySelectorAll('#soci_4_container input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.querySelector('input[name="soci_5"]').value = '';            
            document.querySelector('textarea[name="soci_6"]').value = '';            
            document.querySelector('input[name="soci_2_8_espec"]').value = '';
            document.querySelector('textarea[name="soci_3_resultado"]').value = '';
            document.getElementById('soci_2_8_espec_container').classList.add('hidden');
            document.getElementById('soci_3_resultado_container').classList.add('hidden');
        }
    }
    function toggleOtraEspecificar() {
        const otraCheckbox = document.querySelector('input[name="soci_2_8"]');
        const especificarContainer = document.getElementById('soci_2_8_espec_container');
        const especificarInput = document.querySelector('input[name="soci_2_8_espec"]');
        if (otraCheckbox.checked) {
            especificarContainer.classList.remove('hidden');
            
        } else {
            especificarContainer.classList.add('hidden');            
            especificarInput.value = '';
        }
    }
    function toggleResultado() {
        const soci3 = document.querySelector('input[name="soci_3"]:checked');
        const resultadoContainer = document.getElementById('soci_3_resultado_container');
        const resultadoTextarea = document.querySelector('textarea[name="soci_3_resultado"]');
        if (soci3 && soci3.value === '1') {
            resultadoContainer.classList.remove('hidden');
            
        } else {
            resultadoContainer.classList.add('hidden');
            
            resultadoTextarea.value = '';
        }
    }
    // Función checkMetodologiasActivasVisibility eliminada - La pregunta 6 se muestra siempre
    </script>
    <?php
    // Incluir configuración para acceder a la función de validación
    require_once 'config.php';
    
    // Verificar que existe el código en la URL
    $codigo_participante = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';
    
    // Validar que el código no esté vacío
    if (empty($codigo_participante)) {
        ?>
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
                <svg class="mx-auto h-12 w-12 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Código no proporcionado</h2>
                <p class="text-gray-600 mb-4">Para acceder al cuestionario necesita un código de institución válido.</p>
                <p class="text-sm text-gray-500">Por favor, utilice el enlace proporcionado por el coordinador del estudio.</p>
            </div>
        </div>
        <?php
        exit;
    }
    
    // Validar formato y checksum del código
    if (!esCodigoSociescuelaValido($codigo_participante)) {
        ?>
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
                <svg class="mx-auto h-12 w-12 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Código no válido</h2>
                <p class="text-gray-600 mb-4">El código proporcionado no es válido o ha sido modificado.</p>
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-700 font-mono"><?php echo htmlspecialchars($codigo_participante); ?></p>
                </div>
                <div class="text-left bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-blue-900 mb-2">ℹ️ Información importante:</p>
                    <ul class="text-sm text-blue-800 space-y-1 ml-4 list-disc">
                        <li>Los códigos deben tener exactamente 8 caracteres</li>
                        <li>Solo letras mayúsculas y números (sin I, O, 0, 1)</li>
                        <li>Verifique que no haya espacios al inicio o final</li>
                        <li>Utilice el enlace exacto proporcionado por el coordinador</li>
                    </ul>
                </div>
                <p class="text-sm text-gray-500 mt-4">Si el problema persiste, contacte con el coordinador del estudio.</p>
            </div>
        </div>
        <?php
        exit;
    }
    ?>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Encabezado -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 text-center">
                Cuestionario sobre Medidas Disciplinarias y Metodologías Activas en los Colegios
            </h1>
            <p class="text-gray-600 text-center">
                Este cuestionario es anónimo. Sus respuestas ayudarán a mejorar la convivencia en los centros educativos.
            </p>
            <p class="text-sm text-gray-500 text-center mt-2">
                Código de participante: <span class="font-mono font-semibold"><?php echo htmlspecialchars($codigo_participante); ?></span>
            </p>
        </div>

        <!-- Formulario -->
        <form id="cuestionarioForm" method="POST" action="procesar.php" class="space-y-8">
            <input type="hidden" name="codigo_participante" value="<?php echo htmlspecialchars($codigo_participante); ?>">

            <!-- ============ SECCIÓN 1: SOCIESCUELA ============ -->
            
            <div class="bg-blue-600 text-white rounded-lg shadow-md p-4 mb-6">
                <h2 class="text-2xl font-bold text-center">SECCIÓN 1: SOCIESCUELA</h2>
            </div>
            
            <!-- PREGUNTA SOCI_1 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    1. ¿Ha utilizado la herramienta Sociescuela para realizar algún tipo de intervención de convivencia en el aula?
                </h2>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="soci_1" value="1"  class="w-4 h-4" onchange="toggleSociescuelaQuestions()">
                        <span class="text-gray-700">Sí</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="soci_1" value="0"  class="w-4 h-4" onchange="toggleSociescuelaQuestions()">
                        <span class="text-gray-700">No</span>
                    </label>
                </div>
            </div>

            <!-- PREGUNTA SOCI_2 (Condicional - solo si soci_1 = Sí) -->
            <div id="soci_2_container" class="bg-white rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    2. ¿Para qué ha utilizado Sociescuela? (puede marcar varias opciones)
                </h2>
                <div class="space-y-3">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_1" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Crear grupos de ayuda entre iguales</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_2" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Trabajar en equipos cooperativos</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_3" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Modificar la colocación en el aula</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_4" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Organizar grupos de un curso para el siguiente</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_5" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Para realizar mediación o resolución de conflictos</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_6" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Para trabajar el ciberacoso o situaciones de riesgo en internet y redes sociales</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_7" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Para prevención de la violencia</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_2_8" value="true" class="w-5 h-5 mt-0.5" onchange="toggleOtraEspecificar()">
                        <span class="text-gray-700">Otra</span>
                    </label>
                    <div id="soci_2_8_espec_container" class="ml-8 hidden">
                        <input 
                            type="text" 
                            name="soci_2_8_espec" 
                            placeholder="Especifique otra" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>
            </div>

            <!-- PREGUNTA SOCI_3 (Condicional - solo si soci_1 = Sí) -->
            <div id="soci_3_container" class="bg-white rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    3. ¿Han hecho una nueva evaluación tras haber realizado la intervención para comprobar su eficacia?
                </h2>
                <div class="space-y-4">
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="soci_3" value="1" class="w-4 h-4" onchange="toggleResultado()">
                            <span class="text-gray-700">Sí</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="soci_3" value="0" class="w-4 h-4" onchange="toggleResultado()">
                            <span class="text-gray-700">No</span>
                        </label>
                    </div>
                    <div id="soci_3_resultado_container" class="hidden">
                        <label class="block text-gray-700 font-medium mb-2">¿Cuál fue el resultado?</label>
                        <textarea 
                            name="soci_3_resultado" 
                            rows="3" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Escriba el resultado de la evaluación..."
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- PREGUNTA SOCI_4 (Condicional - solo si soci_1 = Sí) -->
            <div id="soci_4_container" class="bg-white rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    4. ¿Quién utiliza habitualmente esta herramienta en su centro? (puede marcar varias opciones)
                </h2>
                <div class="space-y-3">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_4_1" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">El departamento de orientación</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_4_2" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">El equipo directivo</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_4_3" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Tutores/as</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="soci_4_4" value="true" class="w-5 h-5 mt-0.5">
                        <span class="text-gray-700">Profesores/as</span>
                    </label>
                </div>
            </div>

            <!-- PREGUNTA SOCI_5 (Condicional - solo si soci_1 = Sí) -->
            <div id="soci_5_container" class="bg-white rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    5. Indique su grado de satisfacción con el programa (de 1 a 10)
                </h2>
                <div class="flex items-center gap-4">
                    <input 
                        type="number" 
                        name="soci_5" 
                        min="1" 
                        max="10" 
                        class="w-24 border border-gray-300 rounded-lg px-4 py-2 text-center text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="1-10"
                    >
                    <span class="text-gray-500 text-sm">
                        1 = Muy insatisfecho, 10 = Muy satisfecho
                    </span>
                </div>
            </div>

            <!-- PREGUNTA SOCI_6 (Condicional - solo si soci_1 = Sí) -->
            <div id="soci_6_container" class="bg-white rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    6. ¿Tienen alguna sugerencia de mejora o de cambio en el programa?
                </h2>
                <textarea 
                    name="soci_6" 
                    rows="4" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba sus sugerencias aquí..."
                ></textarea>
            </div>

            <!-- ============ SECCIÓN 2: MEDIDAS DISCIPLINARIAS Y METODOLOGÍAS ACTIVAS ============ -->

            <div class="bg-green-600 text-white rounded-lg shadow-md p-4 my-8">
                <h2 class="text-2xl font-bold text-center">SECCIÓN 2: CUESTIONARIO SOBRE MEDIDAS DISCIPLINARIAS Y METODOLOGÍAS ACTIVAS EN LOS COLEGIOS</h2>
            </div>

            <!-- DISCI_1: Medidas disciplinarias -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    1. Indique si en su centro se aplican las siguientes medidas disciplinarias, y en qué frecuencia se aplican:
                </h2>
                
                <!-- Tabla responsive -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Medida</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">Nunca</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">Rara vez</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">A veces</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">Frecuentemente</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">Siempre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Medidas tradicionales -->
                            <tr class="bg-blue-50">
                                <td colspan="6" class="border border-gray-300 px-4 py-2 font-bold text-gray-800">
                                    Medidas tradicionales
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Amonestaciones escritas</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_amonestaciones_escritas" value="1"  class="w-4 h-4 medida-radio"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_amonestaciones_escritas" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_amonestaciones_escritas" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_amonestaciones_escritas" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_amonestaciones_escritas" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Envío a jefatura</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_envio_jefatura" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_envio_jefatura" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_envio_jefatura" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_envio_jefatura" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_envio_jefatura" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Apertura de un expediente</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_apertura_expediente" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_apertura_expediente" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_apertura_expediente" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_apertura_expediente" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_apertura_expediente" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Expulsión temporal del aula</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_temporal_aula" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_temporal_aula" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_temporal_aula" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_temporal_aula" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_temporal_aula" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Expulsión del centro</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_centro" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_centro" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_centro" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_centro" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_expulsion_centro" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Partes de incidencia</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_partes_incidencia" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_partes_incidencia" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_partes_incidencia" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_partes_incidencia" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_partes_incidencia" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Suspensión de actividades extraescolares</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_suspension_extraescolares" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_suspension_extraescolares" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_suspension_extraescolares" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_suspension_extraescolares" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_suspension_extraescolares" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Aviso a la familia</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aviso_familia" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aviso_familia" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aviso_familia" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aviso_familia" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aviso_familia" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Retirada de móvil</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_retirada_movil" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_retirada_movil" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_retirada_movil" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_retirada_movil" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_retirada_movil" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Castigos (permanecer en el aula sin recreo, más deberes, etc.)</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_castigos" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_castigos" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_castigos" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_castigos" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_castigos" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            
                            <!-- Medidas restauradoras -->
                            <tr class="bg-green-50">
                                <td colspan="6" class="border border-gray-300 px-4 py-2 font-bold text-gray-800">
                                    Medidas restauradoras
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Mediación entre iguales</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_mediacion_iguales" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_mediacion_iguales" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_mediacion_iguales" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_mediacion_iguales" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_mediacion_iguales" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Círculos de diálogo</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_circulos_dialogo" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_circulos_dialogo" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_circulos_dialogo" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_circulos_dialogo" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_circulos_dialogo" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Trabajo en equipo, liderazgo compartido y aprendizaje colaborativo</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_trabajo_equipo" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_trabajo_equipo" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_trabajo_equipo" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_trabajo_equipo" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_trabajo_equipo" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Asambleas de clase</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_asambleas" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_asambleas" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_asambleas" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_asambleas" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_asambleas" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Estrategias de autorregulación emocional</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_autorregulacion" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_autorregulacion" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_autorregulacion" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_autorregulacion" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_autorregulacion" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Contratos de conducta</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_contratos_conducta" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_contratos_conducta" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_contratos_conducta" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_contratos_conducta" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_contratos_conducta" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Planes de intervención personalizados</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_planes_personalizados" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_planes_personalizados" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_planes_personalizados" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_planes_personalizados" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_planes_personalizados" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Grupos de convivencia o apoyo entre iguales</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_grupos_convivencia" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_grupos_convivencia" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_grupos_convivencia" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_grupos_convivencia" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_grupos_convivencia" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Formación en habilidades sociales y resolución de conflictos</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_formacion_habilidades" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_formacion_habilidades" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_formacion_habilidades" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_formacion_habilidades" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_formacion_habilidades" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            
                            <!-- Medidas pedagógicas -->
                            <tr class="bg-yellow-50">
                                <td colspan="6" class="border border-gray-300 px-4 py-2 font-bold text-gray-800">
                                    Medidas pedagógicas
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Refuerzo positivo de la conducta adecuada</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_refuerzo_positivo" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_refuerzo_positivo" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_refuerzo_positivo" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_refuerzo_positivo" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_refuerzo_positivo" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Estrategias de organización del aula</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_organizacion_aula" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_organizacion_aula" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_organizacion_aula" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_organizacion_aula" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_organizacion_aula" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Normas visuales y recordatorios en el aula</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_normas_visuales" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_normas_visuales" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_normas_visuales" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_normas_visuales" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_normas_visuales" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Sesiones de tutoría sobre valores y convivencia</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_tutoria_valores" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_tutoria_valores" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_tutoria_valores" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_tutoria_valores" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_tutoria_valores" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Espacios de reflexión (timeout educativo)</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_timeout_educativo" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_timeout_educativo" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_timeout_educativo" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_timeout_educativo" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_timeout_educativo" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            
                            <!-- Medidas comunitarias -->
                            <tr class="bg-purple-50">
                                <td colspan="6" class="border border-gray-300 px-4 py-2 font-bold text-gray-800">
                                    Medidas comunitarias
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Servicio a la comunidad educativa</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_servicio_comunidad" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_servicio_comunidad" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_servicio_comunidad" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_servicio_comunidad" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_servicio_comunidad" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Proyectos de aprendizaje-servicio relacionados con la convivencia</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aprendizaje_servicio" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aprendizaje_servicio" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aprendizaje_servicio" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aprendizaje_servicio" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_aprendizaje_servicio" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Participación de las familias en planes de convivencia</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_participacion_familias" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_participacion_familias" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_participacion_familias" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_participacion_familias" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_participacion_familias" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Consejos de estudiantes para la gestión de conflictos</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_consejos_estudiantes" value="1"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_consejos_estudiantes" value="2"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_consejos_estudiantes" value="3"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_consejos_estudiantes" value="4"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_consejos_estudiantes" value="5"  class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                            
                            <!-- Otras medidas -->
                            <tr class="bg-gray-50">
                                <td colspan="6" class="border border-gray-300 px-4 py-2 font-bold text-gray-800">
                                    Otras medidas
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <span>Otro (especificar):</span>
                                        <input type="text" name="disci_1_otro_especificar" class="border border-gray-300 rounded px-2 py-1 flex-1" placeholder="Especifique">
                                    </div>
                                </td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_otro_frecuencia" value="1" class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_otro_frecuencia" value="2" class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_otro_frecuencia" value="3" class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_otro_frecuencia" value="4" class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_1_otro_frecuencia" value="5" class="w-4 h-4 medida-radio" onchange="checkMetodologiasActivasVisibility()"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- DISCI_2 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    2. ¿Existen medidas disciplinarias que no aparecen en la lista y que utiliza en su centro?
                </h2>
                <textarea 
                    name="disci_2" 
                    rows="4" 
                    
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba su respuesta aquí..."
                ></textarea>
            </div>

            <!-- DISCI_3 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    3. ¿Considera que la aplicación de medidas disciplinarias en su centro es efectiva?
                </h2>
                <div class="space-y-4">
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="disci_3" value="si"  class="w-4 h-4">
                            <span class="text-gray-700">Sí</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="disci_3" value="no"  class="w-4 h-4">
                            <span class="text-gray-700">No</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="disci_3" value="depende"  class="w-4 h-4">
                            <span class="text-gray-700">Depende de la situación</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Escriba alguna aclaración:</label>
                        <textarea 
                            name="disci_3_aclaracion" 
                            rows="3" 
                            
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Escriba su aclaración aquí..."
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- DISCI_4 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    4. ¿Qué medidas disciplinarias le parecen más efectivas?
                </h2>
                <textarea 
                    name="disci_4" 
                    rows="4" 
                    
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba su respuesta aquí..."
                ></textarea>
            </div>

            <!-- DISCI_5 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    5. ¿Cuáles son los principales desafíos que enfrenta en la aplicación de medidas disciplinarias?
                </h2>
                <textarea 
                    name="disci_5" 
                    rows="4" 
                    
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba su respuesta aquí..."
                ></textarea>
            </div>

            <!-- DISCI_6 -->
            <div id="disci_6_container" class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    6. Indique en qué nivel se aplican estas metodologías activas en su centro:
                </h2>
                
                <!-- Tabla de metodologías -->
                <div class="overflow-x-auto mb-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Metodología</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">Nivel integral a nivel de centro</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">En una o varias asignaturas</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">En alguna asignatura</th>
                                <th class="border border-gray-300 px-2 py-3 text-center font-semibold text-gray-700 text-sm">No aplicable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Aprendizaje cooperativo</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_cooperativo" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_cooperativo" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_cooperativo" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_cooperativo" value="4" class="w-4 h-4"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Aprendizaje basado en problemas</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_problemas" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_problemas" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_problemas" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_problemas" value="4" class="w-4 h-4"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Aprendizaje basado en proyectos</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_proyectos" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_proyectos" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_proyectos" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_proyectos" value="4" class="w-4 h-4"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Gamificación</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_gamificacion" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_gamificacion" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_gamificacion" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_gamificacion" value="4" class="w-4 h-4"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Clase invertida (Flipped Classroom)</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_flipped" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_flipped" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_flipped" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_flipped" value="4" class="w-4 h-4"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Aprendizaje-servicio</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_servicio" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_servicio" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_servicio" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_servicio" value="4" class="w-4 h-4"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">Personalización del aprendizaje</td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_personalizacion" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_personalizacion" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_personalizacion" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_personalizacion" value="4" class="w-4 h-4"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-3 text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <span>Otro (indique cual):</span>
                                        <input type="text" name="disci_6_otro_especificar" class="border border-gray-300 rounded px-2 py-1 flex-1" placeholder="Especifique">
                                    </div>
                                </td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_otro" value="1" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_otro" value="2" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_otro" value="3" class="w-4 h-4"></td>
                                <td class="border border-gray-300 px-2 py-3 text-center"><input type="radio" name="disci_6_otro" value="4" class="w-4 h-4"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Explicación de niveles -->
                <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700">
                    <p class="font-semibold mb-2">Explicación de los niveles:</p>
                    <ul class="space-y-1 ml-4 list-disc">
                        <li><strong>Nivel integral a nivel de centro:</strong> En todas o casi todas las asignaturas de un modo integral durante todo el trimestre</li>
                        <li><strong>En una o varias asignaturas:</strong> De un modo completo durante todo el trimestre</li>
                        <li><strong>En alguna asignatura:</strong> De un modo parcial, para trabajar algún contenido</li>
                    </ul>
                </div>
            </div>

            <!-- DISCI_7 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    7. Si desea incluir más información sobre cómo lo aplican
                </h2>
                <textarea 
                    name="disci_7" 
                    rows="4" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba su respuesta aquí..."
                ></textarea>
            </div>

            <!-- DISCI_8 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    8. ¿Considera que estas metodologías activas son efectivas en la mejora del aprendizaje?
                </h2>
                <textarea 
                    name="disci_8" 
                    rows="4" 
                    
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba su respuesta a continuación..."
                ></textarea>
            </div>

            <!-- DISCI_9 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    9. ¿Y en la mejora de la convivencia escolar?
                </h2>
                <div class="flex gap-6 flex-wrap">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="disci_9" value="1"  class="w-4 h-4">
                        <span class="text-gray-700">Nada</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="disci_9" value="2"  class="w-4 h-4">
                        <span class="text-gray-700">Poco</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="disci_9" value="3"  class="w-4 h-4">
                        <span class="text-gray-700">Bastante</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="disci_9" value="4"  class="w-4 h-4">
                        <span class="text-gray-700">Mucho</span>
                    </label>
                </div>
            </div>

            <!-- DISCI_10 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    10. Explique por qué.
                </h2>
                <textarea 
                    name="disci_10" 
                    rows="4" 
                    
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba su respuesta aquí..."
                ></textarea>
            </div>

            <!-- DISCI_11 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    11. ¿Qué desafíos enfrenta su centro en la implementación de metodologías activas?
                </h2>
                <textarea 
                    name="disci_11" 
                    rows="4" 
                    
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escriba su respuesta a continuación..."
                ></textarea>
            </div>

            <!-- Botón de envío -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 text-lg"
                >
                    Enviar respuestas
                </button>
            </div>
        </form>

        <!-- Nota al pie -->
        <div class="text-center text-gray-500 text-sm mt-6">
            <p>Gracias por su colaboración. Sus respuestas ayudarán a mejorar la convivencia en los centros educativos.</p>
        </div>
    </div>

    <script src="js/validation.js?v=FINAL7"></script>
</body>
</html>