# Leanpub API client for PHP

[![Build Status](https://travis-ci.org/matthiasnoback/leanpub-api-client.svg?branch=master)](https://travis-ci.org/matthiasnoback/leanpub-api-client)

This library contains a PHP implementation of a client that can be used to connect to the [Leanpub
API](https://leanpub.com/help/api). It is *not feature-complete*, but the features that are implemented are implemented
fully and they work correctly. Feel free to submit PRs for adding new features or fields to existing DTOs, etc.

# Installation

Using [Composer](https://getcomposer.org/), require the ``matthiasnoback/leanpub-api-client`` package.

This package uses the [HTTPPlug](http://docs.php-http.org/en/latest/httplug/library-developers.html) to connect to the Leanpub API.
This means you can any HTTP client you like by installing its adapter.

# Usage

See the directory [integration-tests/](integration-tests/) to find out how to use this library.

There's also a command-line application. To find out more about the available commands, run:

```bash
vendor/bin/leanpub.php
```

Run with `-vvv` to see the HTTP requests that the client makes to the Leanpub API.

