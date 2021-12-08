//VALORES RECIBIDOS DESDE PACIENTE.PHP
const latitude = document.getElementById('latitud')
const longitude = document.getElementById('longitud')

//OBTENCION DE LATITUD Y LONGITUD MEDIANTE LA DIRECCION
crear.addEventListener('click', function(){
    var api_key = 'a373d854a6e1400f8ae54b0f40ba9fba';
    var api_url = 'https://api.opencagedata.com/geocode/v1/json'
  
    var request_url = api_url
      + '?'
      + 'key=' + api_key
      + '&q=' + latitude.value+"%20"+longitude.value
      + '&pretty=1'
      + '&countrycode=ar'
      + '&no_annotations=1';

    var request = new XMLHttpRequest();
    request.open('GET', request_url, true);
  
    request.onload = function() {

      if (request.status === 200){ 
        var data = JSON.parse(request.responseText)
        lat = data.results[0].bounds.southwest["lat"]
        lng = data.results[0].bounds.southwest["lng"]
        console.log(lng);
        
        //SI SE OBTUVIERON LOS ARGUMENTOS ESPERADOS, SE GENERA UNA LLAMADA A LA API (const url) PARA MOSTRAR LOS LUGARES MAS CERCANOS
        const url = 'http://localhost/farmacia/api/farmacias/' //URL de la API
        axios.get(url, {
          params: {
            latitud: lat,
            longitud: lng
          }
        })
        .then(function (response) {
          const nombre = response.data[0].nombre
          const direccion = response.data[0].direccion
          document.getElementById('cercano').innerHTML = `<thead>
                                                              <tr class="text-center">
                                                                <th>Nombre</th>
                                                                <th>Direccion</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                            <tr>
                                                              <td>${nombre}</td>
                                                              <td>${direccion}</td>
                                                            </tr>
                                                          </tbody>`
        })
        .catch(function (error) {
          console.log(error);
        })
        .then(function () {
        }); 
  
      } else if (request.status <= 500){ 
        console.log("Direccion incorrecta: " + request.status);
        var data = JSON.parse(request.responseText);
        console.log('error msg: ' + data.status.message);
      } else {
        console.log("server error");
      }
    };
  
    request.onerror = function() {
      console.log("Imposible conectar al servidor");        
    };
    request.send();

})   

    