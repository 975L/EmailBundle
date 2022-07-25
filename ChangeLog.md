# Changelog

## v6.0

- Added note about messenger use (25/07/2022)

Upgrading from v5.x? **Check UPGRADE.md**

## v5.0.1

- Added return type for Voter (24/07/2022)

## v5.0

- Changed compatibility to Symfony 6 (24/07/2022)

Upgrading from v4.x? **Check UPGRADE.md**

## v4.0

- Changed `localizeddate` to `format_datetime` (11/10/2021)

Upgrading from v3.x? **Check UPGRADE.md**

## v3.4

- Removed versions constraints in composer (03/09/2021)

## v3.3.2.1

- Forgot ChangeLog.md (24/05/2021)

## v3.3.2

- Added dependency to "twig/extra-bundle" (24/05/2021)

## v3.3.1

- Cosmetic changes due to Codacy review (04/03/2020)

## v3.3

- Made use of twig/cssinliner-extra instead of twig/cssinliner-extension as abandonned (19/02/2020)
- Removed use of symplify/easy-coding-standard as abandonned (19/02/2020)

## v3.2

- Changed doctrine-bundle version (18/12/2019)

## v3.1

- Made use of apply spaceless (05/08/2019)

## v3.0.1

- Made use of KnpPagnigatorBundle v4 (15/07/2019)
- Drop support of Symfony 3.x (15/07/2019)

## v3.0

- Created branch 2.x (15/07/2019)
- Made use of `Symfony\Component\Mailer\MailerInterface` and `Symfony\Component\Mime\Email` (15/07/2019)

Upgrading from v2.x? **Check UPGRADE.md**

## v2.x

## v2.2.0.2

- Changed file rights (15/07/2019)

## v2.2.0.1

- Changed Github's author reference url (08/04/2019)

## v2.2

- Corrected type for `body` in Email Entity (15/02/2019)
- Modified Entity to use typehint (15/02/2019)
- Documented the possibility to use `php bin/console make:migration` (15/02/2019)
- Corrected missing Route use (15/02/2019)

## v2.1.2.2

- Modified Dependencyinjection rootNode to be not empty (13/02/2019)

## v2.1.2.1

- Added information about enabling event_scheduler (01/02/2019)

## v2.1.2

- Modified required versions in `composer.json` (25/12/2018)

## v2.1.1

- Updated `README.md` (02/09/2018)
- Corrected `logo` declaration (02/09/2018)
- Corrected `UPGRADE.md` for `php bin/console config:create` (03/12/2018)
- Added rector to composer dev part (23/12/2018)
- Modified required versions in composer (23/12/2018)

## v2.1

- Updated `README.md` (31/08/2018)
- Updated `UPGRADE.md` (01/09/2018)
- Updated composer.json (01/09/2018)
- Added common parameters in `bundle.yaml` (02/09/2018)
- Added use of common parameters (02/09/2018)

## v2.0.4

- Fixed `UPGRADE.md` (31/08/2018)
- Fixed `bundle.yaml` (31/08/2018)

## v2.0.3

- Updated `UPGRADE.md` (30/08/2018)
- Fixed Voter constants (31/08/2018)

## v2.0.2

- Added bundle root for Voter to keep unicity (30/08/2018)

## v2.0.1

- Added information in `UPGRADE.md` (30/08/2018)

## v2.0

- Created branch 1.x (30/08/2018)
- Made use of c975L/ConfigBundle (30/08/2018)
- Added Route `email_config` + link in toolbar(30/08/2018)
- Removed declaration of parameters in Configuration class as they are end-user parameters and defined in c975L/ConfigBundle (30/08/2018)
- Updated `README.md` (30/08/2018)
- Added `UPGRADE.md` (30/08/2018)
- Added shortcut method `getParameter()` to c975L/ConfigBundle `getParameter()` to avoid injection of its ConfigServiceInterface

Upgrading from v1.x? **Check UPGRADE.md**

## v1.x

## v1.16.5

- Fixed small things (30/08/2018)

## v1.16.4

- Removed 'true ===' as not needed (25/08/2018)
- Added dependency on "c975l/config-bundle" and "c975l/services-bundle" (26/08/2018)

## v1.16.3

- Replaced links in dashboard by buttons (25/08/2018)
- Removed id display in dashboard (25/08/2018)

## v1.16.2.3

- Corrected documentation for Voter (21/08/2018)

## v1.16.2.2

