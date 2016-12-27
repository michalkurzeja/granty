#!/bin/sh
setfacl -R -m u:"www-data":rwX -m u:`whoami`:rwX /usr/share/nginx/granty/var /usr/share/nginx/granty/web/upload
setfacl -dR -m u:"www-data":rwX -m u:`whoami`:rwX /usr/share/nginx/granty/var /usr/share/nginx/granty/web/upload
