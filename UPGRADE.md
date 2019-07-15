# UPGRADE

v2.0.x > v2.1
-------------
- As the parameters used in the template for the email are set via c975L/ConfigBundle, you don't need anymore to override `Resources/views/emails/layout.html.twig` with your `app/Resources/c975LEmailBundle/views/emails/layout.html.twig`, so you can delete it, unless you want to override/disable a block, refer to `README.md` for this.

v1.x > v2.x
-----------
When upgrading from v1.x to v2.x you should(must) do the following if they apply to your case:

- The parameters entered in `config.yml` are not used anymore as they are managed by c975L/ConfigBundle, so you can delete them.
- As the parameters are not in `config.yml`, we can't access them via `$this[->container]->getParameter()`, especially if you were using `c975_l_email.sentFrom`, so you have to replace `$this->getParameter('c975_l_email.sentFrom')` by `$configService->getParameter('c975LEmail.sentFrom')`, where `$configService` is the injection of `c975L\ConfigBundle\Service\ConfigServiceInterface`, or your can use the shortcut `$emailService->getParameter('c975LPayment.XXX')` where `$emailService` is the injection of `c975L\EmailBundle\Service\EmailServiceInterface`.
- Before the first use of parameters, you **MUST** use the console command `php bin/console config:create` to create the config files with default data.
