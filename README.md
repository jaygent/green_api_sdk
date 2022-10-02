# Green-api.com SDK

This library makes work with green-api.com easier

# Installation

Just download green_api.php or use Composer:
```
composer require jaygent/green_api
```

# Create instance

```
  $api = new Green_api();
```

# Send message
@c.us-number phone,@g.us-group
```
die(
    $api->sendMessage('12345@c.us', 'It works!')
);
```

# Support
Use **Issues** to contact me