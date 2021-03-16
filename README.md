# OData to Open API converter

## Data Layout

/data
  /odata2-input
  /odata2-output
  /odata4-input
  /odata4-output


## Install


1)
Install docker and docker-compose.


2)
  git clone https://github.com/axonivy/odata-converter

  docker-compose up -d
  docker-compose exec web composer install

  file permission for data directory


3)

sudo apt-get install incron
echo "ubuntu" | sudo tee -a /etc/incron.allow
incrontab -e
/opt/data/input IN_CREATE /opt/odata-converter/scripts/convert-job.sh $@ $#
mkdir /opt/data/output



/opt/data/input IN_CREATE       echo "$@ $# $% $&"
#/opt/data/input        IN_CREATE       /opt/odata-converter/scripts/convert-job.sh $@ $#
