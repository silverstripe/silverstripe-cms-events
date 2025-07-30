<?php

namespace SilverStripe\CMSEvents\Tests\Listener\CMSMain;

use SilverStripe\CMS\Controllers\CMSMain;

if (!class_exists(CMSMain::class)) {
    return;
}

class CMSMainFake extends CMSMain
{
    private static array $allowed_actions = [
        'myaction',
    ];

    public function myaction(): string
    {
        return 'this is my action';
    }

    public function myFormAction(mixed $data, mixed $form): string
    {
        return 'submitted';
    }
}
