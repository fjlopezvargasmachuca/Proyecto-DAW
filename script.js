document.getElementById('customize-button').addEventListener('click', function() {
  var carModel = document.getElementById('car-model').value;
  var color = document.getElementById('color').value;
  var ruedas = document.getElementById('ruedas').value;
  var carroceria = document.getElementById('carroceria').value;
  var traccion = document.getElementById('traccion').value;
  var numeroPuertas = document.getElementById('numeroPuertas').value;
  var accesorios = document.getElementById('accesorios').value;
  var numeroAsientos = document.getElementById('numeroAsientos').value;
  

  var features = [];
  var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

  checkboxes.forEach(function(checkbox) {
    features.push(checkbox.labels[0].innerText);
  });

  var carDetails = document.getElementById('car-details');
  carDetails.innerHTML = 'Modelo: ' + carModel + '<br>' +
                         'Color: ' + color + '<br>' +
                         'Ruedas: ' + ruedas + '<br>' +
                         'Carroceria: ' + carroceria + '<br>' +
                         'Traccion: ' + traccion + '<br>' +
                         'Numero de Puertas: ' + numeroPuertas + '<br>' +
                         'Accesorios: ' + accesorios + '<br>' +
                         'numeroAsientos: ' + numeroAsientos + '<br>' +
                         'Características: ' + features.join(', ');

  document.getElementById('result').classList.remove('hidden');
});
