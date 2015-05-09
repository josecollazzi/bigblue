# Default Apache virtualhost template

<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot {{ doc_root }}

    SetEnv          SYMFONY__DATABASE__DRIVER pdo_mysql
    SetEnv          SYMFONY__DATABASE__USER {{ mysql.user }}
    SetEnv          SYMFONY__DATABASE__PASSWORD {{ mysql.password }}
    SetEnv          SYMFONY__DATABASE__NAME {{ mysql.database }}
    SetEnv          SYMFONY__DATABASE__HOST {{ localhost }}
    SetEnv          SYMFONY__DATABASE__DRIVER {{ mysql.driver }}

{% set servernames = servername.split() %}
{% for servername in servernames %}
{% if loop.first %}
    ServerName {{ servername }}
{% else %}
    ServerAlias {{ servername }}
{% endif %}
{% endfor %}

    <Directory {{ doc_root }}>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
