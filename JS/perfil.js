
// Obtener el elemento select
const select = document.getElementById('miSelect');

// Obtener la opción seleccionada anteriormente (si existe)
const opcionSeleccionada = localStorage.getItem('opcionSeleccionada');

// Establecer la opción seleccionada por defecto
if (opcionSeleccionada) {
  select.value = opcionSeleccionada;
}

// Actualizar la opción seleccionada en el almacenamiento local cuando cambie el valor del select
select.addEventListener('change', function() {
  const opcionActual = select.value;
  localStorage.setItem('opcionSeleccionada', opcionActual);
});



// Obtener el elemento select 2
const select2 = document.getElementById('miSelect2');

const opcionSeleccionada2 = localStorage.getItem('opcionSeleccionada2');

if (opcionSeleccionada2) {
  select2.value = opcionSeleccionada2;
}

select2.addEventListener('change', function() {
  const opcionActual = select2.value;
  localStorage.setItem('opcionSeleccionada2', opcionActual);
});



// Obtener el elemento select 3
const select3 = document.getElementById('miSelect3');

const opcionSeleccionada3 = localStorage.getItem('opcionSeleccionada3');

if (opcionSeleccionada3) {
  select3.value = opcionSeleccionada3;
}

select3.addEventListener('change', function() {
  const opcionActual = select3.value;
  localStorage.setItem('opcionSeleccionada3', opcionActual);
});


// Obtener el elemento select 4
const select4 = document.getElementById('miSelect4');

const opcionSeleccionada4 = localStorage.getItem('opcionSeleccionada4');

if (opcionSeleccionada4) {
  select4.value = opcionSeleccionada4;
}

select4.addEventListener('change', function() {
  const opcionActual = select4.value;
  localStorage.setItem('opcionSeleccionada4', opcionActual);
});


// Obtener el elemento select 5
const select5 = document.getElementById('miSelect5');

const opcionSeleccionada5 = localStorage.getItem('opcionSeleccionada5');

if (opcionSeleccionada5) {
  select5.value = opcionSeleccionada5;
}

select5.addEventListener('change', function() {
  const opcionActual = select5.value;
  localStorage.setItem('opcionSeleccionada5', opcionActual);
});