<?php

namespace SilverStripe\CMSEvents\Listener\CMSMain;

use SilverStripe\CMS\Controllers\CMSMain;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;
use SilverStripe\EventDispatcher\Dispatch\Dispatcher;
use SilverStripe\EventDispatcher\Symfony\Event;

if (!class_exists(CMSMain::class)) {
    return;
}

/**
 * Snapshot action listener for CMS main actions
 *
 * @extends Extension<CMSMain>
 */
class CmsMainListenerExtension extends Extension
{
    public const string EVENT_NAME = 'cmsAction';

    /**
     * Extension point in @see CMSMain::handleAction
     *
     * @param HTTPRequest $request
     * @param $action
     * @param $result
     */
    protected function afterCallActionHandler(HTTPRequest $request, $action, $result): void
    {
        $owner = $this->getOwner();

        Dispatcher::singleton()->trigger(
            CmsMainListenerExtension::EVENT_NAME,
            Event::create(
                $action,
                [
                    'result' => $result,
                    'treeClass' => $owner->config()->get('tree_class'),
                    'id' => $request->requestVar('ID'),
                    'request' => $request,
                ]
            )
        );
    }
}
