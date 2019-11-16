#!/bin/bash

project="$1"
sha="$2"
comment="$3"
site_url="$4"

token="$(composer config --global github-oauth.github.com)"

# Exit immediately on errors
set -e

if [ -n "$site_url" ] ; then
  visit_site="[![Visit Site](https://raw.githubusercontent.com/pantheon-systems/ci-drops-8/0.1.0/data/img/visit-site-36.png)]($site_url)"
fi

if [ -n "$token" ] ; then
  curl -d '{ "body": "'"$comment\\n\\n$visit_site"'" }' -X POST https://api.github.com/repos/$project/commits/$sha/comments?access_token=$token

  echo $comment
  echo
  echo $visit_site
fi
