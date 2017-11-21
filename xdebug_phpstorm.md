# XDebug com PHPStorm e php 7.0

No host da aplicação. Faça a instalação do xdebug:
```sh
$ sudo apt install php-xdebug
```

Habilite o módulo do ***xdebug***:
```sh
$ sudo phpenmod xdebug
```

Habilite a exbição de erros no PHP:

```sh
$ sudo vim php.ini
    + display_errors=On
```

Crie o arquivo ***20-xdebug.ini***:
```sh
$ sudo vim /etc/php/7.0/fpm/conf.d/20-xdebug.ini
```

Substitua ***XXX.XXX.XXX.XXX*** pelo IP do host da aplicação:
```sh
xdebug.remote_addr_header=XXX.XXX.XXX.XXX
xdebug.profiler_enable_trigger=1
xdebug.remote_connect_back=1
xdebug.remote_enable=1
xdebug.profiler_enable_trigger_value=1
xdebug.remote_connect_back=1
xdebug.remote_log=/tmp/dbg.log
```

Crie um arquivo chamado ***xdebug_param.conf***:

```sh
$ vim /etc/nginx/xdebug_param.conf
```

Substitua ***XXX.XXX.XXX.XXX*** pelo IP do host da aplicação:
```sh
fastcgi_param  DEBUG_HOST_IP  XXX.XXX.XXX.XXX ;
```

Config PHPStorm:

* Abra o PHPStorm
* Vá em ***File*** > ***Settings***
* Vá em ***Language & Frameworks*** > ***PHP*** > ***Debug***
* Clique em ***Start Listening***
* Feche a Janela

Abra o site pelo browser e insera no final da Url que quer depurar: 
```sh
url?XDEBUG_SESSION_START=session_name
```

O ***session_name*** é apenas um nome para identificar a sessão aberta. Pode ser qualquer coisa.
Abra o PHPStorm e uma janela pedindo para informar o local do arquivo irá aparecer.