- Adjusted documentation (21/08/2018)
- Removed FQCN (21/08/2018)
- Moved methods calls, in `EmailService`, from __construct() to create() (21/08/2018)
- Removed pagination form `getEmails()` and moved it in Controller (21/08/2018)
- Get back to auto-wire services (even if not Best Practices, it's easier and simplier...) (21/08/2018)

## v1.16.2.1

- Added link to BuyMeCoffee (20/08/2018)
- Added link to apidoc (20/08/2018)

## v1.16.2

- Typo in README.md (04/08/2018)
- Defined services explicitly (04/08/2018)
- Made use of `EmailServiceInterface` (04/08/2018)
- Added docblocks data (04/08/2018)
- Added php-cs-fixer (04/08/2018)
- Moved `getEmails()` for dashboard to EmailService (04/08/2018)

## v1.16.1

- Added missing Security folder (01/08/2018)

## v1.16

- Made use of Voters for access rights (01/08/2018)
- Made use of ParamConverter (01/08/2018)

## v1.15.6.2

- Corrected README.md (29/07/2018)

## v1.15.6.1

- Updated `.travis.yml` to reflect recommended config (23/07/2018)
- Removed options in `phpunit.xml.dist` (23/07/2018)

## v1.15.6

- Updated tests (22/07/2018)
- Added `.travis.yml` (22/07/2018)
- Corrected attachments (22/07/2018)
- Corrected persistence in DB (22/07/2018)
- Improved Service due to result of tests (23/07/2018)

## v1.15.5

- Use of Yoda style (22/07/2018)
- Split methods in Service (22/07/2018)
- Setup of tests (22/07/2018)

## v1.15.4

- Removed Bootstrap javascript request as not needed (21/07/2018)
- Removed `Action` in controller method name as not requested anymore (21/07/2018)
- Corrected meta in `layout.html.twig` (21/07/2018)

## v1.15.3.1

- Removed required in composer.json (22/05/2018)

## v1.15.3

- Modified toolbars calls due to modification of c975LToolbarBundle (13/05/2018)

## v1.15.2

- Added information about multilingual prefix (03/05/2018)

## v1.15.1

- Changed creation of `emails_archives` table (02/04/2018)
- Renamed stored procedure to archive emails (02/04/2018)
- Made use by default of archiving emails (02/04/2018)

## v1.15

- Set bold for the name of the site in the signature (30/03/2018)
- Added boolean return if message has been sent or not (30/03/2018)
- Modified organisation of `EmailService` (31/03/2018)

## v1.14.2

- Modified copyright in `fullLayout.html.twig` (17/03/2018)
- Moved email + site info from Controller call to Twig template `layout.html.twig` (17/03/2018)

## v1.14.1

- Updated `README.md` with an example of email (08/03/2018)
- Added block hello (08/03/2018)

## v1.14

- Added missing translations (07/03/2018)
- Modified `layout.html.twig` to be used like in c975L/SiteBundle, to avoid having to override it (07/03/2018)

## v1.13

- Added possibility to attach multiple attachments (06/03/2018)
- Changed returned values from getters (07/03/2018)

## v1.12.2

- Removed the "|raw" for `toolbar_button` call as safe html is now sent (01/03/2018)

## v1.12.1

- Added c957L/IncludeLibrary ton `composer.json` (27/02/2018)

## v1.12

- Added c957L/IncludeLibrary to include libraries in layout.html.twig (27/02/2018)

## v1.11

- Removed translations taken from c975L/ToolbarBundle (22/02/2018)
- Added help pages (22/02/2018)
- Suppressed tool in tools.html.twig as it was coming from another project (22/02/2018)
- Added templates and styles for email to be used by other dashboards, for user to have only one place to overrde (22/02/2018)
- Abandoned Glyphicon and replaced by fontawesome (22/02/2018)

## v1.10

- Change about composer download in `README.md` (04/02/2018)
- Add support in `composer.json`+ use of ^ for versions request (04/02/2018)
- Add Route + view to visualize emails sent (05/02/2018)
- Add of c975L/ToolbarBundle (05/02/2018)
- Updated  `README.md` (05/02/2018)

## v1.9

- Changes in `README.md` (02/02/2018)
- Add possibility to add attachment (02/02/2018)

## v1.8

- Unallow sending email if ReplyTo address is not validated, to avoid spam (23/01/2018)
- Added multiple validations (RFC + DNS) (23/01/2018)

## v1.7

- Change MySql engine for `emails_archives` table to ARCHIVE (15/08/2017)
- Changes in `README.md` (16/08/2017)
- Move of send message action inside the if for email validation (24/09/2017)

## v1.6.4

- Remove of .travis.yml as tests have to be defined before

## v1.6.3

- Rename .travis.yml (18/07/2017)

## v1.6.2

- Run PHP CS-Fixer (18/07/2017)
- Update of composer php version (18/07/2017)
- Update travis.yml (18/07/2017)

## v1.6.1

- Change type-hint "EntityManager" to "\Doctrine\ORM\EntityManagerInterface" (18/07/2017)

## v1.6

- Set saving in database as an option (15/07/2017)

## v1.5.1

- Update of README.md (14/07/2017)

## v1.5

- Add of EmailService to avoid sending mailer and make easier use of the bundle, DB flush is done inside the service (14/07/2017)

## v1.4.2

- Update README.md (04/07/2017)

## v1.4.1

- Add the sql code to be able to archive emails in another table on a regular basis (04/07/2017)

## v1.4

- Renaming of file Resources/sql/TableCreation.sql to emails.sql (13/06/2017)
- Add information about SwiftMailer (04/07/2017)
- Update of requirements in `composer.json` (04/07/2017)

## v1.3

- Replacment of Swift_Validate by Egulias\EmailValidator\EmailValidator (12/06/2017)

## v1.2

- Upgrade to "symfony/swiftmailer-bundle": "3.*" (06/06/2017)

## v1.1.2.1

- Add mention lo License in php files (05/06/2017)

## v1.1.2

- Changes in README.md (05/06/2017)

## v1.1.1

- Changes in README.md (05/06/2017)

## v1.1

- Add of content in README.md (05/06/2017)
- Add of configuration parameter (05/06/2017)

## v1.0.1

- Add of files (05/06/2017)

## v1.0

- Creation of bundle (05/06/2017)
