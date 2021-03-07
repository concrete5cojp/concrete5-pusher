# concrete5cojp/concrete5-pusher
A concrete5 package to add Pusher Channels HTTP PHP Library and manage API key.

## Getting Started

```
$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
$pusher = $this->app->make(\Pusher\Pusher::class);
$pusher->trigger('my-channel', 'my-event', ['message' => 'Test]);
```

You must provide all information on Dashboard > System & Settings > Pusher Channels > API before using the library

## Example extermal form

You can test to use Pusher Channels by just copying `example/blocks/external_form` folder to `YOUR_CONCRETE_ROOT/application/blocks/external_form`
