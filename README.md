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
        user_logs:
            title:  Logs
            icon:   fas fa-history
            submenu:
                log_session:     { title: Sessioni,  route: kikwik_admin_user_log_session }
                log_request:     { title: Dettagli,  route: kikwik_admin_user_log_request }        
```