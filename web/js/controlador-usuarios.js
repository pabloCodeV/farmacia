function login(){

const url = 'http://localhost/farmacia/api/customers_login/' //URL de la API

  //ENVIO DE INFORMACION
  axios({
    url: url,
    method: 'POST',
    responseType:"json",
    data:{
      nombre:document.getElementById('usuario').value,
      clave:document.getElementById('clave').value
    }
  }).then(response =>{
    console.log(response);
    //EN CASO DE SER EXISTENTE, VERIFICA QUE TIPO DE USUARIO ES  (0 o 1)
    if(response.data.data[0].rol == 1){
      window.location.replace('farmacias.php')
    }else if(response.data.data[0].rol == 0){
      window.location.replace('paciente.php')
    }
  }).catch(err => {
    document.getElementById('error').innerHTML= `<div class="alert alert-danger" style="text-align-last: center;">Error</div> `
    console.log(err)
  })
}
