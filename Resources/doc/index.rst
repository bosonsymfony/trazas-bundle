Componente: TrazasBundle
========================

1. Descripción general
----------------------

    Está orientado a gestionar las diferentes trazas que se generan en cada bundle.
    Garantiza el registro en base de datos utilizando Doctrine de las trazas generadas por la interacción de los usuarios con la aplicación de forma organizada para su posterior análisis.

2. Instalación
--------------

    1. Copiar el componente dentro de la carpeta `vendor/boson/trazas-bundle/UCI/Boson`.
    2. Registrarlo en el archivo `app/autoload.php` de la siguiente forma:

       .. code-block:: php

           // ...
           $loader = require __DIR__ . '/../vendor/autoload.php';
           $loader->add("UCI\\Boson\\TrazasBundle", __DIR__ . '/../vendor/boson/trazas-bundle');
           // ...

    3. Activarlo en el kernel de la siguiente manera:

       .. code-block:: php

           // app/AppKernel.php
           public function registerBundles()
           {
               return array(
                   // ...
                   new UCI\Boson\TrazasBundle\TrazasBundle(),
                   // ...
               );
           }

3. Especificación funcional
---------------------------

3.1 Requisitos funcionales
~~~~~~~~~~~~~~~~~~~~~~~~~~


3.1.1 Configuración de las trazas activas en el sistema
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

	Dentro del fichero de un configuración como app/config/config.yml  o cualquier otro que esté importado se puede definir la configuración del componente.
	Este bloque debe encontrarse dentro de la etiqueta **trazas:**.
	En este deben estar especificados los diferentes tipos de trazas y si están habilitados, asi como el manejador de *Doctrine* a utilizar, este parámetro utiliza
	 por defecto *doctrine*. La especificación debe ser de la siguiente forma:

	.. code-block:: php

	    parameters:
  	        ......
  	        trazas:
	            types: { data: true, exception: true, action: true, performance: true }
	            doctrine_manager: doctrine    # hasta el momento puede ser también doctrine_mongodb

	Si se desea desabilitar algunos de los tipos de trazas basta con especificar false el tipo de traza.

