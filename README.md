[![Build, test and deploy](https://github.com/cncf/cncf.io/actions/workflows/build_test_and_deploy.yml/badge.svg)](https://github.com/cncf/cncf.io/actions/workflows/build_test_and_deploy.yml)

# CNCF.io Developer Instructions

Everyone is welcome to contribute to this project. Please follow [these guidelines](/CONTRIBUTING.md).

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
tooling:
  npm:
    service: node
  npx:
    service: node
  node:
    service: node
  sniff:
    service: appserver
    cmd: /app/vendor/bin/phpcs -ns
  fix:
    service: appserver
    cmd: /app/vendor/bin/phpcbf -s
  warnings:
    service: appserver
    cmd: /app/vendor/bin/phpcs -s
  debug:
    service: appserver
    cmd: 'touch /app/web/wp-content/debug.log && tail -f /app/web/wp-content/debug.log'
    description: 'Get real-time WP debug log output'
  paths:
    service: appserver
    cmd: "/app/vendor/bin/phpcs -i"
    description: "See sniff paths"

```

4. Run `lando start` and note the local site URL provided at the end of the process.

5. Run `lando composer install --no-ansi --no-interaction --optimize-autoloader --no-progress` to download dependencies

6. Run `lando pull --code=none --files=none` and follow the prompts to download the media files and database from Pantheon:
  * `Pull database from?` >  `dev`

7. Run this command to activate/deactivate multiple plugins that can help with local dev or are not needed for local dev. The Load Media Files from Production plugin will load media from the production server instead of needing to download them locally:

```
lando wp plugin activate debug-bar && lando wp plugin activate query-monitor && lando wp plugin deactivate shortpixel-image-optimiser && lando wp plugin deactivate pantheon-advanced-page-cache && lando wp plugin activate load-media-from-production
```

8. You will need to compile the theme css/js before the site will render correctly:
   1. Go to the theme directory: `cd web/wp-content/themes/cncf-twenty-two`
   2. Install the Node.js dependencies: `lando npm install`
   3. Compile the files: `lando npm run build`

9. Visit the local site URL saved from above. To find it again run `lando info`.

10. In the admin you will need to edit the [Search & Filter](https://cncfci.lndo.site/wp/wp-admin/edit.php?post_type=search-filter-widget) settings.  The full url to the result pages are hardcoded in the "Display Results" of each filter.  These will need to be set to the corresponding local instance url.

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

The CI process will sniff the code to make sure it complies with WordPress coding standards.  All Linux Foundation code should comply with [these guidelines](https://docs.google.com/document/d/1TYqCwG874i6PdJDf5UX9gnCZaarvf121G1GdNH7Vl5k/edit#heading=h.dz20heii56uf).

phpcs and the [WordPress Coding Standards for PHP_CodeSniffer](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) come as part of the repo and are installed in the vendor directory by composer.

You can get a report of required fixes on your code by running `lando sniff` and you can automatically fix some required changes by running `lando fix`. You can see warnings by running `lando warnings`.

The commands are setup to use WordPress Coding Standards and to run on the `wp-content/themes/` directory as well as on custom plugins. This is controlled by the phpcs.xml file.

It's even more convenient to [install into your IDE](https://github.com/WordPress/WordPress-Coding-Standards/wiki).

Since the cncf.io repo includes phpcs via Composer, your IDE should use that version of the binary even though you may have phpcs installed system-wide.

-----

## Upgrading WordPress core, themes and plugins

The dependencies of this project are managed by [Composer](https://getcomposer.org/). All dependencies of the project are set in [composer.json](https://github.com/cncf/cncf.io/blob/main/composer.json) and are pulled in at deploy time according to what is set in [composer.lock](https://github.com/cncf/cncf.io/blob/main/composer.lock).

composer.lock is generated from composer.json only when explicitly calling the `lando composer update` function. Any additional themes or plugins can be added first to composer.json and then `lando composer update` is run to update composer.lock and pull in the new files.  Dependencies are pegged to a version according to the composer [versioning rules](https://getcomposer.org/doc/articles/versions.md).

It's good practice to keep WordPress and all plugins set at their latest releases to inherit any security patches and upgraded functionality.  Upgrading to a new version, however, sometimes has unintended consequences so it's critical to run all tests before deploying live.

## Refreshing external data

The following cron jobs are programmed to pull in data from remote sources for use in the website.

```
lf_sync_projects
lf_sync_ktps
lf_sync_kcds
```

To trigger fresh data locally, you can run:

```
lando wp cron event run lf_sync_kcds
```

or for remote triggering on a specific environment:

```
lando terminus wp cncfci.live -- cron event run lf_sync_kcds
```

To trigger all cron jobs, for example:

```
lando terminus wp cncfci.dev -- cron event run --all
```

For other data we use transients to store data:

```
cncf_homepage_metrics
cncf_whoweare_metrics
cncf_latest_endusers
tech_radars
cncf_project_maturity_data
cncf_eu_playlist
cncf_member_playlist
```

These can be deleted locally using:

```
lando wp transient delete cncf_project_maturity_data
```

These can be deleted remotely using:

```
lando terminus wp cncfci.dev transient delete cncf_homepage_metrics
```
