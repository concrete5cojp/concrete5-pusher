<?php

namespace Concrete\Package\Pusher;

use C5j\Pusher\ApiServiceProvider;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected $pkgHandle = 'pusher';
    protected $pkgVersion = '0.1.1';
    protected $appVersionRequired = '8.5.4';
    protected $pkgAutoloaderRegistries = [
        'src' => '\C5j\Pusher',
    ];

    /**
     * {@inheritdoc}
     */
    public function getPackageName()
    {
        return t('Pusher Channels');
    }

    /**
     * {@inheritdoc}
     */
    public function getPackageDescription()
    {
        return t('A concrete5 package to add Pusher Channels HTTP PHP Library and manage API key.');
    }

    public function install()
    {
        $this->registerAutoload();

        if (!class_exists('\Pusher\Pusher')) {
            throw new \RuntimeException(t('Required libraries not found.'));
        }

        $pkg = parent::install();

        $this->installContentFile('config/singlepages.xml');

        return $pkg;
    }

    public function on_start()
    {
        $this->registerAutoload();
        $assetList = AssetList::getInstance();
        if ($assetList) {
            $assetList->register(
                'javascript',
                'pusher',
                'https://js.pusher.com/7.0/pusher.min.js',
                ['local' => false]
            );
        }
        /** @var ProviderList $providerList */
        $providerList = $this->app->make(ProviderList::class);
        $providerList->registerProvider(ApiServiceProvider::class);
    }

    /**
     * Register autoloader.
     */
    protected function registerAutoload()
    {
        if (file_exists($this->getPackagePath() . '/vendor/autoload.php')) {
            require $this->getPackagePath() . '/vendor/autoload.php';
        }
    }
}
