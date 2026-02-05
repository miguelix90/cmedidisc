document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cuestionarioForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validarFormulario()) {
            mostrarMensajeCarga();
            setTimeout(() => form.submit(), 100);
        }
        return false;
    });
});

function validarFormulario() {
    limpiarErrores();
    let errores = [];
    
    // SECCIÓN 1: SOCIESCUELA
    const soci1 = document.querySelector('input[name="soci_1"]:checked');
    if (!soci1) {
        errores.push({ 
            mensaje: 'Debe responder la pregunta 1 de Sociescuela', 
            elemento: document.querySelector('input[name="soci_1"]') 
        });
    }
    
    if (soci1 && soci1.value === '1') {
        const soci5 = document.querySelector('input[name="soci_5"]');
        if (soci5 && !soci5.value) {
            errores.push({ 
                mensaje: 'Debe indicar su grado de satisfacción (1-10)', 
                elemento: soci5 
            });
        }
        
        const soci6 = document.querySelector('textarea[name="soci_6"]');
        if (soci6 && !soci6.value.trim()) {
            errores.push({ 
                mensaje: 'Debe completar las sugerencias de mejora', 
                elemento: soci6 
            });
        }
    }
    
    // SECCIÓN 2: MEDIDAS DISCIPLINARIAS
    const medidas = [
        'amonestaciones_escritas', 'envio_jefatura', 'apertura_expediente',
        'expulsion_temporal_aula', 'expulsion_centro', 'partes_incidencia',
        'suspension_extraescolares', 'aviso_familia', 'retirada_movil', 'castigos',
        'mediacion_iguales', 'circulos_dialogo', 'trabajo_equipo', 'asambleas',
        'autorregulacion', 'contratos_conducta', 'planes_personalizados',
        'grupos_convivencia', 'formacion_habilidades', 'refuerzo_positivo',
        'organizacion_aula', 'normas_visuales', 'tutoria_valores',
        'timeout_educativo', 'servicio_comunidad', 'aprendizaje_servicio',
        'participacion_familias', 'consejos_estudiantes'
    ];
    
    medidas.forEach(medida => {
        if (!document.querySelector(`input[name="disci_1_${medida}"]:checked`)) {
            const label = medida.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            errores.push({ 
                mensaje: `Debe responder: ${label}`, 
                elemento: document.querySelector(`input[name="disci_1_${medida}"]`) 
            });
        }
    });
    
    // CAMPOS DE TEXTO OBLIGATORIOS
    const camposTexto = [
        { name: 'disci_2', label: 'Pregunta 2 (medidas adicionales)' },
        { name: 'disci_3', label: 'Pregunta 3 (efectividad)' },
        { name: 'disci_3_aclaracion', label: 'Pregunta 3 (aclaración)' },
        { name: 'disci_4', label: 'Pregunta 4 (medidas efectivas)' },
        { name: 'disci_5', label: 'Pregunta 5 (desafíos)' },
        { name: 'disci_8', label: 'Pregunta 8 (efectividad en aprendizaje)' },
        { name: 'disci_9', label: 'Pregunta 9 (convivencia escolar)' },
        { name: 'disci_10', label: 'Pregunta 10 (explicación)' },
        { name: 'disci_11', label: 'Pregunta 11 (desafíos metodologías)' }
    ];
    
    camposTexto.forEach(campo => {
        const elemento = document.querySelector(`[name="${campo.name}"]`);
        if (elemento) {
            if (elemento.type === 'radio') {
                if (!document.querySelector(`input[name="${campo.name}"]:checked`)) {
                    errores.push({ 
                        mensaje: `${campo.label} es obligatorio`, 
                        elemento: elemento 
                    });
                }
            } else if (!elemento.value.trim()) {
                errores.push({ 
                    mensaje: `${campo.label} es obligatorio`, 
                    elemento: elemento 
                });
            }
        }
    });
    
    // PREGUNTA 6: METODOLOGÍAS ACTIVAS (solo si está visible)
    const contenedorMetodologias = document.getElementById('disci_6_container');
    const metodologiasVisible = contenedorMetodologias && !contenedorMetodologias.classList.contains('hidden');
    
    if (metodologiasVisible) {
        const metodologias = {
            'disci_6_cooperativo': 'Aprendizaje cooperativo',
            'disci_6_problemas': 'Aprendizaje basado en problemas',
            'disci_6_proyectos': 'Aprendizaje basado en proyectos',
            'disci_6_gamificacion': 'Gamificación',
            'disci_6_flipped': 'Clase invertida (Flipped Classroom)',
            'disci_6_servicio': 'Aprendizaje-servicio',
            'disci_6_personalizacion': 'Personalización del aprendizaje'
        };
        
        for (let nombre in metodologias) {
            if (!document.querySelector(`input[name="${nombre}"]:checked`)) {
                errores.push({ 
                    mensaje: `Pregunta 6 - ${metodologias[nombre]}`, 
                    elemento: document.querySelector(`input[name="${nombre}"]`) 
                });
            }
        }
    }
    
    if (errores.length > 0) {
        mostrarErrores(errores);
        if (errores[0].elemento) {
            setTimeout(() => {
                errores[0].elemento.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }, 300);
        }
        return false;
    }
    
    return true;
}

