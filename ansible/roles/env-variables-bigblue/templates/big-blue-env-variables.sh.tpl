export SYMFONY__DATABASE__USER={{ mysql.user }}
export SYMFONY__DATABASE__PASSWORD={{ mysql.password }} 
export SYMFONY__DATABASE__NAME={{ mysql.database }} 
export SYMFONY__DATABASE__HOST=127.0.0.1 
export SYMFONY__DATABASE__DRIVER=pdo_mysql
 export SYMFONY_ENV=prod
