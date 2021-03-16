#!/bin/bash

file=$1/$2

filename=$(basename -- "$file")
extension="${filename##*.}"

# can only convert xml (attention do never process *.tmp files)
if [ "$extension" != "xml" ]; then
  exit
fi

#m:DataServiceVersion="2.0"

log=/opt/data/output/$2.log
echo Start converting $2 > $log

if grep -q DataServiceVersion= "$file"; then
  echo OData version 2 detected >> $log

  name=$(basename $file)
  nameNoExtension=$(echo "$name" | cut -f 1 -d '.')

  docker run -u 1000 -v /opt/data:/tmp/work axonivy/build-container:odata-converter-2 -p /tmp/work/input/$name -t /tmp/work/output/$nameNoExtension.json.tmp &>> $log
  mv /opt/data/output/$nameNoExtension.json.tmp /opt/data/output/$nameNoExtension.json

else
  echo OData version 3/4 detected >> $log

  name=$(basename $file)
  nameNoExtension=$(echo "$name" | cut -f 1 -d '.')

  docker run -u 1000 -v /opt/data:/tmp/work axonivy/build-container:odata-converter-4 -p /tmp/work/input/$name -t /tmp/work/output/$nameNoExtension.json.tmp &>> $log
  mv /opt/data/output/$nameNoExtension.json.tmp /opt/data/output/$nameNoExtension.json
fi
