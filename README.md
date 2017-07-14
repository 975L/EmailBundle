EmailBundle
===========

EmailBundle does the following:

- Stores email in a database,
- Sends email using SwiftMailer.

[Email Bundle dedicated web page](https://975l.com/en/pages/email-bundle).

Bundle installation
===================

Step 1: Download the Bundle
---------------------------
Add the following to your `composer.json > require section`
```
"require": {
    ...
    "c975L/email-bundle": "1.*"
},
```
Then open a command console, enter your project directory and update composer, by executing the following command, to download the latest stable version of this bundle:

```bash
$ composer update
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

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
Then, in the `app/config.yml` file of your project, define data for SwiftMailer, Doctrine and `sentFrom` as the email address used to send emails.

```yml
#Swiftmailer Configuration
swiftmailer:
    transport: "%mailer_transport%"
    host:      "%mailer_host%"
    username:  "%mailer_user%"
    password:  "%mailer_password%"
    spool:     { type: memory }
    auth_mode:  login
    port:       587

#Doctrine Configuration
doctrine:
    dbal:
        driver:   pdo_mysql
        host:     "%database_host%"
        port:     "%database_port%"
        dbname:   "%database_name%"
        user:     "%database_user%"
        password: "%database_password%"
        charset:  UTF8
    orm:
        auto_generate_proxy_classes: "%kernel.debug%"
        naming_strategy: doctrine.orm.naming_strategy.underscore
        auto_mapping: true

#EmailBundle
c975_l_email:
    sentFrom: 'contact@example.com'
```
Then add the correct values in the `parameters.yml`.

```yml
parameters:
    database_host: localhost
    database_port: 80
    database_name: database_name
    database_user: databse_user
    database_password: database_password
    mailer_transport: smtp
    mailer_host: mail.example.com
    mailer_user: contact@example.com
    mailer_password: email_password
```

Step 4: Create MySql table
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
            'mailer' => $this->get('mailer'),
            'subject' => 'subjectEmail',
            'sentFrom' => $this->getParameter('c975_l_email.sentFrom'),
            'sentTo' => 'contact@example.com',
            'sentCc' => 'contact@example.com', //optional
            'sentBcc' => 'contact@example.com', //optional
            'replyTo' => 'contact@example.com', //optional
            'body' => $body,
            'ip' => $request->getClientIp(), //optional
            );

        //Sends email
        $emailService = $this->get(\c975L\EmailBundle\Service\EmailService::class);
        $emailService->send($emailData);

        // ...
    }
}
```
