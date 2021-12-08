/************ CONSULTAS A LA API ************/
const url = 'http://localhost/farmacia/api/farmacias/' //URL de la API
const contenedor = document.querySelector('tbody')
let resultados  = ''

const modalAtributo = new bootstrap.Modal(document.getElementById('modalAtributo'))
const formAtributo = document.querySelector('form')
const nombre = document.getElementById('nombre')
const direccion = document.getElementById('direccion')
const latitud = document.getElementById('latitud')
const longitud = document.getElementById('longitud')
let opcion = ''

//ABRE LA VENTANA PARA CREAR UN NUEVO ELEMENTO Y LA LIMPIA
btnCrear.addEventListener('click',()=>{
    nombre.value  = ''
    direccion.value  = ''
    latitud.value  = ''
    longitud.value  = ''
    modalAtributo.show()
    opcion = 'crear'
})

//CREA UN LISTADO Y LO INYECTA EN HTML
const mostrar  = (atributos)  => {
  atributos.forEach( atributo=> {
    resultados+=`<tr>
                    <td>${atributo.id}</td>
                    <td>${atributo.nombre}</td>
                    <td>${atributo.direccion}</td>
                    <td>${atributo.latitud}</td>
                    <td>${atributo.longitud}</td>
                    <td class="text-center"><a class="btnEditar btn btn-primary">editar</a><a class="btnBorrar btn btn-primary delete">Borrar</a></td>
                </tr>`
    })
    contenedor.innerHTML = resultados
}

//****** GET API FARMACIAS ******
fetch(url)
        .then( response => response.json())
        .then( data => mostrar(data))
        .catch( error => console.log(error))  

const on = (element, event, selector, handler) => {
    element.addEventListener(event, e => {
        if(e.target.closest(selector)){
            handler(e)
        }
    })
}

//****** DELETE API FARMACIAS ******
on(document, 'click', '.btnBorrar', e => {
    const fila = e.target.parentNode.parentNode
    const id = fila.firstElementChild.innerHTML
    console.log(fila.firstElementChild.innerHTML);
    alertify.confirm("¿Estas seguro?.",
    function(){
        fetch(url+id+'/', {
            method: 'DELETE'
        })
        .then( res => res.json() )
        .then( () => location.reload())
    },
    function(){
        alertify.error('Cancel')
    })
})

//****** POST (Nuevo/edit) API FARMACIAS ******
let idForm = 0
on(document, 'click', '.btnEditar', e => {    
    const fila = e.target.parentNode.parentNode
    idForm = fila.children[0].innerHTML
    const nombreForm = fila.children[1].innerHTML
    const direccionForm = fila.children[2].innerHTML
    const latitudForm = fila.children[3].innerHTML
    const longitudForm = fila.children[4].innerHTML
    nombre.value =  nombreForm
    direccion.value =  direccionForm
    latitud.value =  latitudForm
    longitud.value = longitudForm
    opcion = 'editar'
    modalAtributo.show()
})

//PROCEDIMIENTO PARA CREAR O EDITAR
formAtributo.addEventListener('submit', (e) => {
    e.preventDefault()
    if(opcion == 'crear'){        
        fetch(url, {
            method:'POST',
            headers: {
                'Content-Type':'application/json'
            },
            body: JSON.stringify({
                nombre:nombre.value,
                direccion:direccion.value,
                latitud:latitud.value,
                longitud:longitud.value 
            })
        })
        .then( response => response.json() )
        .then( data => {
            const nuevoAtributo = []
            nuevoAtributo.push(data)
            mostrar(nuevoAtributo)
        })
    }
    
    if(opcion == 'editar'){    
        fetch(url+idForm+'/',{
            method: 'POST',
            headers: {
                'Content-Type':'application/json'
            },
            body: JSON.stringify({
                nombre:nombre.value,
                direccion:direccion.value,
                latitud:latitud.value,
                longitud:longitud.value 
            })
        })
        .then( response => response.json() )
        .then( response => location.reload() )
    }
    modalAtributo.hide()
})
