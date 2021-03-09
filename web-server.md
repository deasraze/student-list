# Preparing web server
The application uses the FrontController design pattern, so all HTTP requests must be handled by a single PHP file.  
In this guide, you will find examples of configuring your web server to set the FrontController as the handler for all requests.

If you install the application on a local server, then change the hosts file to point the domain to your server.
- Linux: `/etc/hosts`
- Windows: `c:\Windows\System32\Drivers\etc\hosts`

Add the following lines:
```
127.0.0.1   students.loc
```

## Apache
```apache
 <VirtualHost *:80>
        ServerName students.loc
        DocumentRoot "/path/to/student-list/web"
        
        <Directory "/path/to/student-list/web">
            RewriteEngine on
            
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            
            RewriteRule . index.php

            DirectoryIndex index.php
            # Uncomment out the string if you are going to use .htaccess
            #AllowOverride All
            
            # Apache 2.4
            Require all granted
            
            ## Apache 2.2
            # Order allow,deny
            # Allow from all
        </Directory>
 </VirtualHost>
```
You can also create a file `.htaccess` in the `/path/to/student-list/web` folder to redirect all HTTP requests to the FrontController:
```apache
RewriteEngine on

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule . index.php
```
Make sure that `mod_rewrite` is installed with your Apache configuration. Also make sure that the `AllowOverride` directive is set to `All` in your host's settings.

## Nginx
```nginx
server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80;

        server_name students.loc;
        root        /path/to/student-list/web/;
        index       index.php;

        error_log /var/log/nginx/students.error.log;
        access_log /var/log/nginx/students.access.log;

        location / {
            try_files $uri $uri/ /index.php$is_args$args;
        }

        location ~ \.php$ {
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            try_files $uri =404;
        }
        
        location ~* /\. {
            deny all;
        }
    }
```
