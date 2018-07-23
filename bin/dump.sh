#!/usr/bin/env bash

# The symfony project root dir
ROOT_DIR=$(pwd $(dirname $(dirname ${BASH_SOURCE[0]})))

# Import env vars
source ${ROOT_DIR}/.env

DATE=`date +%Y%m%d%H%M%S`

if [[ ${DATABASE_URL} =~ ^mysql://([A-Za-z_]*):([A-Za-z_]*)@([0-9A-Za-z\.]*):([0-9]*)/([0-9A-Za-z_]*) ]] ; then
    USERNAME=${BASH_REMATCH[1]}
    PASSWORD=${BASH_REMATCH[2]}
    HOST=${BASH_REMATCH[3]}
    PORT=${BASH_REMATCH[4]}
    DB_NAME=${BASH_REMATCH[5]}

    if [ ! -d "${DUMPDIR}" ]; then
        mkdir -p ${DUMPDIR}
    fi

    OUTFILE=${DUMPDIR}/${DATE}.sql

    ${MYSQLDUMP} --host=${HOST} --port=${PORT} --user=${USERNAME} --password=${PASSWORD} ${DB_NAME} > ${OUTFILE}
fi
