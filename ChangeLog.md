# Changelog

- Change MySql engine for `emails_archives` table to ARCHIVE (15/08/2017)

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
- Update travis.yml

v1.6.1
------
Change type-hint "EntityManager" to "\Doctrine\ORM\EntityManagerInterface"

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
- Update of requirements in `composer.json`

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
- Add of configuration parameter

v1.0.1
------
- Add of files (05/06/2017)

v1.0
----
- Creation of bundle (05/06/2017)