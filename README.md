# JosSecurity

<img src="./resourses/img/logo%20azul/cover.png" alt="Cetis Control Web Panel"/>

## ¿Qué es JosSecurity?

JosSecurity es un framework y librería al mismo tiempo, debido a que, el sistema lo podrás usar como primer uso o segundo uso en tu proyecto, JosSecurity tiene herramientas para que puedas crear tu sitio web de una manera fácil y sencilla sin tener conocimientos en el back-end.

## ¿Cómo funciona JosSecurity?

Al igual que muchas librerías, JosSecurity funciona gracias a los Hooks, en este caso, el sistema de hooks se llama “jossitos”, cada jossito es una funcionalidad de php, si necesitas una consulta en la base de datos básica o hasta la mas compleja, cada jossito se encargará de traerte los datos y tu no necesitarás nada mas que usar la función y llenar los datos.

Puedes consultar cada "jossito" en la documentación, <a href="https://jossecurity.josprox.com/documentacion">da clic aquí</a>.

## ¿Cuáles son las funciones básicas del sistema?

Por defecto, el sistema puede conectarse de manera automática la base de datos, las funciones son las siguientes:

-	Conexión sencilla.

	conect_mysqli();

-	Conexión PDO.

	conect_mysql();


También puedes usar recaptcha para integrarla en el formulario sencillo, solo tendrías que llamar a la siguiente función.

	recaptcha();

Podrás consultar más funciones en el archivo “jossecurity.php” o en el sitio web oficial “jossecurity.josprox.com”.

## ¿Qué contiene?

A parte de las funciones principales, JosSecurity cuenta con el apartado llamado “plugins” para poder integrar cualquier necesidad del sistema, es por eso que, JosSecurity no es un framework al 100% ya que te permite integrar lo que tú necesites.
Por defecto, después de instalar JosSecurity, viene con un panel de control para que puedas modificar a tu gusto el sistema desde un navegador sin tener que abrir un editor de códigos, podrás borrar este sistema sino lo necesitas. Su diseño está formado por Bootstrap.

### Usuario por defecto
El sistema viene con un usuario de administración, podrás modificarlo o crear uno en el sistema de administración.
Las siguientes credenciales es para un login exitoso:

	Usuario:
	joss@int.josprox.com
	Contraseña:
	Andyyyo12?

### Ayúdanos
Podrás ayudarnos si detectas algún error o si podemos mejorar algo, tendrás que visitar la página ayúdanos <a href="https://jossecurity.josprox.com/ayudanos/">dando clic aquí</a>.
### Para poder usar JosSecurity necesitará algunos requisitos mínimos:

- Versión mínima requerida de PHP: 8.1.0
- Espacio requerido en disco: 10 mb.
- Transferencia de red recomendada del servidor: 5 mb.

### ¿Cómo instalarlo?

Para poder instalar JosSecurity puedes <a href="https://github.com/josprox/JosSecurity/releases">dar clic aquí</a> y descargar el instalador que viene por defecto.

También puedes descargarlo via npm con el siguiente código:

	npm i jossecurity

En caso de usar npm deberás sacar los archivos "installer.php" y JosSecurity-x.x.x-zip (las x son porque puede variar en la versión) de la carpeta node_modules.

Si trabajas en un servidor:
- Descomprime el archivo zip, se descomprimirá un archivo php el cuál es el instalador, también tendrás un archivo zip con los archivos necesarios para instalar JosSecurity.
- Crea una base de datos, de preferencia usa un cortejo utf8mb4_unicode_ci.
- accede a tu dominio y al archivo correspondiente "installer.php", ejemplo: ("https://tudominio.com/installer.php")
- Sigue las instrucciones para llevar a cabo la instalación, recuerda completar todos los campos y cumplir con los requisitos mínimos.
- Una vez instalado te saldrá el siguiente mensaje 'Se ha insertado los datos de manera correcta.' y te redireccionará a tu panel con la versión de JosSecurity instalado.

Si trabajas en un localhost (usando de ejemplo xampp):
- Descarga el archivo comprimido y guárdalo en una raíz de documentos de tú servidor. Si ocupas XAMPP puede ser: C:\xampp\htdocs\
- Ahora creamos una carpeta llamada JosSecurity (esto es un ejemplo, puedes llamarlo cómo gustes): C:\xampp\htdocs\jossecurity\
- Descomprime el archivo zip, se descomprimirá un archivo php el cuál es el instalador, también tendrás un archivo zip con los archivos necesarios para instalar JosSecurity.
- Crea una base de datos, de preferencia usa un cortejo utf8mb4_unicode_ci.
- Ve al directorio antes creado con dirección a "installer.php", ejemplo: ("http://localhost/jossecurity/installer.php").
- Sigue las instrucciones para llevar a cabo la instalación, recuerda completar todos los campos y cumplir con los requisitos mínimos.
- Una vez instalado te saldrá el siguiente mensaje 'Se ha insertado los datos de manera correcta.' y te redireccionará al panel del sistema.

### Recomendaciones:

- Usar un servidor privado (VPS).
- Se recomienda ejecutarse con seguridad usando el protocolo ssl / tls.
- Se recomienda usar un panel de control para administrar el servidor, puede usar sin problemas Cpanel y Hestia Control Panel. De preferencia debería usar <a href="https://hestiacp.com/">Hestia Control Panel</a>.
- En caso de pruebas y mejoras, se recomienda usar XAMPP con php 8.1.0 o superior, debido a que, fue programado con esa versión.
- Para tener un buen funcionamiento, se recomienda que, una vez subidos los archivos, ponle los todos los permisos de leer, escribir y ejecutar (permiso 750).

#### Donaciones.

Tú puedes donar a través de <a href="https://www.patreon.com/jossestrada">patreon</a>, <a href="https://mpago.la/2gsWWYW">Mercado Pago</a> y <a href="http://paypal.me/JOSPROXMX">Paypal</a>, si deseas hacerlo solo da clic en el que te parezca más conveniente.

#### Licencia.

Un programa creado por JOSPROX MX/ JOSPROX Internacional.
Licencia: Creative Commons (Atribución-NoComercial 4.0 Internacional - Compartir igual).

<img src="./resourses/img/byncsa.jpg" alt="Atribución-NoComercial 4.0 Internacional - Compartir igual"/>

Reconocimiento - Compartir Igual (by-sa)
Esta licencia permite el uso comercial de la obra y de las posibles obras derivadas, pero la distribución de éstas se debe hacer con una licencia igual a la que regula la obra original, es decir, la obra derivada que se lleve a cabo a partir de la obra original deberá ser explotada bajo la misma licencia.

Atribución-NoComercial 4.0 Internacional (CC BY-NC 4.0)
Usted es libre de:
- Compartir — copiar y redistribuir el material en cualquier medio o formato.
- Adaptar — remezclar, transformar y construir a partir del material.
Bajo los siguientes términos:
- Atribución — Usted debe dar crédito de manera adecuada, brindar un enlace a la licencia, e indicar si se han realizado cambios. Puede hacerlo en cualquier forma razonable, pero no de forma tal que sugiera que usted o su uso tienen el apoyo de la licencia.
- NoComercial — Usted no puede hacer uso del material con propósitos comerciales.
