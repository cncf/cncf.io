#!/bin/bash

if [[ (${CIRCLE_BRANCH} != "master" && -z ${CIRCLE_PULL_REQUEST+x}) || (${CIRCLE_BRANCH} == "master" && -n ${CIRCLE_PULL_REQUEST+x}) ]];
then
    echo -e "CircleCI will only run Behat tests on Pantheon if on the master branch or creating a pull requests.\n"
    exit 0;
fi

# Bail if required environment varaibles are missing
if [ -z "$TERMINUS_SITE" ] || [ -z "$TERMINUS_ENV" ]
then
  echo 'No test site specified. Set TERMINUS_SITE and TERMINUS_ENV.'
  exit 1
fi

if [ -z "$ADMIN_USERNAME" ] || [ -z "$ADMIN_PASSWORD" ]
then
	echo "No WordPress credentials specified. Set ADMIN_USERNAME and ADMIN_PASSWORD."
	exit 1
fi

echo "::::::::::::::::::::::::::::::::::::::::::::::::"
echo "Behat test site: $TERMINUS_SITE.$TERMINUS_ENV"
echo "::::::::::::::::::::::::::::::::::::::::::::::::"
echo

# Clear site cache
terminus -n env:clear-cache $TERMINUS_SITE.$TERMINUS_ENV

# Stash current WordPress username
export WORDPRESS_USER_NAME=$ADMIN_USERNAME

# Use a generic Pantheon user for testing
export ADMIN_USERNAME='pantheon-ci-testing'

# Check if an admin user with our desired username exists
ADMIN_USER_EXISTS=$(terminus -n wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- user list --login=${ADMIN_USERNAME} --format=count)

# If so, delete the existing admin user
if [[ "$ADMIN_USER_EXISTS" == "1" ]]
then
  terminus -n wp $TERMINUS_SITE.$TERMINUS_ENV -- user delete $ADMIN_USERNAME --yes
fi

# Update WordPress database
terminus -n wp $TERMINUS_SITE.$TERMINUS_ENV -- core update-db

# Create a backup before running Behat tests
terminus -n backup:create $TERMINUS_SITE.$TERMINUS_ENV

# Create the desired admin user
terminus -n wp $TERMINUS_SITE.$TERMINUS_ENV -- user create $ADMIN_USERNAME no-reply@getpantheon.com --user_pass=$ADMIN_PASSWORD --role=administrator --porcelain

# Confirm the admin user exists
terminus -n wp $TERMINUS_SITE.$TERMINUS_ENV -- user list --login=$ADMIN_USERNAME

# Dynamically set Behat configuration parameters
export BEHAT_PARAMS='{"extensions":{"Behat\\MinkExtension":{"base_url":"https://'$TERMINUS_ENV'-'$TERMINUS_SITE'.pantheonsite.io"},"PaulGibbs\\WordpressBehatExtension":{"site_url":"https://'$TERMINUS_ENV'-'$TERMINUS_SITE'.pantheonsite.io/wp","users":{"admin":{"username":"'$ADMIN_USERNAME'","password":"'$ADMIN_PASSWORD'"}},"wpcli":{"binary":"terminus -n wp '$TERMINUS_SITE'.'$TERMINUS_ENV' --"}}}}'

# Set Behat variables from environment variables
export RELOCATED_WP_ADMIN=TRUE

# Wake the multidev environment before running tests
terminus -n env:wake $TERMINUS_SITE.$TERMINUS_ENV

# Ping wp-cli to start ssh with the app server
terminus -n wp $TERMINUS_SITE.$TERMINUS_ENV -- cli version

# Verbose mode and exit on errors
set -ex

# Start headless Chrome
echo "\n Starting Chrome in headless mode ..."
google-chrome-unstable --disable-gpu --headless --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222 --no-sandbox </dev/null &>/dev/null &

# Run the Behat tests
./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --strict "$@"

# Reset WordPress user name
export ADMIN_USERNAME=$WORDPRESS_USER_NAME