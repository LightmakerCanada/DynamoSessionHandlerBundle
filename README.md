DynamoSessionHandlerBundle
=========

[![Build Status](https://travis-ci.org/LightmakerCanada/DynamoSessionHandlerBundle.svg)](https://travis-ci.org/LightmakerCanada/DynamoSessionHandlerBundle)
[![Code Coverage](https://scrutinizer-ci.com/g/LightmakerCanada/DynamoSessionHandlerBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/LightmakerCanada/DynamoSessionHandlerBundle/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LightmakerCanada/DynamoSessionHandlerBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LightmakerCanada/DynamoSessionHandlerBundle/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f71dc20e-ee78-494c-acc6-e7a5b51464b1/mini.png)](https://insight.sensiolabs.com/projects/f71dc20e-ee78-494c-acc6-e7a5b51464b1)
[![Latest Stable Version](https://poser.pugx.org/lightmaker/dynamo-session-handler-bundle/v/stable.svg)](https://packagist.org/packages/lightmaker/dynamo-session-handler-bundle)
[![Total Downloads](https://poser.pugx.org/lightmaker/dynamo-session-handler-bundle/downloads.svg)](https://packagist.org/packages/lightmaker/dynamo-session-handler-bundle)

A simple Symfony2 bundle to wrap the `AWS SDK for PHP` `DynamoDB Session Handler` for easy use in your Symfony >2.1 application.

For more info see: http://docs.aws.amazon.com/aws-sdk-php/guide/latest/feature-dynamodb-session-handler.html

## Installation

### Add to Composer

Add the following to your projects composer.json

```json
{
    "require": {
        "lightmaker/dynamo-session-handler-bundle": "1.0.*"
    }
}
```

`composer.phar update`


### Update your Kernel

```php
# AppKernel.php
public function registerBundles() {
  $bundles = array(
    new Lightmaker\DynamoSessionHandlerBundle\LightmakerDynamoSessionHandlerBundle()
  );
}
```

### Add optional configuration
See the official AWS SDK for PHP DynamoDB Session Handler docs for more info on configuration:
`http://docs.aws.amazon.com/aws-sdk-php/guide/latest/feature-dynamodb-session-handler.html#configuration`

```yaml
# app/config/config.yml
lightmaker_dynamo_session_handler:
    table_name:
    hash_key:
    session_lifetime:
    consistent_read:
    locking_strategy:
    automatic_gc:
    gc_batch_size:
    gc_operation_delay:
    max_lock_wait_time:
    min_lock_retry_microtime:
    max_lock_retry_microtime:
```

### Set the Symfony framework config to use the DynamoDB Session Handler

```yaml
# app/config/config.yml
framework:
    session:
        handler_id: dynamoSessionHandler
```
