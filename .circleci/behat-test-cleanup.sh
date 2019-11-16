#!/bin/bash

if [[ (${CIRCLE_BRANCH} != "master" && -z ${CIRCLE_PULL_REQUEST+x}) || (${CIRCLE_BRANCH} == "master" && -n ${CIRCLE_PULL_REQUEST+x}) ]];
then
    echo -e "CircleCI will only run Behat tests on Pantheon if on the master branch or creating a pull requests.\n"
    exit 0;
fi

echo "::::::::::::::::::::::::::::::::::::::::::::::::"
echo "Behat clean up on site: $TERMINUS_SITE.$TERMINUS_ENV"
echo "::::::::::::::::::::::::::::::::::::::::::::::::"
echo

# Restore the backup made before testing
terminus -n backup:restore $TERMINUS_SITE.$TERMINUS_ENV --element=database --yes