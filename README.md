
# deployment-script

## To Use
```
php artisan vendor:publish --provider=Flyingcoder\Fakeforge\FakeforgeServiceProvider
```
transfer necesassary files
```
php artisan hooks:init
```
initiate scripts

### install go
update server before install
```
	sudo apt update -y && sudo apt upgrade -y
```
find out the latest version of go [here](https://golang.org/dl/)
```
	wget https://dl.google.com/go/go1.14.2.linux-amd64.tar.gz 
	sudo tar -C /usr/local -xzf go1.14.2.linux-amd64.tar.gz
	export PATH=$PATH:/usr/local/go/bin
```
then change the version in the above code then run it on the server

### install webhook
```
	go get github.com/adnanh/webhook
```
configure the deploy script and webhook
```
	mkdir ~/webhooks
	mkdir ~/webhooks/deployment-tutorial
	touch ~/webhooks/hooks.json
	touch ~/webhooks/deployment-tutorial/deploy.sh
	chmod +x ~/webhooks/deployment-tutorial/deploy.sh
```
edit hooks.json look for sample in hooks.json file

```
	/ubuntu/go/bin/webhook -hooks /ubuntu/webhooks/hooks.json -ip "000.000.000.000" -verbose
```
change "000.000.000.000" with your public IP 
if you are using AWS use the public DNS provided and edit the security add port 9000 tcp
it should say ready os or something

### run in the background
use supervisor to install
```
	sudo apt-get install supervisor
```
add file webhooks.conf on /etc/supervisor/conf.d/
```
	nano /etc/supervisor/conf.d/webhooks.conf
```
that will add a file and edit it

paste this
```
	[program:webhooks]
	command=bash -c "/home/ubuntu/go/bin/webhook -hooks /home/ubuntu/webhooks/hooks.json -ip '000.000.000.000' -verbose"
	redirect_stderr=true
	autostart=true
	autorestart=true
	user=ubuntu
	numprocs=1
	process_name=%(program_name)s_%(process_num)s
	stdout_logfile=/home/ubuntu/webhooks/supervisor.log
	environment=HOME="/home/ubuntu",USER="ubuntu"
```
change "ubuntu" for your user on the server
```
	sudo supervisorctl reread
	sudo supervisorctl update
	sudo supervisorctl start webhooks:*
```
set up command to start supervisor 

### notes:
prepare ssh key for bitbucket or github account
make sure server has access to the repo
make sure that qoutations are correct
don't use "~/"
