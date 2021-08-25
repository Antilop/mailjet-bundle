# Mailjet Bundle

## Configuration

To configure the bundle, you will have to enter the api key, secret and list of templates :

``` yaml

    # app/config/mailjet.yml
    mailjet:
        client:
            api_key: %api_key%
            api_secret_key: %secret_key%
        templates:
            { template: { id: '%template_id%', from_email: '%from_email%', from_name: '%from_name%' } }
```

## Setup

Add `Antilop\Bundle\MailjetBundle\MailjetBundle` to your `bundles.php`:

```php
$bundles = [
    // ...
    Antilop\Bundle\MailjetBundle\MailjetBundle::class => ['all' => true]
];
```

# Limitation

For the moment, the bundle was developed for experimental purposes. Changes and adjustements may
be added for a more complete use.