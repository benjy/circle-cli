# Circle CLI

This is a CLI utility built with Symfony Console to query Circle CI projects.

# Commands

I'm open to adding new commands, feel free to create an issue.

## Status

This command uses the most [recent builds](https://circleci.com/docs/api#recent-builds-project) endpoint
to provide a quick status overview of the project.

### Example;

    circle status

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
