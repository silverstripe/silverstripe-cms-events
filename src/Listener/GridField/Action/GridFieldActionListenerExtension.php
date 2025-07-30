<?php

namespace SilverStripe\CMSEvents\Listener\GridField\Action;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;
use SilverStripe\EventDispatcher\Dispatch\Dispatcher;
use SilverStripe\EventDispatcher\Symfony\Event;
use SilverStripe\Forms\GridField\GridField;

/**
 * Snapshot action listener for grid field actions
 *
 * @extends Extension<GridField>
 */
class GridFieldActionListenerExtension extends Extension
{
    public const string EVENT_NAME = 'gridFieldAction';

    /**
     * Extension point in @see GridField::handleRequest
     * GridField action via custom URL handler
     * covers action which are implemented via @see GridField_URLHandler
     *
     * @param HTTPRequest $request
     * @param $action
     * @param $result
     */
    protected function afterCallActionURLHandler(HTTPRequest $request, $action, $result): void
    {
        $owner = $this->getOwner();

        Dispatcher::singleton()->trigger(
            GridFieldActionListenerExtension::EVENT_NAME,
            Event::create(
                $action,
                [
                    'request' => $request,
                    'result' => $result,
                    'gridField' => $owner
                ]
            )
        );
    }
}
