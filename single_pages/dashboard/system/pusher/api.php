<?php

use Concrete\Core\Form\Service\Form;
use Concrete\Core\Validation\CSRF\Token;

defined('C5_EXECUTE') or die('Access Denied.');

/** @var Token $token */
/** @var Form $form */

$app_id = $app_id ?? '';
$app_key = $app_key ?? '';
$app_secret = $app_secret ?? '';
$app_cluster = $app_cluster ?? '';
?>
<form method="post" action="<?= $this->action('save') ?>" class="ccm-dashboard-content-form">
    <?php $token->output('pusher_api'); ?>
    <fieldset>
        <div class="form-group">
            <?= $form->label('app_id', 'app_id') ?>
            <?= $form->text('app_id', $app_id) ?>
        </div>
        <div class="form-group">
            <?= $form->label('app_key', 'key') ?>
            <?= $form->text('app_key', $app_key) ?>
        </div>
        <div class="form-group">
            <?= $form->label('app_secret', 'secret') ?>
            <?= $form->text('app_secret', $app_secret) ?>
        </div>
        <div class="form-group">
            <?= $form->label('app_cluster', 'cluster') ?>
            <?= $form->text('app_cluster', $app_cluster) ?>
        </div>
    </fieldset>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <?= $form->submit('submit', t('Save'), ['class' => 'btn btn-primary pull-right']) ?>
        </div>
    </div>
</form>
