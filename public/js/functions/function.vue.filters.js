Vue.filter('formatoDinero', function(value) {
    let val = (value / 1).toFixed(0).replace('.', ',')
    let numeroFormateado = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    return `$${ numeroFormateado }`
});
Vue.filter('fechaLatina', function(value) {
    const dia = value.substring(8, 10);
    const mes = value.substring(5, 7);
    const anno = value.substring(0, 4);
    const hora = value.substring(11, 19);
    return `${dia}-${mes}-${anno} ${hora}`
});
Vue.filter('diaSemanaNmb', function(value) {
    let dia = '';
    switch (value) {
        case '1':
          dia = 'LUNES';
          break;
        case '2':
          dia = 'MARTES';
          break;
        case '3':
          dia = 'MIÉRCOLES';
          break;
        case '4':
          dia = 'JUEVES';
          break;
        case '5':
          dia = 'VIERNES';
          break;
        case '6':
          dia = 'SÁBADO';
          break;
        case '7':
          dia = 'DOMINGO';
          break;
        default:
            dia = 'ERROR';
      }

    return dia;
});
Vue.filter('fechaLatinaSinHora', function(value) {
  const dia = value.substring(8, 10);
  const mes = value.substring(5, 7);
  const anno = value.substring(0, 4);
  return `${dia}/${mes}/${anno}`;
});
Vue.filter('fechaLatinaConHora', function(value) {
  value = value.toString();
  const dia = value.substring(8, 10);
  const mes = value.substring(5, 7);
  const anno = value.substring(0, 4);
  const hora = value.substring(11, 13);
  const minutos = value.substring(14, 16);
  return `${dia}/${mes}/${anno} ${hora}:${minutos} hrs.`;
});
Vue.filter('fechaLatinaCompleta', function(value) {
  value = value.toString();
  const dia = value.substring(8, 10);
  const mes = value.substring(5, 7);
  const anno = value.substring(0, 4);
  const hora = value.substring(11, 13);
  const minutos = value.substring(14, 16);
  const segundos = value.substring(17, 19);
  return `${dia}/${mes}/${anno} ${hora}:${minutos}:${segundos} hrs.`;
});