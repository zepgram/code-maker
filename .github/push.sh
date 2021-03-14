#!/bin/bash

if [ "$(git diff --name-status --exit-code)" ]; then
  git config --local user.email "$1"
  git config --local user.name "$2"
  git commit -am "[ci-autofix] $3"
  mkdir -p ~/.ssh/ && echo "$4">~/.ssh/id_rsa && echo "$5">~/.ssh/id_rsa.pub
  chmod 400 ~/.ssh/id_rsa && chmod 400 ~/.ssh/id_rsa.pub
  ssh-keyscan -t rsa github.com >>~/.ssh/known_hosts
  git push
  exit 1
fi

exit 0
