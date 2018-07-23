#!/usr/bin/env bash

# The symfony project root dir
ROOT_DIR=$(pwd $(dirname $(dirname ${BASH_SOURCE[0]})))

# Import env vars
source ${ROOT_DIR}/.env

YEAR=`date +%Y`
MONTH=`date +%m`
DATE=${YEAR}${MONTH}`date +%d%H%M%S`

# get temp dir
TEMP_ERR_FILE=$(mktemp -t rdig.dump.XXXX)
TEMP_DIR=$(dirname ${TEMP_ERR_FILE})
TEMP_DUMP_DIR=${TEMP_DIR}/rdig/dumps
rm ${TEMP_ERR_FILE}

if [ ! -d "${TEMP_DUMP_DIR}" ]; then
    mkdir -p ${TEMP_DUMP_DIR}
fi

TEMP_DUMP_FILE=${TEMP_DUMP_DIR}/${DATE}.sql
DEST_DUMP_DIR=${DUMPDIR}/${YEAR}/${MONTH}
DEST_LOG_FILE=${DUMPDIR}/cron.log

# create base dump dir (e.g. ~/dumps/)
if [ ! -d "${DUMPDIR}" ]; then
    mkdir -p ${DUMPDIR}
fi

echo "<<<[${DATE}]" >> ${DEST_LOG_FILE}

if [[ ${DATABASE_URL} =~ ^mysql://([A-Za-z_]*):([A-Za-z_]*)@([0-9A-Za-z\.]*):([0-9]*)/([0-9A-Za-z_]*) ]] ; then
    # extract atom data from env DATABASE_URL
    USERNAME=${BASH_REMATCH[1]}
    PASSWORD=${BASH_REMATCH[2]}
    HOST=${BASH_REMATCH[3]}
    PORT=${BASH_REMATCH[4]}
    DB_NAME=${BASH_REMATCH[5]}

    # execute dump
    ${MYSQLDUMP} --host=${HOST} --port=${PORT} --user=${USERNAME} --password=${PASSWORD} ${DB_NAME} > ${TEMP_DUMP_FILE} 2>> ${TEMP_ERR_FILE}

    # create dump dir (e.g. ~/dumps/2018/07)
    if [ ! -d "${DEST_DUMP_DIR}" ]; then
        mkdir -p ${DEST_DUMP_DIR} 2>> ${TEMP_ERR_FILE}
    fi

    # zip sql dump
    # -q quiet
    zip -jq ${DEST_DUMP_DIR}/${DATE} ${TEMP_DUMP_FILE} 2>> ${TEMP_ERR_FILE}

    # remove sql file
    rm ${TEMP_DUMP_FILE}
fi
cat ${TEMP_ERR_FILE} >> ${DEST_LOG_FILE}
echo "[${DATE}]>>>" >> ${DEST_LOG_FILE}
