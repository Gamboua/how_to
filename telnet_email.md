# Teste de envio com TELNET

Informe o host do servidor de e-mail
```sh
$ telnet mail.server.com 25
```

Inicie a conversa com o servidor
```sh
EHLO mail.server.com
```

> Os próximos 3 passos só precisam ser feitos caso 
haja autenticação do serviço.

```sh
AUTH LOGIN
```

Insira o seu login em **base64**
```sh
bWV1bG9naW4=
```

Insira a sua senha em **base64**
```sh
bWluaGFzZW5oYQ==
```

Informe o remetente da mensagem
```sh
MAIL FROM: <mailfrom@server.com>
```

Informe o destinatário da mensagem
```sh
RCPT TO: <mailto@anotherserver.com>
```

Digite o comando **DATA** e dê **ENTER**. Insira sua mensagem e, quando acabar, digite **PONTO (.)**.
```sh
DATA
SUA MENSAGEM AQUI
.
```

Um exemplo abaixo:

```sh
telnet mail.server.com 587
Trying 191.252.01.01...
Connected to mail.server.com.
Escape character is '^]'.
220-iuri0115.hospedagemdesites.ws ESMTP Exim 4.89 #1 Thu, 19 Oct 2017 17:08:55 -0200 
220-We do not authorize the use of this system to transport unsolicited, 
220 and/or bulk e-mail.
EHLO mail.server.com
250-iuri0115.hospedagemdesites.ws Hello mail.server.com [186.23.23.41]
250-SIZE 52428800
250-8BITMIME
250-PIPELINING
250-AUTH PLAIN LOGIN
250-STARTTLS
250 HELP
AUTH LOGIN
334 VXNlcm5hbWU6
bWV1bG9naW4=
334 UGFzc3dvcmQ6
bWluaGFzZW5oYQ==
235 Authentication succeeded
mail from: <mailfrom@server.com>
250 OK
rcpt to: <mailto@anotherserver.com>
250 Accepted
data
354 Enter message, ending with "." on a line by itself
BODY
ANOTHER BODY
.
250 OK id=1e5GDN-0005ZQ-5I
```