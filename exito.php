<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario Enviado - Gracias por su participación</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php
    $codigo = isset($_GET['codigo']) ? htmlspecialchars($_GET['codigo']) : 'DESCONOCIDO';
    ?>
    
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="max-w-2xl w-full">
            <!-- Tarjeta principal -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Icono de éxito -->
                <div class="flex justify-center mb-6">
                    <div class="rounded-full bg-green-100 p-3">
                        <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Título -->
                <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">
                    ¡Cuestionario Enviado con Éxito!
                </h1>
                
                <!-- Mensaje principal -->
                <p class="text-center text-lg text-gray-600 mb-6">
                    Muchas gracias por completar el cuestionario sobre Medidas Disciplinarias y Metodologías Activas en los Colegios.
                </p>
                
                <!-- Código de participante -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-center text-sm text-blue-800 font-medium mb-1">
                        Código de participante:
                    </p>
                    <p class="text-center text-2xl font-mono font-bold text-blue-900">
                        <?php echo $codigo; ?>
                    </p>
                    <p class="text-center text-xs text-blue-600 mt-2">
                        Fecha de envío: <?php echo date('d/m/Y H:i:s'); ?>
                    </p>
                </div>
                
                <!-- Información importante -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Información importante
                    </h2>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Sus respuestas han sido guardadas de forma segura</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Todos los datos son tratados de forma <strong>anónima y confidencial</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Su participación contribuirá a mejorar la convivencia en los centros educativos</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>El código <strong><?php echo $codigo; ?></strong> representa su institución. Puede haber múltiples respuestas con el mismo código si hay varios participantes de su centro educativo.</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Mensaje de agradecimiento -->
                <div class="text-center text-gray-600 border-t pt-6">
                    <p class="mb-2">
                        Si tiene alguna pregunta sobre este estudio, puede contactar con el equipo de investigación.
                    </p>
                    <p class="text-sm text-gray-500 mt-4">
                        Puede cerrar esta ventana de forma segura.
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-6 text-gray-500 text-sm">
                <p>© <?php echo date('Y'); ?> - Cuestionario sobre Medidas Disciplinarias y Metodologías Activas</p>
            </div>
        </div>
    </div>
</body>
</html>
