# OData to OpenAPI converter

Website to convert OData specification to OpenAPI. The conversion will be done
with the help of `axonivy/builder-containers:odata-converter`. Because the
conversion can be a long running process this will be processed asynchron with a
directory watcher.

## Install

1) install docker and docker-compose

2) set file permission for data directory

        mkdir -p /opt/data/input
        mkdir -p /opt/data/output
        sudo chown -R 1000:1000 /opt/data 

3) start docker compose

        git clone https://github.com/axonivy/odata-converter
        docker-compose up -d
        docker-compose exec web composer install

4) install incron to watch for new files
        
        sudo apt-get install incron
        echo "root" | sudo tee -a /etc/incron.allow
        sudo incrontab -e
        /opt/data/input IN_CREATE /opt/odata-converter/scripts/convert-job.sh $@ $#
