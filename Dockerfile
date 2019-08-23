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

COPY simplesamlphp /var/simplesamlphp

COPY saml /etc/nginx/sites-available/saml

RUN ln -s /etc/nginx/sites-available/saml /etc/nginx/sites-enabled/saml