function mostrarErrores(errores) {
    const modal = document.createElement('div');
    modal.id = 'error-modal';
    modal.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.8);display:flex;align-items:center;justify-content:center;z-index:99999;padding:20px';
    
    modal.innerHTML = `
        <div style="background:white;border-radius:12px;max-width:700px;width:100%;max-height:85vh;overflow-y:auto;box-shadow:0 25px 50px rgba(0,0,0,0.5)">
            <div style="background:#dc2626;color:white;padding:24px;border-radius:12px 12px 0 0">
                <h2 style="margin:0;font-size:28px;font-weight:bold;display:flex;align-items:center;gap:12px">
                    <svg style="width:36px;height:36px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    ⚠️ Faltan campos por completar
                </h2>
            </div>
            <div style="padding:24px">
                <p style="margin:0 0 20px;color:#374151;font-size:16px">
                    Por favor, complete los siguientes campos obligatorios antes de enviar el formulario:
                </p>
                <div style="background:#fef2f2;border:3px solid #fecaca;border-radius:8px;padding:20px;margin-bottom:20px">
                    <p style="font-weight:bold;color:#991b1b;margin:0 0 15px;font-size:18px">
                        Total de errores: ${errores.length}
                    </p>
                    <ul style="max-height:400px;overflow-y:auto;margin:0;padding-left:25px;list-style:none">
                        ${errores.map((error, index) => `
                            <li style="margin:10px 0;color:#1f2937;font-size:15px;line-height:1.6">
                                <span style="font-weight:bold;color:#dc2626;margin-right:8px">${index + 1}.</span>
                                ${error.mensaje}
                            </li>
                        `).join('')}
                    </ul>
                </div>
                <button 
                    onclick="cerrarModalErrores()" 
                    style="width:100%;background:#2563eb;color:white;font-weight:bold;padding:16px;border:none;border-radius:8px;cursor:pointer;font-size:17px;transition:background 0.2s"
                    onmouseover="this.style.background='#1d4ed8'"
                    onmouseout="this.style.background='#2563eb'"
                >
                    Entendido, voy a completar los campos
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Aplicar bordes rojos a los campos con error
    errores.forEach(error => {
        if (error.elemento) {
            error.elemento.style.borderColor = '#ef4444';
            error.elemento.style.borderWidth = '3px';
            error.elemento.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.2)';
        }
    });
}

function cerrarModalErrores() {
    const modal = document.getElementById('error-modal');
    if (modal) {
        modal.remove();
    }
}

function limpiarErrores() {
    cerrarModalErrores();
    
    document.querySelectorAll('input, textarea, select').forEach(elemento => {
        elemento.style.borderColor = '';
        elemento.style.borderWidth = '';
        elemento.style.boxShadow = '';
    });
}

function mostrarMensajeCarga() {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.7);display:flex;align-items:center;justify-content:center;z-index:99999';
    
    overlay.innerHTML = `
        <div style="background:white;border-radius:12px;padding:50px;text-align:center">
            <div style="border:5px solid #2563eb;border-top:5px solid transparent;border-radius:50%;width:70px;height:70px;animation:spin 1s linear infinite;margin:0 auto 25px"></div>
            <h3 style="font-size:24px;font-weight:bold;margin:0 0 12px;color:#1f2937">Enviando respuestas...</h3>
            <p style="color:#6b7280;margin:0;font-size:16px">Por favor, espere un momento. No cierre esta ventana.</p>
        </div>
        <style>
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        </style>
    `;
    
    document.body.appendChild(overlay);
}

window.cerrarModalErrores = cerrarModalErrores;
