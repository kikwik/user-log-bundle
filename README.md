KikwikUserLogBundle
======================

Logging authenticated user actions for symfony 5


Installation
------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
#!/bin/bash
composer require kikwik/user-log-bundle
```

then make migration and migrate

```console
#!/bin/bash
php bin/console make:migration
php bin/console doctrine:migration:migrate
```

Configuration
-------------

```yaml
kikwik_user_log:
    enable_admin: false  # default is true
    enable_log: false  # default is true
```