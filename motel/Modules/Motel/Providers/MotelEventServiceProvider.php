<?php

namespace Modules\Motel\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Maatwebsite\Sidebar\Domain\Events\FlushesSidebarCache;

use Modules\Motel\Events\MotelUserResetProcess;
use Modules\Motel\Events\Handlers\MotelSendResetCodeEmail;

use Modules\User\Events\Handlers\SendRegistrationConfirmationEmail;
use Modules\User\Events\Handlers\SendResetCodeEmail;
use Modules\User\Events\RoleWasUpdated;
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\User\Events\UserHasRegistered;
use Modules\User\Events\UserWasUpdated;

class MotelEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MotelUserResetProcess::class => [
            MotelSendResetCodeEmail::class,
        ]
    ];
}
