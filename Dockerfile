FROM scuolaonlineservice/sample-scuola

RUN apt-get install -y curl\
  #php7.2-date\
  php7.2-dom\
  #php7.2-hash\
  #php7.2-libxml\
  #php7.2-openssl\
  #php7.2-pcre\
  #php7.2-SPL\
  #php7.2-zlib\
  php7.2-mbstring\
  vim

RUN wget -qO- https://simplesamlphp.org/download?latest | tar -xz -C /var &&\
  mv /var/simplesamlphp-* /var/simplesamlphp

COPY nginx /home/nginx

#RUN sed -i '$ d' /home/nginx &&\
#   echo\
#   "location ^~ /simplesaml {\
#       alias /var/simplesamlphp/www;\
#       location ~ \.php(/|$) {\
#         root             /var/simplesamlphp/www;\
#         fastcgi_pass     unix:/run/php/php7.2-fpm.sock;\
#         fastcgi_index    index.php;\
#         fastcgi_param    SCRIPT_FILENAME /var/simplesamlphp/www\$fastcgi_script_name;\
#         fastcgi_split_path_info ^(.+?\.php)(/.*)$;\
#         fastcgi_param    PATH_INFO \$fastcgi_path_info;\
#         include          fastcgi_params;\
#       }\
#     }\
#   }" >> /home/nginx
#
