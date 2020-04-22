#!/bin/bash

sudo apt update -y && sudo apt upgrade -y

wget https://dl.google.com/go/go1.14.2.linux-amd64.tar.gz 
sudo tar -C /usr/local -xzf go1.14.2.linux-amd64.tar.gz
export PATH=$PATH:/usr/local/go/bin

go get github.com/adnanh/webhook

mkdir ~/webhooks
mkdir ~/webhooks/deployment
touch ~/webhooks/hooks.json
touch ~/webhooks/deployment/deploy.sh
chmod +x ~/webhooks/deployment/deploy.sh