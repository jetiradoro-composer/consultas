# Consultas Dinámicas
He creado un componente para poder realizar consultas dinámicas de tal forma que se pueda extraer de manera rápida cualquier dato de las tablas configuradas en el componente.

## Documentación Técnica
Este componente está realizado con como un módulo de Laravel 5.3 y con Vue para el flujo de datos. Para poder utilizarlo, el proyecto debe de estar desarrollado con Laravel y utilizar el componente:

`nwidart/laravel-modules`

una vez integrado el módulo de consultas, únicamente se tiene que publicar sus assets al proyecto principal con el comando:

**`php artisan module:publish`**

### Como se configura
Cuando esté instalado lo único que tenemos que hacer es ir al arxivo: *Modules/Config/config.php* i dentro del array de *entities* pondremos el par de clave valor que necesitamos para trabajar en la aplicación dónde los datos deberántener el siguiente significado:

- **key** : Es el nombre de la entidad que queremos que se muestre por pantalla en el desplegable
- **value** : Es la ruta con el namespace incluido del Modelo de datos que laravel dónde se encuentra definida la instancia con la base de datos de esta entidad.

Ejemplo:
```
'entities' => [
    'Elemento 1' => 'App\Models\Productos',
]
```

### Funcionamiento
La url para acceder al módulo se encontrará inicialmente en **/consultes**
 
`La ruta se puede redefinir en el archivo: Modules/Consultas/Http/routes.php`

Éste sistema permite internamente a través del servicio: **/Modules/Consultas/Http/Services/ConsultesModelService.php** se consulte el modelo de datos de la aplicación configurado en el archivo de configuración, y se obtienen todas las columnas creadas en la tabla.

En la aplicación se mostrarán todas aquellas columnas para poder seleccionarse y también se utilizaran en el filtro.

Si hay alguna columna que no queremos que se muestre disponible en la selección, como por ejemplo; deleted_at,created_at... para evitar que estos campos aparezcan, únicamente hay que añadirlos en el array $hidden del modelo de datos de laravel Eloquent.

`protected $hidden = ['created_at','updated_at','deleted_at'];`


