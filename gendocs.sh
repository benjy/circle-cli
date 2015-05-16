#!/usr/bin/env bash

./bin/sami.php update sami/config.php --force

rm -rf docs/*
mv docs-temp/* docs/
rmdir docs-temp
