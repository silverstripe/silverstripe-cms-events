<?php

namespace SilverStripe\CMSEvents\Tests\Listener\GridField\Action;

use SilverStripe\Forms\GridField\GridField_URLHandler;

class URLHandlerFake implements GridField_URLHandler
{
    public function getURLHandlers($gridField): array
    {
        return [
            'mygrid' => 'handleMyGrid',
        ];
    }

    public function handleMyGrid(): string
    {
        return 'my grid success';
    }
}
