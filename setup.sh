#!/usr/bin/env bash
vagrant plugin install vagrant-hostmanager
mkdir data
vagrant up --provision
