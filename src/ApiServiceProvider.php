<?php

namespace C5j\Pusher;

use Concrete\Core\Config\Repository\Liaison;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Foundation\Service\Provider as ServiceProvider;
use Concrete\Core\Package\PackageService;
use Psr\Log\LoggerInterface;
use Pusher\Pusher;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        /** @var Repository $config */
        $config = $this->app->make('config');
        $pkgConfig = $this->getPackageConfig();
        if ($config && $pkgConfig) {
            $this->app->bind(Pusher::class, function () use ($config, $pkgConfig) {
                $app_id = $pkgConfig->get('api.app_id');
                $app_key = $pkgConfig->get('api.app_key');
                $app_secret = $pkgConfig->get('api.app_secret');
                $app_cluster = $pkgConfig->get('api.app_cluster');
                $pusher = new Pusher($app_key, $app_secret, $app_id, [
                    'cluster' => $app_cluster,
                    'useTLS' => true,
                    'timeout' => $config->get('app.http_client.timeout'),
                ]);
                $logger = $this->app->make(LoggerInterface::class);
                $pusher->setLogger($logger);

                return $pusher;
            });
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
