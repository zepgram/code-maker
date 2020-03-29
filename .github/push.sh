#!/bin/bash

if [ "$(git diff --name-status --exit-code)" ]; then
  git config --local user.email "$1"
  git config --local user.name "$2"
  git commit -am "$3"
  git remote set-url origin "$(git config --get remote.origin.url | sed 's#http.*com/#git@github.com:#g')"
  mkdir -p ~/.ssh/ && echo "$4">~/.ssh/id_rsa && chmod 400 ~/.ssh/id_rsa
  ssh-keyscan github.com >>~/.ssh/known_hosts
  git push
  exit 1
fi

exit 0