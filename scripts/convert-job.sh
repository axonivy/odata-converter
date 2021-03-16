#!/bin/bash

# sudo apt install incron

file=$1/$2


#m:DataServiceVersion="2.0"

log=/home/als/workspaces/php/odata-converter/src/data/$2.log
echo Start converting $2 > $log

if grep -q DataServiceVersion= "$file"; then
  name=$(basename $file)
  docker run -v /home/als/workspaces/php/odata-converter/src/data:/tmp/work axonivy/build-container:odata-converter-2 -p /tmp/work/$name -t /tmp/work/result-$name >> $log
fi
