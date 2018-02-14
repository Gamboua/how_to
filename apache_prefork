# Ajuste no Apache2 - prefork

Obter quantidade de memória média usada pelos processos no apache2:
```sh
ps aux | grep 'apache2' | awk '{print $6/1024;}' | awk '{avg += ($1 - avg) / NR;} END {print avg " MB";}'
```

- Divimos a média pela quantidade de memória no servidor para ter o MaxClient. 
Levar em consideração que o servidor usa memória para outras tarefas também.

- Uma forma de calcular os outro parâmetros:
```sh
<IfModule mpm_prefork_module>
   	StartServers          30% of MaxClients
   	MinSpareServers       5% of MaxClients
   	MaxSpareServers       10% of MaxClients
   	MaxClients            avg. mem. /  total mem.
    ServerLimit           = MaxClients
   	MaxRequestsPerChild   10000 ???
</IfModule>
```

# Habilitar o server-status
- Adicionar em ***mods-available/status.conf***
<Location /server-status>
     SetHandler server-status
     Require local
     Require ip 0.0.0.0
</Location>

- Ativar o parâmetro ExtendedStatus em ***apache2.conf***
```sh
ExtendedStatus On
```

- Script para analisar o webserver
```sh
curl -sL https://raw.githubusercontent.com/richardforth/apache2buddy/master/apache2buddy.pl | perl
```
