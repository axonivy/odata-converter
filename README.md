# OData to Open API converter

## Install

install docker and docker-compose

    git clone https://github.com/axonivy/odata-converter
    docker-compose up -d
    docker-compose exec web composer install

set file permission for data directory

    sudo apt-get install incron
    echo "ubuntu" | sudo tee -a /etc/incron.allow
    incrontab -e
    mkdir /opt/data/output
    /opt/data/input IN_CREATE /opt/odata-converter/scripts/convert-job.sh $@ $#
