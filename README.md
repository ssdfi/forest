forestapp
=====
#Instalar Symfony 3.0
sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony

#Le doy permisos
sudo chmod a+x /usr/local/bin/symfony

#Creo proyecto
sudo symfony new forestapphp 3.0

#Levantar server
php bin/console server:run

#Instalo Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

#Agrego Bundle de doctrine geo
composer require CrEOF/doctrine2-spatial

#Esto es para que me haga los esquemas que ya están en la bd (sin algunas relaciones, hay que retocarla)

php bin/console doctrine:mapping:convert xml ./src/AppBundle/Resources/config/doctrine/metadata/orm --from-database -force


#DOCTRINE
#Crear base de datos
	php bin/console doctrine:database:create

#Crear esquema
	php bin/console doctrine:schema:create

#Crear Formulario
	php bin/console doctrine:generate:form

#Importar metadatos(relaciones, definición de columnas, etc) en YML (podríamos haber elegido anotaciones o xml ):
	php app/console doctrine:mapping:import AppBundle yml

#Generar Entidades en PHP
	php app/console doctrine:generate:entities AppBundle

#Limpiar Caché
	php app/console doctrine:cache:clear-metadata
	php app/console doctrine:cache:clear-query
	php app/console doctrine:cache:clear-result
