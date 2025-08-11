/**
 * Inicializa una tabla con DataTables con configuración estándar en español
 * @param {string} tableId - ID del elemento tabla (sin el #)
 * @param {Object} customOptions - Opciones personalizadas para sobrescribir las predeterminadas
 */
function initDataTable(tableId, customOptions = {}) {
  // Configuración predeterminada
  const defaultOptions = {
    layout: {
      topStart: 'pageLength',
      topEnd: 'search',
      bottomStart: 'info',
      bottomEnd: 'paging'
    },
    language: {
      "decimal": "",
      "emptyTable": "No hay datos disponibles en la tabla",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
      "infoEmpty": "Mostrando 0 a 0 de 0 registros",
      "infoFiltered": "(filtrado de _MAX_ registros totales)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ registros",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "No se encontraron registros coincidentes",
      "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
      },
      "aria": {
        "orderable": "Ordenar por esta columna",
        "orderableReverse": "Orden inverso por esta columna"
      }
    }
  };

  // Combinar opciones predeterminadas con opciones personalizadas
  const options = {...defaultOptions, ...customOptions};
  
  // Inicializar DataTable con las opciones combinadas
  return new DataTable('#' + tableId, options);
}