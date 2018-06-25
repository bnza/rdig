#!/bin/bash
I=1
for FILE in KH11 KH12 KH13 KH14 KH15 KH16 KH17 TG09 TG10 TH03 TH04 TH05 TH06 TH07 YU11 YU12 YU13 YU14 YU15 YU16 YU17
do
    for TYPE in O P S
    do
    FILENAME="$1"/"$FILE""$TYPE".csv
       if [ -f "$FILENAME" ]
       then
        echo '['$I'/21] => '$FILENAME
        bin/console rdig:job:csv:import:from_file "$FILENAME" --no-debug
        ((I+=1))
       fi
    done
done
