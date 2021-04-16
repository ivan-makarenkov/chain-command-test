# Test task for ORO

The task description is here:
https://github.com/mbessolov/test-tasks/blob/master/7.md


To start:

```
sh docker-run.sh

sudo docker-compose exec php composer install
```
To run console command:
```
sudo docker-compose exec php php bin/console foo:hello
git init
sudo docker-compose exec php php bin/console bar:hi
```

To run tests:
```
sudo docker-compose exec php php bin/phpunit tests/
```
