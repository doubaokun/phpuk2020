FROM php:7.4.2-cli

RUN apt-get update && apt-get install vim -y && \
    apt-get install openssl -y && \
    apt-get install libssl-dev -y && \
    apt-get install wget -y && \
    apt-get install git -y && \
    apt-get install procps -y && \
    apt-get install htop -y && \
    apt-get install unzip -y && \
    apt-get install aha -y

RUN wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.2/dumb-init_1.2.2_amd64
RUN chmod +x /usr/local/bin/dumb-init

RUN apt-get autoremove -y && rm -rf /var/lib/apt/lists/*

RUN cd /tmp && git clone https://github.com/swoole/swoole-src.git && \
    cd swoole-src  && \
    git checkout v4.4.15 && \
    phpize && \
    ./configure  --enable-openssl --enable-swoole-debug && \
    make && make install

RUN rm -rf /tmp/swoole-src

RUN touch /usr/local/etc/php/conf.d/swoole.ini && \
    echo 'extension=swoole.so' > /usr/local/etc/php/conf.d/swoole.ini

ENTRYPOINT ["/usr/local/bin/dumb-init", "--", "php"]
