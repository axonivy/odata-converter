#!/bin/bash

file=$1/$2

#m:DataServiceVersion="2.0"

log=/opt/data/output/$2.log
echo Start converting $2 > $log

if grep -q DataServiceVersion= "$file"; then
  echo OData version 2 detected $2 >> $log

  name=$(basename $file)
  nameNoExtension=$(echo "$name" | cut -f 1 -d '.')

  docker run -u 1000 -v /opt/data:/tmp/work axonivy/build-container:odata-converter-2 -p /tmp/work/input/$name -t /tmp/work/output/$nameNoExtension.json &>> $log
fi
