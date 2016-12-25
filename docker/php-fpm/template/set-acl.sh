#!/bin/sh
setfacl -R -m u:"www-data":rwX -m u:`whoami`:rwX /usr/share/nginx/granty/var
setfacl -dR -m u:"www-data":rwX -m u:`whoami`:rwX /usr/share/nginx/granty/var
