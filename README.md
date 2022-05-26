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
    sidebar:
        log:        { title: Log sessioni, route: kikwik_admin_user_log_session, icon: fas fa-history }
    
    admins:
        user_log_session:
            entityClass: Kikwik\UserLogBundle\Entity\SessionLog
            controller: Kikwik\UserLogBundle\Controller\Admin\SessionLogController
            singularName: log sessione
            pluralName: log sessioni
            gender: female
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
                sort: [ updatedAt, desc ]
                actions:
                    new:  { enabled: false }
            object:
                display: [ user, sessionId, remoteIp, createdAt, updatedAt, requestLogs, duration ]
                actions:
                    show: { emodal: false }
                    edit: { enabled: false }
                    delete: { enabled: false }
        user_log_request:
            entityClass: Kikwik\UserLogBundle\Entity\RequestLog
            singularName: log richiesta
            pluralName: log richieste
            gender: female
            fields:
                sessionLog:       { searchPath: sessionLog }
                sessionId:        { label: Identificativo }
                action:           { label: Controller }
                method:           { label: Metodo }
                pathInfo:         { label: Url }
                data:             { label: Parametri }
                dataHtml:         { label: Parametri }
                createdAt:        { label: Data richiesta }
            collection:
                display: [ sessionId, action, method, pathInfo, dataHtml, createdAt
                export: [ sessionId, action, method, pathInfo, data, createdAt ]
                filters: [ sessionLog ]    
                actions:
                    new:  { enabled: false }
            object:
                actions:
                    edit: { enabled: false }
                    delete: { enabled: false }
```