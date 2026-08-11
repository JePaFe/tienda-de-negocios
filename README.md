# Tienda de Negocios

## Productos API

### Endpoints

| Method | Endpoint                     | Description          |
| ------ | ---------------------------- | -------------------- |
| GET    | /api/v1/productos            | List all products    |
| GET    | /api/v1/productos/{producto} | Get a single product |
| POST   | /api/v1/productos            | Create a new product |
| PUT    | /api/v1/productos/{producto} | Update a product     |
| DELETE | /api/v1/productos/{producto} | Delete a product     |

### Listar productos

GET /api/v1/productos

Response:

```json
[
    {
        "id": 1,
        "nombre": "Producto 1",
        "descripcion": "Descripción del producto 1",
        "precio": 100.0,
        "created_at": "2024-06-01T12:00:00Z",
        "updated_at": "2024-06-01T12:00:00Z"
    },
    {
        "id": 2,
        "nombre": "Producto 2",
        "descripcion": "Descripción del producto 2",
        "precio": 200.0,
        "created_at": "2024-06-02T12:00:00Z",
        "updated_at": "2024-06-02T12:00:00Z"
    }
]
```

GET /api/v1/productos/1

Response:

```json
{
    "id": 1,
    "nombre": "Producto 1",
    "descripcion": "Descripción del producto 1",
    "precio": 100.0,
    "created_at": "2024-06-01T12:00:00Z",
    "updated_at": "2024-06-01T12:00:00Z"
}
```

GET /api/v1/productos/999

Response:

```json
{
    "message": "Producto no encontrado"
}
```

Status Code: 404 Not Found

### Crear un nuevo producto

POST /api/v1/productos

Request Body:

```json
{
    "nombre": "Producto 3",
    "descripcion": "Descripción del producto 3",
    "precio": 300.0,
    "stock": 50
}
```

La descripción del producto es opcional. Si no se proporciona, se establecerá como null.

Response:

```json
{
    "id": 3,
    "nombre": "Producto 3",
    "descripcion": "Descripción del producto 3",
    "precio": 300.0,
    "stock": 50,
    "created_at": "2024-06-03T12:00:00Z",
    "updated_at": "2024-06-03T12:00:00Z"
}
```

Status Code: 201 Created

### Actualizar un producto existente

PUT /api/v1/productos/1

Request Body:

```json
{
    "nombre": "Producto 1 Actualizado",
    "descripcion": "Descripción actualizada del producto 1",
    "precio": 150.0,
    "stock": 30
}
```

Response:

```json
{
    "id": 1,
    "nombre": "Producto 1 Actualizado",
    "descripcion": "Descripción actualizada del producto 1",
    "precio": 150.0,
    "stock": 30,
    "created_at": "2024-06-01T12:00:00Z",
    "updated_at": "2024-06-04T12:00:00Z"
}
```

Status Code: 200 OK

### Eliminar un producto

DELETE /api/v1/productos/1

Status Code: 204 No Content
