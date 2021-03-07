<?php

namespace Concrete\Package\Pusher\Controller\SinglePage\Dashboard\System\Pusher;

use Concrete\Core\Config\Repository\Liaison;
use Concrete\Core\Package\PackageService;
use Concrete\Core\Page\Controller\DashboardPageController;

class Api extends DashboardPageController
{
    public function view()
    {
        $config = $this->getPackageConfig();
        if ($config) {
            $this->set('app_id', $config->get('api.app_id'));
            $this->set('app_key', $config->get('api.app_key'));
            $this->set('app_secret', $config->get('api.app_secret'));
            $this->set('app_cluster', $config->get('api.app_cluster'));
        }
        $this->set('pageTitle', t('Pusher Channels API'));
    }

    public function save()
    {
        if (!$this->token->validate('pusher_api')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has()) {
            $config = $this->getPackageConfig();
            if ($config) {
                $app_id = $this->get('app_id');
                if (!empty($app_id)) {
                    $config->save('api.app_id', $app_id);
                }
                $app_key = $this->get('app_key');
                if (!empty($app_key)) {
                    $config->save('api.app_key', $app_key);
                }
                $app_secret = $this->get('app_secret');
                if (!empty($app_secret)) {
                    $config->save('api.app_secret', $app_secret);
                }
                $app_cluster = $this->get('app_cluster');
                if (!empty($app_cluster)) {
                    $config->save('api.app_cluster', $app_cluster);
                }
            }
            $this->flash('success', t('Successfully updated.'));

            return $this->buildRedirect($this->action('view'));
        }
    }

    private function getPackageConfig(): ?Liaison
    {
        /** @var PackageService $service */
        $service = $this->app->make(PackageService::class);
        $package = $service->getClass('pusher');

        return $package->getFileConfig();
    }
}
