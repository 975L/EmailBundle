EmailBundle
===========

EmailBundle does the following:

- Stores email in a database as an option,
- Sends email using  [SwiftMailer](https://github.com/symfony/swiftmailer-bundle),
- Allows user with good ROLE to see emails sent,
- Defines a template for emails that should be overriden to inegrate fully with website,
- Allows to attach one or multiple files.

[Email Bundle dedicated web page](https://975l.com/en/pages/email-bundle).

Bundle installation
===================

Step 1: Download the Bundle
---------------------------
Use [Composer](https://getcomposer.org) to install the library
```bash
    composer require c975l/email-bundle
```

Step 2: Enable the Bundles
--------------------------
Then, enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new c975L\EmailBundle\c975LEmailBundle(),
        ];
    }
}
```

Step 3: Configure the Bundles
-----------------------------
Check [Swiftmailer](https://github.com/symfony/swiftmailer-bundle) and [Doctrine](https://github.com/doctrine/DoctrineBundle) for their specific configuration

Then, in the `app/config.yml` file of your project, define the following:

```yml
#EmailBundle
c975_l_email:
    #Email address used to send emails
    sentFrom: 'contact@example.com'
    #User's role needed to enable access to view emails sent
    roleNeeded: 'ROLE_ADMIN'
```

Step 4: Enable the Routes
-------------------------
Then, enable the routes by adding them to the `app/config/routing.yml` file of your project:

```yml
c975_l_email:
    resource: "@c975LEmailBundle/Controller/"
    type:     annotation
    prefix:   /
```

Step 5: Create MySql table
--------------------------
Use `/Resources/sql/emails.sql` to create the table `emails`. The `DROP TABLE` is commented to avoid dropping by mistake.

You also have the possibility to create another table to archive emails using a MySql Procedure, see in `/Resources/sql/emails.sql` to un-comment the creation of these.

How to use
----------
In your Controller file add this code to create, insert in DB and send your email:
```php
<?php
// src/Controller/AnyController.php

class AnyController extends Controller
{
    public function anyFunction(Request $request)
    {
        // ...

        //Build your email
        $bodyEmail = 'emails/XXX.html.twig';
        $bodyData = array(
            //Whatever data needed for the template
            );
        $body = $this->renderView($bodyEmail, $bodyData);
        $emailData = array(
            'subject' => 'subjectEmail',
            'sentFrom' => $this->getParameter('c975_l_email.sentFrom'),
            'sentTo' => 'contact@example.com',
            'sentCc' => 'contact@example.com', //optional
            'sentBcc' => 'contact@example.com', //optional
            'replyTo' => 'contact@example.com', //optional
            'body' => $body,
            'attach' => array(
                array($data, $filename, $contentType)
                ), //optional
            'ip' => $request->getClientIp(), //optional
            );

        //Sends email
        $emailService = $this->get(\c975L\EmailBundle\Service\EmailService::class);
        $emailService->send($emailData, [saveDatabase ? true|false(default)]);

        // ...
    }
}
```

Use of dashboard and display messages sent
------------------------------------------
You can see the emails sent via the dashboard.
It is strongly recommended to use the [Override Templates from Third-Party Bundles feature](http://symfony.com/doc/current/templating/overriding.html) to integrate fully with your site.

For this, simply, create the following structure `app/Resources/c975LEmailBundle/views/` in your app and then duplicate the files `layout.html.twig` and `emails/layout.html.twig` in it, to override the existing Bundle files, then apply your needed changes.

In `layout.html.twig` and `emails/layout.html.twig`, it will mainly consist to extend your layouts and define specific variables, i.e. :
```twig
{% extends 'layout.html.twig' %}
{# or extends 'emails/layout.html.twig' #}

{# Defines specific variables #}
{% set title = 'Email (' ~ title ~ ')' %}

{% block content %}
    <div class="container">
        {% block email_content %}
        {% endblock %}
    </div>
{% endblock %}
```
