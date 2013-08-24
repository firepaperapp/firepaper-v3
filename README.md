firepaper-v1
============

firepaperapp.com - version 1
---------------------------------
(this copy is just a cleaned-up version from the given folders which contain previously developed app.
feel free to debug any errors.)

## Setup CakePHP
* create the following directories and make sure they are writable by your web server
* **app/tmp**
* **app/tmp/cache**
* **app/tmp/cache/models**
* **app/tmp/cache/persistent**
* **app/tmp/logs**
* **app/tmp/sessions**
* **app/tmp/tests**

## Setup Database
* create your MySQL database
* import the tables from **app/config/Schema/ubundkac_bundle.sql**
* download **app/config/database.php.default** from CakePHP 2.3.1 and rename it to **app/config/database.php**
* update the **DATABASE_CONFIG** class with your local database settings

## Setup Paths
* update the **SITE_BASE_PATH** and **SITE_HTTP_URL** in **app/config/site_constants.php** to match your local system
* do a **git update-index --assume-unchanged app/config/site_constants.php** to ignore your changes