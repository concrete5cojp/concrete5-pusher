# concrete5cojp/concrete5-pusher
A concrete5 package to add [Pusher Channels HTTP PHP Library](https://github.com/pusher/pusher-http-php) and manage API key.

## Getting Started

Clone this repository and install dependencies

```
cd YOUR_CONCRETE_ROOT/packages
git clone git@github.com:concrete5cojp/concrete5-pusher.git pusher
cd pusher
composer install
```

Provide API key and other required information on Dashboard > System & Settings > Pusher Channels > API.

Then you can use the library like below

```
$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
$pusher = $this->app->make(\Pusher\Pusher::class);
$pusher->trigger('my-channel', 'my-event', ['message' => 'Test]);
```

## Example extermal form

You can test to use Pusher Channels by just copying `example/blocks/external_form` folder to `YOUR_CONCRETE_ROOT/application/blocks/external_form`
