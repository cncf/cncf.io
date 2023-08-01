[![CircleCI](https://circleci.com/gh/cncf/cncf.io.svg?style=svg)](https://circleci.com/gh/cncf/cncf.io)

# Contributing to CNCF.io

Everyone is welcome to contribute to this project. We've created a document that describes guidelines for [contributing to the CNCF.io git repository](/CONTRIBUTING.md).

# CNCF.io Developer Instructions

These instructions are based on you having access to the CNCF.io Pantheon account (and the CNCF.io WordPress database).

## Install Local Instance

### Requirements

* Install [Lando](https://github.com/lando/lando/releases) (a Docker Compose utility / abstraction layer). Using Homebrew for installation is not recommended. [Lando Docs](https://docs.devwithlando.io/). Lando includes it's own versions of PHP, Node (14.19.0), NPM.

* When setting up Lando with the Pantheon recipe it will automatically download [Terminus](https://pantheon.io/docs/terminus/install/) (CLI for interaction with Pantheon).  Follow all the instructions on that page to setup a [machine token](https://pantheon.io/docs/terminus/install/#machine-token) and [SSH Authentication](https://pantheon.io/docs/terminus/install/#ssh-authentication). Save the machine token for use in step 2 below.

* Get a GitHub [personal access token](https://help.github.com/en/articles/creating-a-personal-access-token-for-the-command-line) to use in place of a password for performing Git operations over HTTPS.

### Lando Setup
(these steps were derived from [instructions provided by Pantheon](https://github.com/pantheon-systems/example-wordpress-composer#working-locally-with-lando))

1. Clone this repository: `git clone git@github.com:cncf/cncf.io.git`
  * Note that the repo does not contain all of WordPress, 3rd-party themes and plugins. They will be pulled in via [composer](https://getcomposer.org/) in step 4.

2. Run `lando init` and use the following values when prompted:
  * `From where should we get your app's codebase?` > `current working directory`
  * `What recipe do you want to use?` > `pantheon`
  * `Enter a Pantheon machine token` > `[enter the Pantheon token you got above]`
  * `Which site?` > `cncfci`

If you happen to get an error that looks like this `ERROR ==> Need to give this composition a project name!` then first run `lando init --source pantheon`. The command will fail since you already have a git repo. By running it, however, it will remember your auth for Pantheon so you won't have to enter your machine token again and the initial `lando init` should now work.

3. Open the .lando.yml file and add the following to the file.

```yml
keys:
  - pantheon_rsa
proxy:
  node:
    - bs.cncfci.lndo.site:3000
excludes:
  - vendor
  - /app/web/wp-content/themes/cncf-twenty-two/node_modules
services:
  node:
    type: 'node:14'
    ssl: true
    scanner: false
  appserver:
    run:
      - /app/vendor/bin/phpcs --config-set installed_paths /app/vendor/wp-coding-standards/wpcs
      - /app/vendor/bin/phpcs -i
tooling:
  npm:
    service: node
  npx:
    service: node
  node:
    service: node
  phpcs:
    service: appserver
    cmd: /app/vendor/bin/phpcs --standard="WordPress"
    description: 'Run PHPCS commands'
  phpcbf:
    service: appserver
    cmd: /app/vendor/bin/phpcbf --standard="WordPress"
    description: 'Run PHPCBF commands'
  sniff:
    service: appserver
    cmd: /app/vendor/bin/phpcs --config-set installed_paths /app/vendor/wp-coding-standards/wpcs && /app/vendor/bin/phpcs -n -s --ignore="*/build/*,*/dist/*,*/node_modules/*,*gulpfile*,*/uploads/*,*/plugins/*,*/scripts/*,*/vendor/*,*pantheon*,/build/globals.js" -d memory_limit=1024M --standard="WordPress" /app/web/wp-content/themes/ /app/web/wp-content/mu-plugins/wp-mu-plugins/
    description: 'Run the recommended code sniffs'
  fix:
    service: appserver
    cmd: /app/vendor/bin/phpcs --config-set installed_paths /app/vendor/wp-coding-standards/wpcs && /app/vendor/bin/phpcbf -n -s --ignore="*/build/*,*/dist/*,*/node_modules/*,*gulpfile*,*/uploads/*,*/plugins/*,*/scripts/*,*/vendor/*,*pantheon*,/build/globals.js" -d memory_limit=1024M --standard="WordPress" /app/web/wp-content/themes/ /app/web/wp-content/mu-plugins/wp-mu-plugins/
    description: 'Run the recommended code sniffs and fix'
  debug:
    service: appserver
    cmd: 'touch /app/web/wp-content/debug.log && tail -f /app/web/wp-content/debug.log'
    description: 'Get real-time WP debug log output'

```

4. Run `lando start` and note the local site URL provided at the end of the process.

5. Run `lando composer install --no-ansi --no-interaction --optimize-autoloader --no-progress` to download dependencies

6. Run `lando pull --code=none --files=none` and follow the prompts to download the media files and database from Pantheon:
  * `Pull database from?` >  `dev`

7. run this script to activate a dev plugin used to load media files from the production server instead of hosting them locally, in addition to other dev plugins, and deactivates some production plugins:

```
lando wp plugin activate debug-bar && lando wp plugin activate query-monitor && lando wp plugin deactivate shortpixel-image-optimiser && lando wp plugin deactivate pantheon-advanced-page-cache && lando wp plugin activate load-media-from-production
```

8. You will need to compile the theme css/js before the site will render correctly:
   1. Go to the theme directory: `cd web/wp-content/themes/cncf-twenty-two`
   2. Install the Node.js dependencies: `lando npm install`
   3. Compile the files: `lando npm run build`

9. Visit the local site URL saved from above. To find it again run `lando info`.

10. In the admin you will need to edit the [Search & Filter](https://cncfci.lndo.site/wp/wp-admin/edit.php?post_type=search-filter-widget) settings.  The full url to the result pages are hardcoded in the "Display Results" of each filter.  These will need to be set to the correpsonding local instance url.

11. Get your browser to trust the Lando SSL certificate by following [these instructions](https://docs.lando.dev/config/security.html#trusting-the-ca).  This step isn't essential but will stop you having to keep bypassing the privacy warning in your browser.

### Notes

* You can stop Lando with `lando stop` and start it again with `lando start`. You can turn it off completely with `lando poweroff`

* Composer, Terminus, npm and wp-cli commands should be run in Lando rather than on the host machine. This is done by prefixing the desired command with `lando`. For example, after a change to composer.json, run `lando composer update` rather than `composer update`.

* Repeat steps 6 and 7 above to download a fresh copy of the database.

-----

## Theme Development

To activate Browsersync to watch files, run `lando npm start` in the theme directory. You will then be able to browse the bs.* url listed previously and see the site auto-update whenever there is a change in the underlying source code.

-----

## Code Sniffs

The CircleCI process will sniff the code to make sure it complies with WordPress coding standards.  All Linux Foundation code should comply with [these guidelines](https://docs.google.com/document/d/1TYqCwG874i6PdJDf5UX9gnCZaarvf121G1GdNH7Vl5k/edit#heading=h.dz20heii56uf).

phpcs and the [WordPress Coding Standards for PHP_CodeSniffer](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) come as part of the repo and are installed in the vendor directory by composer.

To run recommended tests:

```
lando sniff
```

To run recommended tests and fix issues automatically:

```
lando fix
```

To access  phpcs or phpcbf on the command line to run your own commands, you can access them via Lando, for instance:

```
lando phpcs -i
```
-----

## Upgrading WordPress core, themes and plugins

The dependencies of this project are managed by [Composer](https://getcomposer.org/). All dependencies of the project are set in [composer.json](https://github.com/cncf/cncf.io/blob/main/composer.json) and are pulled in at deploy time according to what is set in [composer.lock](https://github.com/cncf/cncf.io/blob/main/composer.lock).

composer.lock is generated from composer.json only when explicitly calling the `lando composer update` function. Any additional themes or plugins can be added first to composer.json and then `lando composer update` is run to update composer.lock and pull in the new files.  Dependencies are pegged to a version according to the composer [versioning rules](https://getcomposer.org/doc/articles/versions.md).

It's good practice to keep WordPress and all plugins set at their latest releases to inherit any security patches and upgraded functionality.  Upgrading to a new version, however, sometimes has unintended consequences so it's critical to run all tests before deploying live.