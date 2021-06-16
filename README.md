Este plugin fue desarrollado como parte de una estrategia Open Source para medios de todo el mundo basada en el CMS WordPress.
Haciendo click en este [enlace](https://tiempoar.com.ar/proyecto-colaborativo/) se puede encontrar más información sobre el proyecto, así como las lista de plugins que complementan a este para tener un sitio completamente funcional.

# Introducción

Tema de Wordpress desarrollado, en conjunto con una serie de plugins y APIs, específicamente para su uso en sitios web de periodismo.

# Requisitos

- [Wordpress](https://wordpress.org/download/) >= 5.7
- PHP >= 8

# Instalación y activación

1. Descargar el último release y extraerlo en `wp-content/themes/tiempo-argentino`.
2. Instalar los siguientes plugins y activarlos, siguiendo las instrucciones
de cada repositorio:
    - [Posts Balancer](https://github.com/TiempoArgentino/ta-content-balancer)
    - [Suscripciones](https://github.com/TiempoArgentino/ta-suscriptions)
    - [Roles](https://github.com/TiempoArgentino/ta-user-roles-extension)
    - [User Panel](https://github.com/TiempoArgentino/ta-user-panel)
    - [Tweets Search](https://github.com/TiempoArgentino/ta-tweets-search)
    - [Odoo](https://github.com/TiempoArgentino/ta-odoo)
    - [Mailtrain](https://github.com/TiempoArgentino/ta-mailtrain)
4. Instalar las siguientes APIs:
    - [Balancer API mongo](https://github.com/TiempoArgentino/ta-content-balancer-node-api)
    - [Etiquetador API](https://github.com/TiempoArgentino/ta-textrank-keyword-generator-api)
3. Definir las siguientes variables de entorno en `wp-config.php`
    - `TA_BALANCER_API_URI`: URI de la API del balanceador.
    - `TA_BALANCER_API_KEY`: API Key de autorización para los request a la API del balanceador.
    - `TA_ETIQUETADOR_API_URI`: URI de la API del etiquetador.
4. Ir al panel de temas del sitio (** WP-Admin -> Apariencia -> Temas **) y activar el tema `Tiempo Argentino`

# Desarrollo


1. Seguir los pasos de instalación, pero en vez de instalar el ultimo release,
clonar el repositorio en `wp-content/themes/tiempo-argentino`.
2. Instalar [Yarn](https://yarnpkg.com/getting-started/install#:~:text=the%20local%20ones%3A-,npm%20install%20-g%20yarn,-Once%20you%27ve%20followed) si no se encuentra instalado.
3. Correr `yarn install` para instalar las dependencias.

### Scripts
- `yarn install`: Instala las dependencias necesarias.
- `yarn workspaces run start`: Inicia el modo de desarrollo. Compila en tiempo
real los scripts que se encuentran en `inc/gutenberg/src`.
- `yarn workspaces run build`: Compila todos los scripts para su uso en producción.

--------------------
# Composición del sitio


## Portada

Se utiliza como landing una pagina cualquiera que se establezca como tal desde
el personalizador **( WP-Admin -> Personalizador -> Ajustes de Portada )**.

Los siguientes bloques fueron pensados para ser usados en ella:

-   Artículos
-   Podcast
-   Mow Player
-   Quote

Videos de demostración de armado de portada: https://drive.google.com/drive/folders/15Lt9E0Xfv_VGbZ2IuUqKkEHE_OZLqpTX

## Artículos

El sitio gira en torno a los **artículos**, el `custom post type` principal del
diario.

Estas entidades manejan los siguientes datos:

- **Titulo**
- **Cuerpo**
- **Extracto**
- **Nota hermana**: Vincula esta entidad con otro artículo.
- **Edición Impresa**: Vincula al artículo con una edición impresa.
- **Comentarios/Participación**: Permite establecer si los comentarios están activos para esta nota, y que formato de formulario de comentarios se utiliza (común o *Preguntá y Participá*).
- **Imagen Destacada**
- **Imagen de portada**: Si se encuentra presente, se utiliza en los bloques de artículos en vez de la destacada.
- **Taxonomías**: Entidades que sirven para clasificar a los artículos.

#### Taxonomías de un Artículo

- **Secciones**: Características generales similares. Se debe mantener la mínima cantidad posible. **Es obligatoria** y **única**.
- **Etiquetas**: Características especificas.
- **Autores**: Quienes escribieron el artículo. No debe confundirse con el autor
usuario del sitio Wordpress.
- **Micrositios**: Características aun mas generales que las secciones.
Tienen su propia landing y se manejan desde el código.
- **Temas**: No se muestra públicamente. Es utilizada por el balanceador.
- **Lugares**: No se muestra públicamente. Es utilizada por el balanceador.

Videos de demostración de armado de un artículo: https://drive.google.com/drive/folders/14ou5hI8C9bivkkPsO3lN7kXCoM1KQerk

## Ediciones Impresas

Son entidades que permiten plasmar digitalmente una edición impresa del diario, y relacionarlas con las entidades digitales del sitio. Tienen su propio archivo similar al de las etiquetas y secciones, y una pagina singular similar a las de un artículo.

Una edición impresa maneja los siguientes datos:

- **Artículos**: Los artículos relacionados a esta edición impresa
- **PDF**: La edición impresa en formato PDF
- **Portada**: Imagen de la portada.
- **Título**: Si bien permiten establecer un título, este se utiliza mas que nada para su búsqueda en el listado de ediciones impresas. El título actual del post resulta de su fecha de subida.

## Micrositios

Los micrositios son un criterio general de agrupación de artículos que presentan características extras tales como:

- Poseen una portada editable.
- Utilizan paletas de colores diferentes a la principal.
- Los artículos que sean de algún micrositio se mostraran con un template especial.
- No pueden ser modificados directamente desde el panel de administración.

### Administración de Micrositios
La generación de los micrositios ocurre al activar el tema, y se basa en la
configuración establecida en `inc\micrositios.php`

```php
/**
*   @param string slug                          Identificador del micrositio (slug del term que genera)
*   @param mixed[] settings{                    Configuración
*       @param string title                         Nombre
*       @param bool custom_content                  Indica si utiliza o no contenido personalizado editable desde el panel.
*   }
*/
new TA_Micrositio('ambiental', array(
    'title'                 => 'Activo ambiental',
    'custom_content'        => true,
));
```

## Fotógrafos

Los ítems de la galería de medios tienen la opción de establecer su
**fotógrafo**. Esta es una taxonomía personalizada que se utiliza para establecer
datos de copyright de la imagen. Se utiliza principalmente en la imagen destacada
de un artículo.

El bloque de imagen por defecto de Wordpress tiene la opción de mostrar o no
los datos del fotógrafo por debajo de la imagen.

## Header

El header posee un menú desplegable del cual se pueden modificar desde el panel las ***redes sociales*** y 3 ***listados de ítems***

#### Redes Sociales
Se modifican a través del personalizador (**WP-Admin -> Apariencia -> Personalizar -> Ajustes Globales -> Redes Sociales**). Cada una maneja los siguientes datos:

- ***Nombre***: Se utiliza para su fácil organización y para establecer el icono del ítem.
- ***Link***: URL a la pagina de la red social.
- ***Icono***: Un icono de [Font Awesome](https://fontawesome.com/). El icono se establece automáticamente si el `nombre` de la red social coincide con alguno de los siguientes: *Twitter, Instagram, Facebook, YouTube o Spotify*.

#### Listados de ítems
Se modifican a través del editor de menús de Wordpress (**WP-Admin -> Apariencia -> Menús**). Los menús utilizados son:

- ***Secciones***:  Solo permite secciones.
- - ***Especiales***:  Solo permite micrositios.
- - ***Extra***:  Permite cualquier tipo de ítems. Muestra a su lado una imagen cargada en el mismo ítem.
