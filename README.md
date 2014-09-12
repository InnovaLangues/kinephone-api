kinephone-api
=============

First version of the kinephone api.

- clone repository  and run composer install.
- change dbname, user and password
- add rights for log folder by runnig setfacl commands :

```setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/logs/```

```setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX app/logs/``` 

if you want to enable cross origin requests
===========================================

- create a .htaccess in the web directory 
- add this line in the newly created file : Header set Access-Control-Allow-Origin "*"
- check the syntax by running : apachectl -t
- restart apache 2 : service apache2 reload
- be sure to activate mod_headers module by running : a2enmod headers

Request example
===============
http://localhost/kinephone-api/web/index.php/kinephones/1?method=1


