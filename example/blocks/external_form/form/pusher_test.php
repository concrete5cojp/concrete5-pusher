<?php

defined('C5_EXECUTE') or die("Access Denied.");

$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
/** @var \Concrete\Core\Form\Service\Form $form */
$form = $app->make('helper/form');
/** @var \Concrete\Core\View\View $view */
$app_key = $app_key ?? '';
$app_cluster = $app_cluster ?? '';
?>

<h1>Pusher Test</h1>
<p>
    Publish an event to channel <code>my-channel</code>
    with event name <code>my-event</code>; it will appear below:
</p>
<div id="app">
    <ul>
        <li v-for="message in messages">
            {{message}}
        </li>
    </ul>
</div>
<form id="form" method="post" action="<?= $view->action('post_message') ?>">
    <div class="form-group">
        <?= $form->textarea('message') ?>
        <?= $form->submit('submit', t('Send')) ?>
    </div>
</form>
<script>
    $(function () {
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        let pusher = new Pusher('<?= h($app_key) ?>', {
            cluster: '<?= h($app_cluster) ?>'
        });

        let channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            app.messages.push(JSON.stringify(data));
        });

        // Vue application
        const app = new Vue({
            el: '#app',
            data: {
                messages: [],
            },
        });

        $('#form').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: form.attr('action'),
                data: form.serialize()
            });
        });
    })
</script>