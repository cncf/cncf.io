[![CircleCI](https://circleci.com/gh/cncf/cncf.io.svg?style=svg)](https://circleci.com/gh/cncf/cncf.io)


# CNCF.io Developer Instructions

CNCF.io runs in a similar way to  [LFEvents](https://github.com/LF-Engineering/lfevents).

-----

## Install Local Instance

### Requirements

* Install [Lando](https://docs.devwithlando.io/) (a Docker Compose utility/abstraction layer). On a Mac using brew, the command is `brew cask install lando`.

* Install [Terminus](https://pantheon.io/docs/terminus/install/) (CLI for interaction with Pantheon).  Follow all the instructions on that page to set up a [machine token](https://pantheon.io/docs/terminus/install/#machine-token) and [SSH Authentication](https://pantheon.io/docs/terminus/install/#ssh-authentication).  Save the machine token for use in step 2 below.

* Get a GitHub [personal access token](https://help.github.com/en/articles/creating-a-personal-access-token-for-the-command-line) to use in place of a password for performing Git operations over HTTPS.

* Install [Node](https://nodejs.org/)/[NPM](https://www.npmjs.com/) (for theme development)

### Lando Setup
(these steps were derived from [instructions provided by Pantheon](https://github.com/pantheon-systems/example-wordpress-composer#working-locally-with-lando))

1. Clone this repository with HTTPS (not SSH): `git clone https://github.com/cncf/cncf.io.git`
  * Note that the repo does not contain all of WordPress, 3rd-party themes and plugins. They will be pulled in via [composer](https://getcomposer.org/) in step 4.

2. Run `lando init` and use the following values when prompted:
  * `From where should we get your app's codebase?` > `current working directory`
  * `What recipe do you want to use?` > `pantheon`
  * `Enter a Pantheon machine token` > `[enter the Pantheon token you got above]`
  * `Which site?` > `cncfci`

3. Run `lando start` and note the local site URL provided at the end of the process

4. Run `lando composer install --no-ansi --no-interaction --optimize-autoloader --no-progress` to download dependencies

5. Run `lando pull --code=none` and follow the prompts to download the media files and database from Pantheon:
  * `Pull database from?` >  `dev`
  * `Pull files from?` >  `dev`

6. You will need to compile the theme css/js before the site will render correctly:
   1. Go to the theme directory: `cd web/wp-content/themes/lf-theme`
   2. Install the Node.js dependencies: `npm install`
   3. Compile the files: `npm run build`

7. Visit the local site URL saved from above.  To find it again run `lando info`.

8. Get your browser to trust the Lando SSL certificate by following [these instructions](https://docs.lando.dev/config/security.html#trusting-the-ca).  This step isn't essential but will stop you from having to keep bypassing the privacy warning in your browser.  On macOS Catalina, I also had to manually go into Keychain Access and set the *.lndo.site certificate to “Always Trust”. See [screenshot](/ca-screenshot.png).

### Notes

* You can stop Lando with `lando stop` and start it again with `lando start`

* Composer, Terminus and wp-cli commands should be run in Lando rather than on the host machine. This is done by prefixing the desired command with `lando`. For example, after a change to composer.json, run `lando composer update` rather than `composer update`.

* Run `lando pull --code=none` at any time to pull down a fresh copy of the database and files from the live instance on Pantheon

-----

## Theme Development

To activate development mode, using Browsersync and watch files, run `npm start`.

-----

## Percy Tests

[Percy](https://percy.io/) performs visual regression tests on each push to the repo.  It is a great way to spot unintended render issues across the site.  If a particular build diverges from the baseline snapshots, the changes need to be fixed or "Approved" to be incorporated into a new baseline.

-----

## Code Sniffs

The CircleCI process will sniff the code to make sure it complies with WordPress coding standards.  All Linux Foundation code should comply with [these guidelines](https://docs.google.com/document/d/1TYqCwG874i6PdJDf5UX9gnCZaarvf121G1GdNH7Vl5k/edit#heading=h.dz20heii56uf).

phpcs and the [WordPress Coding Standards for PHP_CodeSniffer](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) come as part of the repo and are installed in the vendor directory by composer.phpcs can be run on the command line like this:
```
./vendor/bin/phpcs --standard=WordPress ./web/wp-content
```
For convenience on local instances, use this command to ignore particular files and ignore warnings:
```
./vendor/bin/phpcs -n -s --ignore=*/build/*,*/node_modules/*,*gulpfile*,*/uploads/*,*/plugins/*,*pantheon* -d memory_limit=1024M --standard=WordPress ./web/wp-content
```

It's even more convenient to [install into your text editor](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards#using-phpcs-and-wpcs-from-within-your-ide).

Since the cncfci repo includes phpcs via composer, it will use that version of the binary even though you may have phpcs installed system-wide.  So in the root of the repo you'll need to run the following so that it can find the WordPress standards from within your code editor:

```
./vendor/bin/phpcs --config-set installed_paths ~/Sites/cncf.io/vendor/wp-coding-standards/wpcs
```

-----

## Upgrading WordPress core, themes and plugins

The dependencies of this project are managed by [Composer](https://getcomposer.org/). All dependencies of the project are set in [composer.json](https://github.com/LF-Engineering/lfevents/blob/master/composer.json) and are pulled in at deploy time according to what is set in [composer.lock](https://github.com/LF-Engineering/lfevents/blob/master/composer.lock).

composer.lock is generated from composer.json only when explicitly calling the `composer update` function. Any additional themes or plugins can be added first to composer.json and then `composer update` is run to update composer.lock and pull in the new files.  Dependencies are pegged to a version according to the composer [versioning rules](https://getcomposer.org/doc/articles/versions.md).

It's good practice to keep WordPress and all plugins set at their latest releases to inherit any security patches and upgraded functionality.  Upgrading to a new version, however, sometimes has unintended consequences so it's critical to run all tests before deploying live.

To upgrade the version of a dependency, follow these steps:

1. Edit [composer.json](https://github.com/LF-Engineering/lfevents/blob/master/composer.json) to set the new version rule

2. Run `lando composer update [package]` to update [composer.lock](https://github.com/LF-Engineering/lfevents/blob/master/composer.lock) for just that package or run `lando composer update` to upgrade all packages to the latest versions which satisfy the constraints set in composer.json

3. Test the site locally

4. Check in to GitHub and allow the tests to run

5. Test the dev instance to make sure all looks good

6. Deploy live
