# UPGRADE

v1.x > v2.x
-----------
When upgrading from v1.x to v2.x you should(must) do the following if they apply to your case:

- The parameters entered in `config.yml` are not used anymore as they are managed by c975L/ConfigBundle, so you can delete them.
- As the parameters are not in `config.yml`, we can't access them via `$this[->container]->getParameter()`, especially if you were using `c975_l_email.sentFrom`, so you have to replace `'sentFrom' => $this->getParameter('c975_l_email.sentFrom'),` by `'sentFrom' => $emailService->getParameter('c975LEmail.sentFrom'),`, where `$emailService` is the injection of `EmailServiceInterface` and `getParameter()` a shortcut to c975L/ConfigBundle `ConfigServiceInterface > getParameter()`.
