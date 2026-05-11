function actualizarPrecio() {
    const selectCancha = document.getElementById('id_cancha');
    const selectDuracion = document.getElementById('duracion_turno');
    const cuadro = document.getElementById('cuadro_precio');
    const spanPrecio = document.getElementById('precio_final');
    const spanTexto = document.getElementById('texto_duracion');

    // Obtenemos qué opción de cancha está elegida
    const opcionCancha = selectCancha.options[selectCancha.selectedIndex];
    const precioBase = parseFloat(opcionCancha.getAttribute('data-precio'));
    
    // Obtenemos la cantidad de horas elegidas
    const horas = parseFloat(selectDuracion.value);

    // Si hay un precio base válido, hacemos la matemática
    if(precioBase) {
        cuadro.classList.remove('d-none');
        
        // Multiplicamos el precio por las horas
        const total = precioBase * horas;
        spanPrecio.innerText = '$' + total;
        
        // Actualizamos el textito
        //spanTexto.innerText = 'Total ' + horas + ' Horas:';
        spanTexto.innerText = horas + (horas === 1 ? ' Hora = ' : ' Horas = ');
    } else {
        cuadro.classList.add('d-none');
    }
    
    // ACÁ ELIMINAMOS EL actualizarHorarios() QUE CAUSABA EL PROBLEMA
}

function actualizarHorarios() {
    const idCancha = document.getElementById('id_cancha').value;
    const fecha = document.getElementById('fecha_reserva').value;
    const selectHora = document.getElementById('hora_reserva');

    if (idCancha && fecha) {
        // TRUCO DE MEMORIA: Guardamos la hora que ya tenías elegida
        const horaElegida = selectHora.value;

        selectHora.innerHTML = '<option value="">Buscando...</option>';

        fetch(`../php/obtener_horarios.php?id_cancha=${idCancha}&fecha=${fecha}&t=${new Date().getTime()}`)
            .then(res => res.json())
            .then(horarios => {
                selectHora.innerHTML = '<option value="">-- Seleccione Hora --</option>';
                    
                if (horarios.length > 0) {
                    horarios.forEach(hora => {
                        const option = document.createElement('option');
                        option.value = hora;
                        option.textContent = hora + ' hs';
                        selectHora.appendChild(option);
                    });

                    // Si la hora que habías elegido sigue en la lista, te la volvemos a seleccionar
                    if (horaElegida && horarios.includes(horaElegida)) {
                        selectHora.value = horaElegida;
                    }

                } else {
                    selectHora.innerHTML = '<option value="">Sin turnos para este día</option>';
                }
            })
            .catch(error => {
                console.error('Error al cargar horarios:', error);
                selectHora.innerHTML = '<option value="">Error de conexión</option>';
            });
    }
}

// ==========================================
// ESCUCHADORES DE EVENTOS (Corregidos)
// ==========================================

// 1. Si cambia la cancha: actualiza el precio Y busca los horarios de esa cancha
document.getElementById('id_cancha').addEventListener('change', () => {
    actualizarPrecio();
    actualizarHorarios();
});

// 2. Si cambia la fecha: solo busca los horarios de ese día
document.getElementById('fecha_reserva').addEventListener('change', actualizarHorarios);

// 3. Si cambia la duración: SOLO calcula el precio (no borra la hora)
document.getElementById('duracion_turno').addEventListener('change', actualizarPrecio);

window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('reserva') === 'ok') {
        const telefono = "54381XXXXXXX"; // <--- PONÉ TU NÚMERO ACÁ (sin el +)
        const mensaje = encodeURIComponent("¡Hola! Acabo de realizar una reserva y quiero enviar el comprobante de pago. El Alias es canchas.pampa.tuc");
        
        // Abrimos WhatsApp en una pestaña nueva
        window.open(`https://wa.me/${telefono}?text=${mensaje}`, '_blank');
    }
});