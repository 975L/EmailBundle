EmailBundle
===========

EmailBundle does the following:

- Stores email in a database,
- Sends email using SwiftMailer.

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

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new c975L\EmailBundle\c975LEmailBundle(),
        ];

        // ...
    }

    // ...
}
```

Step 3: Configure the Bundle
----------------------------

Then, in the `app/config.yml` file of your project, define `sentFrom` as the email address used to send emails.

```yml
#app/config/config.yml

c975_l_email:
    sentFrom: 'contact@example.com'
```

Step 5: Create MySql tables
---------------------------

- Use `/Resources/sql/TableCreation.sql` to create the tables `emails`. The `DROP TABLE` is commented to avoid dropping by mistake.

Step 4: How to use
------------------
In your Controller file add this code to create, insert in DB and send your email:
```php
<?php
// src/Controller/XXXController.php

// ...
use c975L\EmailBundle\Entity\Email;

class XXXController extends Controller
{
    public function XXX(Request $request)
    {
        // ...
        //Gets the manager
        $em = $this->getDoctrine()->getManager();

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
            'ip' => $request->getClientIp(),
            );

        //Creates the object
        $email = new Email();

        //Calls all the setters for the data specified above
        $email->setDataFromArray($emailData);

        //Persists Email in DB
        $em->persist($email);
        $em->flush();

        //Sends email
        $email->send();
        // ...
    }

    // ...
}
```
