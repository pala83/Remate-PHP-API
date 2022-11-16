# API Restfull - Documentacion
Esta API maneja los datos relacionados a los clientes del remate

## Indice

- [Tabla general](#tabla-general)
- [GET](#get)
    - [Filtrado por columna](#filtrado-por-columna)
    - [Ordenamiento por columna](#ordenamiento-por-columna)
    - [Paginado](#paginado)
    - [ejemplos practicos](#ejemplos-practicos)
- [POST](#post)
    - [ejemplos practicos](#ejemplos-practicos-1)
- [PUT](#put)
    - [ejemplos practicos](#ejemplos-practicos-2)

# Tabla general
Las opciones de FIltrado, Paginado y Ordenamiento comienzan con un "**?**", se concatenan con un "**&**", las opciones no son **case sensitive** y no tienen un orden estricto de aplicacion.

| Method | Option | Body | Descripcion |
|--------|--------|------|-------------|
| `GET`  | clientes     | | Retorna la coleccion completa de clientes |
| `GET`  | clientes/ID   | | Retorna el cliente con el id ID |
| `GET`  | clientes?`order`=[columna] | | Ordena la coleccion de clientes por la columna [columna] |
| `GET`  | clientes?`sortby`= ASC DESC | | Ordena la coleccion de clientes de forma ascendente o descendente.<br> **IMP**: necesario especificar la columna que desea ordenar con la opcion ?order |
| `GET`  | clientes?`limit`=[numero] | | Pone un limite a la cantidad de registros retornados por la peticion. <br> **IMP**: El valor [numero] no debe ser inferior a 0 |
| `GET`  | clientes?`page`=[numero] | | Retorna la pagina de registros [numero] en caso de que no se muestren todos. <br> **IMP**: El valor [numero no debe ser inferior a 0. <br> **IMP**: Necesario aplicar un limite en el retorno de registros con la opcion ?limit.] |
| `POST`  | clientes   | `{"nombre" : "","apellido" : "","email" : "","telefono" : ""}` | Genera un nuevo registro en la tabla |
| `PUT`  | clientes/ID | `{"nombre" : "","apellido" : "","email" : "","telefono" : ""}` | odifica el registro con el id ID |
| `DELETE` | | | No implementado |

# GET
Las peticiones GET retornan en formato JSON una coleccion de clientes a la cual se le puede aplicar una serie de filtros, ordenamientos y paginados.

La URI puede ser tan compleja como se lo necesite, dentro de los limites establecidos, comienza aplicando un "?" y concatena cada filtro, ordenamiento o paginado con &.
## Filtrado por columna
El filtrado es por valor exacto, se declara la columna a la cual se desea filtrar y el valor por el cual se desea filtrar.

**Ejemplo**
~~~
clientes?nombre=fulano&apellido=detal
~~~
## Ordenamiento por columna
Se debe declarar la columna por la cual se desea hacer un ordenamiento de registros y a continuacion se establece el orden (ASC o DESC) de los valores.

El ordenamiento o "sortby" es opcional, por defecto la query se genera con ordenamiento ASC.

**Ejemplo**
~~~
clientes?order=apellido&sortby=DESC
~~~

## Paginado
El paginado limita la totalidad de registros que se retornan en la peticion.

La pagina o "page" solo se debe especificar si se aplico un "limit", en caso contrario no cumplira su funcion.

**Ejemplo**
~~~
clientes?limit=4&page=0
~~~
## Ejemplos practicos
**METHOD**: GET
~~~
clientes?apellido=detal&order=nombre&sortby=DESC&limit=1&page=0
~~~

# POST
Agrega un registro a la tabla, en el Body de la peticion se debe especificar en formato JSON los datos pertinentes del cliente, solo se puede omitir su Email.
## Ejemplos practicos
**METHOD**: POST
~~~ json
URL: /api/clientes
BODY:
{
    "nombre" : "jose",
    "apellido" : "lopez",
    "email" : "jose@yahoo.ar",
    "telefono" : "2494090909"
}
~~~
# PUT
Edita el contenido de un registro con un id determinado
## Ejemplos practicos
**METHOD**: PUT
~~~ json
URL: /api/clientes/429
BODY:
{
    "nombre" : "jose",
    "apellido" : "lopez",
    "email" : "jose@yahoo.ar",
    "telefono" : "2494090909"
}