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

You also have the possibility to create another table to archive emails using a MySql Procedure, see in `/Resources/sql/emails.sql` to uncomment the creation of these.

How to use
----------
Create a Twig template i.e. `app/Resources/views/emails/description.html.twig` with this content:

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

class AnyController extends Controller
{
    public function anyFunction(Request $request)
    {
        // ...

        //Build your email
        $body = $this->renderView('emails/description.html.twig', array(
            //Data needed for your template
            ));
        $emailData = array(
            'subject' => 'YOUR_SUBJECT',
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
        $emailSent = $emailService->send($emailData, [saveDatabase ? true|false(default)]);

        //You can test if email has been sent
        if ($emailSent === true) {
            //Do what you need...
        } else {
            //Do what you need...
        }

        // ...
    }
}
```

Email messages
--------------
To avoid too much overiding and keep it simple to use, it's a bit tricky to understand the setup.

You **must** override `Resources/views/emails/layout.html.twig` with `app/Resources/c975LEmailBundle/views/emails/layout.html.twig` as `@c975lEmail/emails/layout.html.twig` is an empty shell extended by other bundles (see example above).

Insert the following code in the overriden file `app/Resources/c975LEmailBundle/views/emails/layout.html.twig`:

EmailBundle use the following variables to display information through the email template. If you don't set them, they will be ignored.
```twig
{% extends "@c975LEmail/emails/fullLayout.html.twig" %}

{% set site = 'YOUR_SITE_NAME' %}
{% set email = 'THE_EMAIL_YOU_SEND_FROM' %} {# Should be the same as the one defined in config.yml > sentFrom #}
{% set author = 'AUTHOR' %}
{% set firstOnlineDate = 'YYYY-MM-DD' %}
{% set logo = absolute_url(asset('images/og-image.png')) %}

{# If you want to wrap the email content with a special div, class, etc., just override the block like this #}
{% block content %}
    <div class="container">
        {% block hello %}
            {{ parent() }}
        {% endblock %}
        {% block email_content %}
        {% endblock %}
    </div>
{% endblock %}
```

Overide a block
---------------
You can overide any block in the template, to do so, simply add the following in your `app/Resources/c975LEmailBundle/views/emails/layout.html.twig`, you can still use the `{{ parent() }}` Twig function:
```twig
{% block noSpam %}
    {# YOUR_OWN_TEXT #}
{% endblock %}
```
Have a look at `Resources/views/emails/fullLayout.html.twig`, to see all available blocks.

Disable a block
---------------
To disable a block, simply add the following in your `app/Resources/c975LEmailBundle/views/emails/layout.html.twig`:
```twig
{% block logo %}
{% endblock %}
```
Have a look at `Resources/views/layout.html.twig`, to see all available blocks.

Footer template
---------------
You should override the template `Resources/views/emails/footer.html.twig` in your `app/Resources/c975LEmailBundle/views/emails/footer.html.twig` and indicate there all the data you need to display at the bottom of sent email.

Use of dashboard and display messages sent
------------------------------------------
You can see the emails sent via the dashboard.

For this, simply, create the following structure `app/Resources/c975LEmailBundle/views/` in your app and then duplicate the file `layout.html.twig` in it, to override the existing Bundle files, then apply your needed changes.

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
