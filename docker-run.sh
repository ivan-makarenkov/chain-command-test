#!/bin/sh
sudo systemctl stop mysql
sudo systemctl stop nginx
sudo docker stop $(sudo docker ps -aq)
sudo docker rm $(sudo docker ps -aq)
sudo docker-compose build
sudo docker-compose up -d