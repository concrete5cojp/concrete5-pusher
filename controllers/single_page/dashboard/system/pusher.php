<?php

namespace Concrete\Package\Pusher\Controller\SinglePages\Dashboard\System;

use Concrete\Core\Page\Controller\DashboardPageController;

class Pusher extends DashboardPageController
{
    public function view()
    {
        return $this->buildRedirect('/dashboard/system/pusher/api');
    }
}
