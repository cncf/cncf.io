#!/bin/bash

TERMINUS_S=$1
echo 'export PATH=$PATH:$HOME/bin:$HOME/terminus/bin' >> $BASH_ENV
echo 'export BRANCH=$(echo $CIRCLE_BRANCH | grep -v '"'"'^\(master\|[0-9]\+.x\)$'"'"')' >> $BASH_ENV
echo 'export PR_ENV=${BRANCH:+pr-$BRANCH}' >> $BASH_ENV
echo 'export CIRCLE_ENV=ci-$CIRCLE_BUILD_NUM' >> $BASH_ENV
# If we are on a pull request
if [[ $CIRCLE_BRANCH != "master" && -n ${CIRCLE_PULL_REQUEST+x} ]]
then
	# Then use a pr- branch/multidev
	PR_NUMBER=${CIRCLE_PULL_REQUEST##*/}
	PR_BRANCH="pr-${PR_NUMBER}"
	echo "export DEFAULT_ENV=pr-${PR_NUMBER}" >> $BASH_ENV
else
	# otherwise make the branch name multidev friendly
	if [[ $CIRCLE_BRANCH == "master" ]]
	then
		echo "export DEFAULT_ENV=dev" >> $BASH_ENV
	else
		echo 'export DEFAULT_ENV=$(echo ${PR_ENV:-$CIRCLE_ENV} | tr '"'"'[:upper:]'"'"' '"'"'[:lower:]'"'"' | sed '"'"'s/[^0-9a-z-]//g'"'"' | cut -c -11 | sed '"'"'s/-$//'"'"')' >> $BASH_ENV
	fi
fi
echo 'export TERMINUS_ENV=${TERMINUS_ENV:-$DEFAULT_ENV}' >> $BASH_ENV
source $BASH_ENV

if [[ (${CIRCLE_BRANCH} != "master") || (${CIRCLE_BRANCH} == "master" && -n ${CIRCLE_PULL_REQUEST+x}) ]];
then
    echo -e "CircleCI will only run Wraith tests on Pantheon if on the master branch.\n"
    exit 0;
fi

# Bail if required environment varaibles are missing
if [ -z "$TERMINUS_S" ] || [ -z "$TERMINUS_ENV" ]
then
  echo 'No test site specified. Set TERMINUS_SITE and TERMINUS_ENV.'
  exit 1
fi

echo "::::::::::::::::::::::::::::::::::::::::::::::::"
echo "Wraith test site: $TERMINUS_S.$TERMINUS_ENV"
echo "::::::::::::::::::::::::::::::::::::::::::::::::"
echo

# Exit immediately on errors
set -ex

# install fonts
apt-get install fonts-arphic-bkai00mp  fonts-arphic-bsmi00lp  fonts-arphic-gbsn00lp fonts-arphic-gkai00mp

# Run the Wraith tests
cd wraith
cp configs/capture.yaml.template configs/capture.yaml 
cat >>configs/capture.yaml <<EOL
# (required) The domains to take screenshots of.
domains:
  current:  "http://test-$TERMINUS_S.pantheonsite.io"
  new:      "https://$TERMINUS_ENV-$TERMINUS_S.pantheonsite.io"  
EOL
wraith capture capture

# Change back into previous directory
cd -