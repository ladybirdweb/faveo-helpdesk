FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    curl git

WORKDIR /var/www

#make it running
ENTRYPOINT ["tail", "-f", "/dev/null"]
