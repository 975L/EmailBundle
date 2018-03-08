# Changelog

v1.14.1
-------
- Updated `README.md` with an example of email (08/03/2018)
- Added block hello (08/03/2018)

v1.14
-----
- Added missing translations (07/03/2018)
- Modified `layout.html.twig` to be used like in c975L/SiteBundle, to avoid having to override it (07/03/2018)

v1.13
-----
- Added possibility to attach multiple attachments (06/03/2018)
- Changed returned values from getters (07/03/2018)

v1.12.2
-------
- Removed the "|raw" for `toolbar_button` call as safe html is now sent (01/03/2018)

v1.12.1
-------
- Added c957L/IncludeLibrary ton `composer.json` (27/02/2018)

v1.12
-----
- Added c957L/IncludeLibrary to include libraries in layout.html.twig (27/02/2018)

v1.11
-----
- Removed translations taken from c975L/ToolbarBundle (22/02/2018)
- Added help pages (22/02/2018)
- Suppressed tool in tools.html.twig as it was coming from another project (22/02/2018)
- Added templates and styles for email to be used by other dashboards, for user to have only one place to overrde (22/02/2018)
- Abandoned Glyphicon and replaced by fontawesome (22/02/2018)

v1.10
-----
- Change about composer download in `README.md` (04/02/2018)
- Add support in `composer.json`+ use of ^ for versions request (04/02/2018)
- Add Route + view to visualize emails sent (05/02/2018)
- Add of c975L/ToolbarBundle (05/02/2018)
- Updated  `README.md` (05/02/2018)

v1.9
----
- Changes in `README.md` (02/02/2018)
- Add possibility to add attachment (02/02/2018)

v1.8
----
- Unallow sending email if ReplyTo address is not validated, to avoid spam (23/01/2018)
- Added multiple validations (RFC + DNS) (23/01/2018)

v1.7
----
- Change MySql engine for `emails_archives` table to ARCHIVE (15/08/2017)
- Changes in `README.md` (16/08/2017)
- Move of send message action inside the if for email validation (24/09/2017)

v1.6.4
------
- Remove of .travis.yml as tests have to be defined before

v1.6.3
------
- Rename .travis.yml (18/07/2017)

v1.6.2
------
- Run PHP CS-Fixer (18/07/2017)
- Update of composer php version (18/07/2017)
- Update travis.yml (18/07/2017)

v1.6.1
------
Change type-hint "EntityManager" to "\Doctrine\ORM\EntityManagerInterface" (18/07/2017)

v1.6
----
- Set saving in database as an option (15/07/2017)

v1.5.1
------
- Update of README.md (14/07/2017)

v1.5
----
- Add of EmailService to avoid sending mailer and make easier use of the bundle, DB flush is done inside the service (14/07/2017)

v1.4.2
------
- Update README.md (04/07/2017)

v1.4.1
------
- Add the sql code to be able to archive emails in another table on a regular basis (04/07/2017)

v1.4
----
- Renaming of file Resources/sql/TableCreation.sql to emails.sql (13/06/2017)
- Add information about SwiftMailer (04/07/2017)
- Update of requirements in `composer.json` (04/07/2017)

v1.3
----
- Replacment of Swift_Validate by Egulias\EmailValidator\EmailValidator (12/06/2017)

v1.2
----
- Upgrade to "symfony/swiftmailer-bundle": "3.*" (06/06/2017)

v1.1.2.1
--------
- Add mention lo License in php files (05/06/2017)

v1.1.2
------
- Changes in README.md (05/06/2017)

v1.1.1
------
- Changes in README.md (05/06/2017)

v1.1
----
- Add of content in README.md (05/06/2017)
- Add of configuration parameter (05/06/2017)

v1.0.1
------
- Add of files (05/06/2017)

v1.0
----
- Creation of bundle (05/06/2017)