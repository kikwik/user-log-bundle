KikwikUserLogBundle
======================

Logging authenticated user actions for symfony 5


Installation
------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require kikwik/user-log-bundle
```

Configuration
-------------

```yaml
kikwik_admin:
    admins:
        user_log_session:
            entityClass: Kikwik\UserLogBundle\Entity\SessionLog
            singularName: log sessione
            pluralName: log sessioni
            gender: male
            fields:
                user:             { label: Utente }
                sessionId:        { label: Identificativo }
                remoteIp:         { label: IP utente }
                createdAt:        { label: Prima richiesta }
                updatedAt:        { label: Ultima richiesta }
                requestLogs:      { label: Richieste, displayType: collectionList }
                requestLogsCount: { label: Richieste }
                duration:         { label: Durata }
            collection:
                display: [ user, sessionId, remoteIp, createdAt, updatedAt, requestLogsCount, duration ]
                export: [ user, sessionId, remoteIp, createdAt, updatedAt, requestLogsCount, duration ]
                actions:
                    new:  { enabled: false }
            object:
                display: [ user, sessionId, remoteIp, createdAt, updatedAt, requestLogs, duration ]
                actions:
                    edit: { enabled: false }
                    delete: { enabled: false }
        user_log_request:
            entityClass: Kikwik\UserLogBundle\Entity\RequestLog
            singularName: log richiesta
            pluralName: log richieste
            gender: male
            fields:
                sessionId:        { label: Identificativo }
                dataHtml:         { label: Parametri }
            collection:
                display: [ sessionId, action, method, pathInfo, dataHtml, createdAt ]
                actions:
                    new:  { enabled: false }
            object:
                actions:
                    edit: { enabled: false }
                    delete: { enabled: false }
```