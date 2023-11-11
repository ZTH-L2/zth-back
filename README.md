# zth-back

### important ###
do not delet .env of .gitignore

### Usage ###

#### 1 ####
copy .env.example into a new .env file at the root of zth-backend (same level as .env.example)\
.env will contain your local code to your local database\
do not delet .env.example

#### 2 ####
dowload docker (and docker desktop)

#### 3 ####
open a terminal, go in zth-backend directory and type : \
$ docker compose up -d\
or
$ docker compose up\
this will allow you to have a local back : php, mysql db and phpmyadmin
to access the api : port 8080 : localhost:8080/public\ 
to access phpmyadmin : port 8001 : localhost:8001\

once you are finish do :\
if you used $ docker compose up :\
  ctrl + c\
  (you can also do "$ docker compose down" after)\
else:\
  $ docker compose down
