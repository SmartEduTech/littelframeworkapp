# litelleframework-mvc-skeleton 

## Introduction
--Version 
This is a application skeleton application using the litelleframwork MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with litelleframwork MVC.

## Installation using Composer

The easiest way to create a new litelleframwork MVC project is to use
[Composer](https://getcomposer.org/). If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

To create your new littelframework MVC project:

```bash
$ composer create-project -sdev smartedutech/littelframeworkapp path/to/install
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public
# OR use the composer alias:
$ composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/
- which will bring up litelleframwork MVC Skeleton welcome page.

**Note:** The built-in CLI server is *for development only*.


## Development mode
 
 You cas use a simple generator included in this project.
 the generator is a package named smartedutech/litelle-framework-generator
```bash
 $ composer require smartedutech/litelle-framework-generator
```
the file used to generate your CRUD is '/public/generator.php'
## Development mode configure generator
to configure the crud you must implement this file 'vendor\smartedutech\litelle-framework-generator\src\Configgen\module.php' 
the file content the name of package and the name of your controllers and actions with the database tables 
```configure application package
$_APP_CONF=array(
    "APPNAME"=>"e-lab-reservation"
);
```

```module configure
 "modules"=>array(
        "admin"=>array(
            "name"=>"admin"
            ,"Controller"=>array(
            )
        )
 )
 ```

 ''controllers configure
 "roles"=>array(
    "name"=>"roles",
    "actions"=>array()
 )
 ```

```action configure
"{Controller}"=>array(
        "name"=>"{Controller}",
        "actions"=>array(
            "edit{Table}"=>array(
                "Type"=>"simple"//"AJAX"
                ,'Role'=>"edit"//lister | consulter | gestion | delete | save
                ,"view"=>array(
                  "view"=>true
                  ,"layout"=>false
                  ,"pages"=>array(
                        "edit"=>"edit{Table}"
                        ,"lister"=>"lister{Table}"
                        //,"id"=>"id{Table}"
                      )
                )
                ,"activity"=>"edit"
                ,"form"=>"form{Table}"
                ,"model"=>array(
                    "table"=>"{Table}"
                )
            ),
        )
```

  

## Running Unit Tests
 

Once testing support is present, you can run the tests using:

```bash
$ ./vendor/bin/phpunit
```
   
## Web server setup

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName litelleframeworkapp.localhost
    DocumentRoot /path/to/litelleframeworkapp/public
    <Directory /path/to/litelleframeworkapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```

### Nginx setup

To setup nginx, open your `/path/to/nginx/nginx.conf` and add an
[include directive](http://nginx.org/en/docs/ngx_core_module.html#include) below
into `http` block if it does not already exist:

```nginx
http {
    # ...
    include sites-enabled/*.conf;
}
```
 
it should look something like below:

```nginx
server {
    listen       80;
    server_name  litelleframeworkapp.localhost;
    root         /path/to/litelleframeworkapp/public;

    location / {
        index index.php;
        try_files $uri $uri/ @php;
    }

    location @php {
        # Pass the PHP requests to FastCGI server (php-fpm) on 127.0.0.1:9000
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_param  SCRIPT_FILENAME /path/to/litelleframeworkapp/public/index.php;
        include fastcgi_params;
    }
} 
 