3.1.2 Definir las entidades con los datos a almacenar
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

	Los tipos de trazas que existen y están listos para gestionarse se  deben encontrar registrados en la tabla correspondiente a la entidad **nomTipotraza** (ver **Volcar tipos de trazas en la base de datos**).
	Luego, para cada tipo de trazas existe una entidad definida dentro del directorio \Entity del bundle la cual comienza con la nomenclatura (his+Nombre de la traza).
	Todos los tipos de trazas heredan de la entidad **hisTraza** la cual agrupa los campos comunes que presentan todas las trazas.
	Si se requiere adicionar alguna nueva traza se debe registrar en la anotación **DiscriminatorMap** de la entidad **hisTraza** de la siguiente forma:

	.. code-block:: php

	    /**
	     * ModTrazas.hisTraza
	     *
	     * @ORM\Table(name="mod_trazas.his_traza")
	     * @ORM\Entity
	     * @ORM\Entity(repositoryClass="UCI\Boson\TrazasBundle\Repository\hisTrazaRepository")
	     * @ORM\InheritanceType("JOINED")
	     * @ORM\DiscriminatorColumn(name="discriminante", type="string")
	     * @ORM\DiscriminatorMap({"a" = "hisAccion",...., "idNew" = "EntidadTrazaNueva"})
	     */
	     class hisTraza
	     {
	     .....

	En la entidad del nuevo tipo de traza se debe especificar que esta extiende de la clase-entidad **hisTraza** de la manera convencional. Luego se debe especificar cada uno de los atributos específicos que se desean almacenar para el nuevo tipo de traza.

	Recuerde que es necesario crear en la base de datos todas las entidades del componente **TrazasBundle**, esto se puede realizar actualizando el *schema* de la siguiente forma **doctrine:schema:update --force**. Recuerde ejecutar antes el comando **doctrine:schema:update --dump-sql** para comprobar las sentencias que van a ejecutarse y no afectar otras tablas.

3.1.3 Almacenar las trazas en los casos siguientes:
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

- Se inicia una acción en el sistema:

	Cuando se inicia una acción en el sistema se almacena una traza de tipo **accion**.	Esta se registra en dos tablas, los atributos comunes para todos los tipos de trazas se registran en la tabla correspondiente a la entidad **hisTraza** y los específicos de las trazas
	de acción se registran en una tupla  en la tabla correspondiente a la entidad **hisAccion**, esta tupla mantiene el mismo id que el de la tupla registrada en **hisTraza**.

	Si el tipo de traza **rendimiento** está activa, también se registra una tupla en la tabla correspondiente a la entidad **hisRendimiento**. Esta tiene como identificador el id de la tupla insertada en la tabla **hisAccion** que le corresponde y como datos almacena el tiempo en milisegundos y la memoria utilizada en bytes.

- Se produce un acceso a datos:

	Las trazas de tipo **datos**  se registran cuando se lanzan los eventos postPersist, postUpdate, postRemove. Por cada uno de estos eventos relacionados con las operaciones de insertar, actualizar y eliminar respectivamente de alguna tabla se inserta una tupla en la tabla correspondiente a la entidad **hisTraza** y se inserta otra en la tabla correspondiente a la entidad **hisDatos**.

- Se produzcan excepciones:


	Cuando se inicia una acción en el sistema se almacena una traza de tipo **excepcion**.	Esta se registra en dos tablas, los atributos comunes para todos los tipos de trazas se registran en la tabla correspondiente a la entidad **hisTraza** y los específicos de la trazas
	de acción se registran en una tupla  en la tabla correspondiente a la entidad **hisAccion**, esta tupla mantiene el mismo id que el de la tupla registrada en **hisTraza**.

- Se utilicen servicios:


    Esta funcionalidad aún no está implementada en espera de la implementación del componente de servicios.

3.1.4 Realizar búsquedas a partir de:
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

- Fechas de generación:

	El componente brinda el conjunto de funcionalidades siguientes para realizar búsquedas a partir de fechas:
		- findByLimit( $start, $limit)
		- findbyFecha( $fechainicio, $fechafin)
		- findLimitByFecha( $fechainicio, $fechafin, $start, $limit)

	Estas están implementadas y descritas sus funciones en los repositorios de consultas correspondientes a cada una de las entidades relacionadas con los tipos de trazas. Estas clases pueden ser encontradas en TrazasBundle/Repository/.

- El tipo de traza:

	El componente brinda la funcionalidad findbyTipo la cual se encuentra implementada en el repositorio **nomTipoTrazasRepository** ubicado en TrazasBundle/Repository/. Esta permite encontrar un tipo de traza a partir de una cadena de caracteres.

3.1.5 Volcar tipos de trazas en la base de datos
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

	Para empezar a almacenar trazas unos de los primeros pasos es agregar a la tabla **nomTipotraza** los tipos de trazas a almacenar en el sistema. Para ello se debe ejecutar el comando **doctrine:fixtures:load  path-del-fixtures **, este debe encargarse de llenar la tabla **nomTipoTraza**.

3.2 Requisitos no funcionales
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

3.2.1 Disponibilidad
^^^^^^^^^^^^^^^^^^^^

	La aplicación debe contar con una conexión previamente establecida con alguno de los sistemas gestores de base de datos
	 (preferiblemente postgres o mysql) y haberse  generado las tablas de los tipos de trazas a almacenar.
	También cuenta con soporte para MongoDB, para esto es necesario cambiar al manejador de mongodb en la configuración e instalar el bundle *DoctrineMongoDBBundle*

3.2.2 Eficiencia
^^^^^^^^^^^^^^^^

	El rendimiento del componente y su consiguiente afectación al rendimiento general del sistema en que se utiliza, está condicionado a los recursos de hardware que posea el servidor  donde se despliega el sistema. Si todas las trazas que se almacenan están activas el volumen de tuplas que se insertan  por cada una de las operaciones que realiza el cliente es considerable y las tablas de trazas tienden a crecer considerablemente con el tiempo por lo que se necesita buena capacidad de procesamiento y almacenamiento.

3.2.2 Reusabilidad
^^^^^^^^^^^^^^^^^^

	El componente puede ser utilizado en cualquier sistema implementado sobre versiones de Symfony 2.

4. Servicios que brinda
-----------------------


5. Servicios de los que depende
-------------------------------


6. Eventos generados
--------------------


7. Eventos observados
---------------------

	.. code-block:: php

	    onKernelException(GetResponseForExceptionEvent $event)

	El evento **onKernelException** es observado con el objetivo de almacenar las trazas de tipo excepción. Ver implementación  de la clase ..\\TrazasBundle\\EventListener\\ExceptionListener.php

	.. code-block:: php

	    onKernelResponse(FilterResponseEvent $event)

	El evento **onKernelResponse** es observado con el objetivo de almacenar las trazas de tipo **accion**. Ver implementación  de la clase ..\\TrazasBundle\\EventListener\\AccionListener.php

	.. code-block:: php

	    onKernelTerminate(PostResponseEvent $event)

	El evento **onKernelTerminate** es observado con el objetivo de almacenar las trazas de tipo **rendimiento**. Ver implementación  de la clase ..\\TrazasBundle\\EventListener\\AccionListener.php

	.. code-block:: php

	    postPersist(LifecycleEventArgs $args)

	El evento **onKernelTerminate** es observado con el objetivo de almacenar las trazas de tipo **datos**, solo las asociadas a la persistencia. Ver implementación  de la clase ..\\TrazasBundle\\EventListener\\DatoListener.php

	.. code-block:: php

	    postUpdate(LifecycleEventArgs $args)

	El evento **onKernelTerminate** es observado con el objetivo de almacenar las trazas de tipo **datos**, solo las asociadas a la actualización de tuplas. Ver implementación  de la clase ..\\TrazasBundle\\EventListener\\DatoListener.php

	.. code-block:: php

	    postRemove(LifecycleEventArgs $args)

	El evento **onKernelTerminate** es observado con el objetivo de almacenar las trazas de tipo **datos**, solo las asociadas a la eliminación de tuplas. Ver implementación  de la clase ..\\TrazasBundle\\EventListener\\DatoListener.php


8. Otras características
------------------------

	La subscripción a los distintos eventos que son escuchados por los *listeners* definidos para cada tipo de trazas se encuentra en el fichero **TrazasBundle/Resources/config/servicesListeners.yml**. Este fichero se genera cada vez que el sistema cachea toda la información inicial (**en el entorno de producción solo la primera vez**, si ocurren cambios debes limpiar la caché). El mecanismo para generarlo es utilizando la misma técnica de generar ficheros del bundle GeneratorBundle. La implementación se encuentra en la clase **TrazasBundle/Generator/ServiceFilGenerator** y la plantilla utilizada en la carpeta skeleton de esa misma dirección.

---------------------------------------------


:Versión: 1.0 17/7/2015

:Autores: Daniel Arturo Casals Amat dacasals@uci.cu


Contribuidores
--------------

:Entidad: Universidad de las Ciencias Informáticas. Centro de Informatización de Entidades.

Licencia
--------

