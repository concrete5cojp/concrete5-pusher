<?php

namespace Application\Block\ExternalForm\Form\Controller;

use Concrete\Core\Config\Repository\Liaison;
use Concrete\Core\Controller\AbstractController;
use Concrete\Core\Package\PackageService;
use Pusher\Pusher;
use Symfony\Component\HttpFoundation\JsonResponse;

class PusherTest extends AbstractController
{
    public $bID;

    public function view()
    {
        $this->requireAsset('javascript', 'pusher');
        $this->requireAsset('javascript', 'vue');
        $config = $this->getPackageConfig();
        if ($config) {
            $this->set('app_key', $config->get('api.app_key', ''));
            $this->set('app_cluster', $config->get('api.app_cluster', ''));
        }
    }

    public function action_post_message($bID = false)
    {
        if ($this->bID == $bID) {
            $message = $this->post('message');
            /** @var Pusher $pusher */
            $pusher = $this->app->make(Pusher::class);
            $pusher->trigger('my-channel', 'my-event', ['message' => $message]);

            return new JsonResponse(['message' => t('Success')]);
        }

        return new JsonResponse(['error' => t('Error')], JsonResponse::HTTP_BAD_REQUEST);
    }

    private function getPackageConfig(): ?Liaison
    {
        /** @var PackageService $service */
        $service = $this->app->make(PackageService::class);
        $package = $service->getClass('pusher');

        return $package->getFileConfig();
    }
}