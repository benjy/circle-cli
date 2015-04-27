# Circle CLI

This is a CLI utility built with Symfony Console to query Circle CI projects.

# Installation

    # Install with composer.
    composer require "codedrop/circle-cli ~1.0"

    # Copy the sample config file into your home directory (or your project)
    cp vendor/codedrop/circle-cli/circle-cli.yml ~/

    # Copy the sample private file, then add your token to this file.
    cp vendor/codedrop/circle-cli/circle-cli.private.yml.sample ./

# Commands

I'm open to adding new commands, feel free to create an issue.

## Status

This command uses the most [recent builds](https://circleci.com/docs/api#recent-builds-project) endpoint
to provide a quick status overview of the project.

##### Example;

    circle status [project-name]

## Projects

This commands provides a list of all projects within your Circle CI account.

##### Example

    circle projects
    
## Retry Build

This commands starts a "retry" of a given build. You can use "latest" to rebuild
the last build and use can use the "ssh" option to rebuild with SSH enabled.

##### Example

    circle retry [build_num or 'latest'] [retry_method 'retry' or 'ssh'] ][project-name]

# Configuration

circle-cli has sensible defaults but is highly configurable. Configuration files can live
in three different places.

* ~/circle-cli.yml - A global configuration file in your home directory.
* circle-cli.yml - A local configuration file that takes precedence over the global file.
* circle-cli.private.yml  - A local configuration file that can be used for your circle-token and excluded in .gitignore.

Request configuration are the parameters that are passed as the URL params and are different per endpoint.
Display configuration is a list of display fields from the endpoint response.
The "globals" configuration key is merged into each endpoint configuration as an easy way to manage request or display config
that you want to be the same across all commands.

Both request and response documentation are available on the Circle CI website at
[https://circleci.com/docs/api](https://circleci.com/docs/api)

# TODO

* Add some test coverage for the existing commands.
* Add new command to cancel a running build.    
* Add a filter to the RetryCommand to filter by branch.
