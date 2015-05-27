[![Circle CI](https://circleci.com/gh/code-drop/Circle-CLI.svg?style=svg)](https://circleci.com/gh/code-drop/Circle-CLI)
[![Code Coverage](https://scrutinizer-ci.com/g/code-drop/Circle-CLI/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/code-drop/Circle-CLI/?branch=master)
[![License](https://poser.pugx.org/code-drop/circle-cli/license.svg)](https://packagist.org/packages/code-drop/circle-cli)

# Circle CLI

This is a CLI utility built with Symfony Console to query Circle CI projects.

# Installation

## With Composer

    # Install with composer.
    composer require "code-drop/circle-cli ~1.0"

    # Copy the sample private file, then add your token to this file.
    cp vendor/code-drop/circle-cli/circle-cli.private.yml.sample circle-cli.private.yml

## Grab the Phar

  # wget https://code-drop.github.io/Circle-CLI/circle-cli.phar

# Documentation

The docs are [available here](http://code-drop.github.io/Circle-CLI/index.html).

# Commands

All available commands are documented [here](http://code-drop.github.io/Circle-CLI/Circle/Command.html) below
is some example output from the status and progress commands.

*Example [Status Command](http://code-drop.github.io/Circle-CLI/Circle/Command/StatusCommand.html) with Table output*

![Status command - Table](https://raw.githubusercontent.com/code-drop/Circle-CLI/master/assets/status.jpg)

*Example [Progress Command](http://code-drop.github.io/Circle-CLI/Circle/Command/ProgressCommand.html)*

![Progress command - Table](https://raw.githubusercontent.com/code-drop/Circle-CLI/master/assets/progress-table.jpg)


# TODO

## Features

* [create an issue](https://github.com/code-drop/Circle-CLI/issues)

## Improvements

* Investigate solutions for redrawing errors with Symfony progress bar.
* Create upstream PR for Table helper overrides or, remove table formatter entirely?
