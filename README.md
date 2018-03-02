# Consultes Dinàmiques
He creat un component per poder realitzar consultes dinàmiques de tal manera que es pugui extreure de manera ràpida qualsevol dada de les taules configurades al component.

## Documentació Tècnica
Aquest component està realitzat amb un mòdul de Laravel i amb Vue. Per poder utilitzar-lo el projecte ha d'estar desenvolupat amb Laravel i ha d'utilitzar el component: 

<code>nwidart/laravel-modules</code>

una vegada integrat el mòdul de consultes només s'ha de publicar els seus assets al projecte principal amb la comanda a la consola:

**`php artisan module:publish`**

### Com es configura
Quan estigui instal.lat l'unic que hem de fer és anar a l'arxiu: Modules/Config/config.php i dintre de l'array entities posem el parell clau:valor que necessitem treballar a l'aplicació, on:

- **key** => És el nom de la entitat que volem que es mostri per pantalla en el desplegable
- **value** => És la ruta amb el namespace inclòs del Model de dades de laravel on es trova definida la instància amb la base de dades d'aquesta entitat


Exemple: 
```
'entities' => [
    'Alumnes Potencials' => 'App\Models\Marqueting\AlumnePotencial',
    'Captacions' => 'App\Models\Views\Mkt_Datamart',
    'Persones' => 'App\Models\Persona'
]
```

### Funcionament
La url per accedir al mòdul es trobarà a: http/https://[my_domain.com]/consultes

`La ruta es pot redefinir a l'arxiu: Modules/Consultas/Http/routes.php`

Aquest sistema permet que internament a través del servei: **/Modules/Consultas/Http/Services/ConsultesModelService.php** es consulta el model de dades de l'aplicació configurat a l'arxiu de configuració i s'obté totes les columnes creades a la taula.

A l'aplicació es mostraràn totes aquestes columnes per poder seleccionar-les al select i també s'utilitzaràn al filter. 

Si hi ha alguna columna que no volem que es mostri disponible a la selecció, com per exemple poden ser, deleted_at, created_at, o valors que no aportin gaire funcionalitat a la select. Per evitar que aquests camps apareguin només els hem d'afegir a l'array $hidden del model de dades de laravel.

`protected $hidden = ['created_at','updated_at','deleted_at'];`

### Construcció SQL
L'aplicació una vegada té les dades definides per l'usuari al frontend, a través de vue i ajax fa una petició al controlador, i aquest construeix la SQL tal qual se li pasa, amb l'excepció de la consulta de filtre entre dates.

En el cas de seleccionar un filtre de dates, el controller separa les dates i les afegeix a una cadena de consulta de **Oracle** utilizant la funció de **PL/SQL** TO_DATE().

```
Important: Si el component l'utilitzem contra una base de dades MySQL aquesta part de la configuració s'haurà de modificar. El mètode el trobarem a:
Modules/Consultas/Http/Controllers/ConsultaController.php a la línia 180
</pre>
```
 
 ----

## Manual d'usuari
Quan accedim a la pantalla de consultes dinàmiques, ens trobarem amb un formulari dissenyat en passos o pestanyes.

1. A la primera tab, podrem seleccionar una de les entitats configurades per ser consultades. 
2. Tant bon punt la seleccionem podrem veure que apareixen tots els camps que podem seleccionar per a què apareguin a les columnes de la consulta. ***És obligatori seleccionar com a mínim 1***
3. Una vegada hem escollit els camps podrem accedir a la segona secció on podrem utilitzar el filtre que es compón de:
   * Un camp concatenador, que al primer filtre no es pot veure, però si afegim més d'una condició haurem de seleccionar si volem utilitzar AND o OR.
   * El següent paràmetre correspòn a la columna que volem filtrar.
   * El tercer paràmetre és quin tipus de condició volem utilitzar. On podem trobar:
     + **(=)** On la dada definida al valor ha d'existir exactament igual a la base de dades.
     + **(!=)** On les dades obtenides han de ser diferents al valor definit
     + **(>=)** Pensat només per casos numèrics, defineix un Major o igual a...
     + **(<=)** Pensat només per casos numèrics, defineix un Menor o igual a...
     + **(in)** Dades inclusives, al valor s'ha de possar els camps cercats separats per una ,
     + **(contains)** Filtre amb comodins, la cadena inserida serà cercada amb qualsevol text per devant o per darrera
     + **(is null)** Filtre per buscar una columna amb valors nulls
     + **(is not null)** Filtre per buscar dades amb una columna que no tingui valors nulls
     + **(between dates)** Filtre per buscar entre dues dates. Les dates introduïdes han de seguir el format dd/mm/yyyy
   * Per últim trobarem el camp on posarem els valors a filtrar
   * Per acabar hem d'afegir el filtre a la consulta, per això hem de fer click al botó Add Filter
4. Per acabar podem fer la cerca per treure-la per pantalla o per exportar-la a excel en funció del botó que apretem de la part superior del mòdul

Les dades obtenides les trobareu en una taula a la part inferior de la pàgina.
