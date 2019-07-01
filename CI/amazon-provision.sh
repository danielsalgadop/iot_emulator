#!/usr/bin/env bash
ssh -i "socialaccesscontroller-paris.pem" ubuntu@ec2-35-180-120-192.eu-west-3.compute.amazonaws.com

ssh -i ~/dev/socialaccesscontroller-paris.pem ubuntu@ec2-35-180-120-192.eu-west-3.compute.amazonaws.com sudo apt-get update; sudo apt-get install mysql-server apache2 php php-mysql php7.2-xml npm libapache2-mod-php php-curl composer -y;


sudo cp /etc/mysql/debian.cnf /home/ubuntu/.my.cnf; sudo chown ubuntu:ubuntu /home/ubuntu/.my.cnf



ssh -i ~/dev/socialaccesscontroller-paris.pem ubuntu@ec2-35-180-120-192.eu-west-3.compute.amazonaws.com cd /var/www/; sudo mkdir -p /var/www/temp; sudo chown ubuntu:ubuntu /var/www/temp; cd /var/www/temp/; git clone https://github.com/danielsalgadop/iot_emulator.git; cd /var/www; sudo mv  /var/www/temp/iot_emulator /var/www;  sudo rm -rf /var/www/temp

mysql -D mysql -e "CREATE USER 'iot'@'localhost' IDENTIFIED BY 'iot'; GRANT ALL PRIVILEGES ON iot.* TO 'iot'@'localhost'; FLUSH PRIVILEGES"

cd /var/www/iot_emulator; composer install; php bin/console doctrine:database:create; php bin/console doctrine:schema:create;



sudo cp /var/www/iot_emulator/CI/nginx_conf/prod/iot /etc/nginx/sites-available/

sudo ln -s /etc/nginx/sites-available/iot /etc/nginx/sites-enabled/
