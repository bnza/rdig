FROM node:8-alpine

ARG GID
ARG UID

WORKDIR /var/www

RUN if [ "$UID" = "1000" ]; then \
        USER=node; \
     else \
        USER=rdig && \
        adduser --disabled-password --gecos '' -u $UID -g $GID $USER; \
    fi

USER $USER

RUN yarn install

#CMD yarn install && yarn run encore dev && tail -f /dev/null
CMD tail -f /dev/null