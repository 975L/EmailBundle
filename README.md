# EmailBundle

EmailBundle does the following:

- Stores email in a database as an option,
- Sends email using [Symfony Mailer](https://github.com/symfony/mailer),
- Allows user with good ROLE to see emails sent,
- Defines a template for emails that should be overriden to integrate fully with website,
- Allows to attach one or multiple files.

[EmailBundle dedicated web page](https://975l.com/en/pages/email-bundle).

[EmailBundle API documentation](https://975l.com/apidoc/c975L/EmailBundle.html).

## Bundle installation

### Step 1: Download the Bundle

Use [Composer](https://getcomposer.org) to install the library

```bash
    composer require c975l/email-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new c975L\EmailBundle\c975LEmailBundle(),
        ];
    }
}
```

### Step 3: Configure the Bundle

Check dependencies for their configuration:

- [Symfony Mailer](https://github.com/symfony/mailer)
- [Doctrine](https://github.com/doctrine/DoctrineBundle)
- [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle)

c975LEmailBundle uses [c975L/ConfigBundle](https://github.com/975L/ConfigBundle) to manage configuration parameters. Use the Route "/email/config" with the proper user role to modify them.

**If you are NOT using Messenger** remember to disable the contents in config/packages/messenger.yaml or configure it properly.

### Step 4: Enable the Routes

Then, enable the routes by adding them to the `app/config/routing.yml` file of your project:

```yml
c975_l_email:
    resource: "@c975LEmailBundle/Controller/"
    type: annotation
    prefix: /
    #Multilingual website use the following
    #prefix: /{_locale}
    #defaults:   { _locale: '%locale%' }
    #requirements:
    #    _locale: en|fr|es
```

### Step 4: Create MySql table

You can use `php bin/console make:migration` to create the migration file as documented in [Symfony's Doctrine docs](https://symfony.com/doc/current/doctrine.html) OR use `/Resources/sql/emails.sql` to create the tables `emails` and `emails_archives`. The `DROP TABLE` are commented to avoid dropping by mistake. It will also create a stored procedure `sp_EmailsArchive()` and an event `e_monthly_archives` to archives emails older than 90 days. If you don't want to use this feature, just remove them.

### Step 5: Create MySql table

Have a look at the following links if you wish to use [Symfony Messenger](https://symfony.com/doc/current/messenger.html) to dispatch messages with [Doctrine](https://symfony.com/doc/current/messenger.html#doctrine-transport). If you want to use async you may also have a look at [this answer on StackOverflow](https://stackoverflow.com/a/73547566/6028808).

### How to use

Create a Twig template i.e. `templates/emails/description.html.twig` with this content:

```twig
{# If you want to use the template provided by c975LEmailBundle you have to extend its layout #}
{% extends "@c975LEmail/emails/layout.html.twig" %}

{% block email_content %}
    <p>
        {{ 'label.description'|trans }} : <strong>{{ object.description }}</strong>
    </p>
{# You can include files #}
    {% include 'YOUR_FILE_PATH' %}
{% endblock %}
```

Then in your Controller, add this code to create, insert in DB and send your email:

```php
<?php
// src/Controller/AnyController.php

use c975L\EmailBundle\Service\EmailServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnyController extends AbstractController
{
    public function anyFunction(Request $request, EmailServiceInterface $emailService)
    {
        // ...

        //Build your email
        $body = $this->renderView('emails/description.html.twig', array(
            //Data needed for your template
            ));
        $emailData = array(
            'subject' => 'YOUR_SUBJECT',
            'sentFrom' => $emailService->getParameter('c975LEmail.sentFrom'),
            'sentTo' => 'contact@example.com',
            'sentCc' => 'contact@example.com', //optional
            'sentBcc' => 'contact@example.com', //optional
            'replyTo' => 'contact@example.com', //optional
            'body' => $body,
            'attach' => array(
                array($filePath, $filename, $contentType),
            ), //optional
            'ip' => $request->getClientIp(), //optional
            );

        //Sends email
        $emailSent = $emailService->send($emailData, [saveDatabase ? true|false(default)]);

        //You can test if email has been sent
        if ($emailSent) {
            //Do what you need...
        } else {
            //Do what you need...
        }

        // ...
    }
}
```

### Email messages templates

If you wish to override/disable a block defined in the `fullLayout.html.twig` template, create your `templates/bundles/c975LEmailBundle/emails/layout.html.twig` and use the following code:

```twig
{% extends "@c975LEmail/emails/fullLayout.html.twig" %}

{# Overide a block #}
{% block noSpam %}
    {# You can also use {{ parent() }} #}
    {# YOUR_OWN_TEXT #}
{% endblock %}

{# Disable a block #}
{% block logo %}
{% endblock %}
```

Have a look at `templates/emails/fullLayout.html.twig`, to see all available blocks.

### Footer template

You should override the template `templates/emails/footer.html.twig` in your `templates/bundles/c975LEmailBundle/emails/footer.html.twig` and indicate there all the data you need to display at the bottom of sent email.

### Use of dashboard and display messages sent

You can see the emails sent via the dashboard.

For this, simply, create the following structure `templates/bundles/c975LEmailBundle/` in your app and then duplicate the file `layout.html.twig` in it, to override the existing Bundle files, then apply your needed changes.

In `layout.html.twig`, it will mainly consist to extend your layout and define specific variables, i.e. :

```twig
{% extends 'layout.html.twig' %}
{# or extends 'emails/layout.html.twig' #}

{# Defines specific variables #}
{% set title = 'Email (' ~ title ~ ')' %}

{% block content %}
    {% block email_content %}
    {% endblock %}
{% endblock %}
```

If this project **help you to reduce time to develop**, you can sponsor me via the "Sponsor" button at the top :)
