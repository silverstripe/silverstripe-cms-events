<?php

namespace SilverStripe\CMSEvents\Listener\Form;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;
use SilverStripe\EventDispatcher\Dispatch\Dispatcher;
use SilverStripe\EventDispatcher\Symfony\Event;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormRequestHandler;

/**
 * Snapshot action listener for form submissions
 *
 * @extends Extension<FormRequestHandler>
 */
class FormListenerExtension extends Extension
{
    public const string EVENT_NAME = 'formSubmitted';

    /**
     * Extension point in @see FormRequestHandler::httpSubmission
     * controller action via form submission action
     *
     * @param HTTPRequest $request
     * @param $funcName
     * @param $vars
     * @param Form|null $form
     */
    protected function afterCallFormHandler(HTTPRequest $request, $funcName, $vars, ?Form $form): void
    {
        Dispatcher::singleton()->trigger(
            FormListenerExtension::EVENT_NAME,
            Event::create(
                $funcName,
                [
                    'form' => $form,
                    'request' => $request,
                    'vars' => $vars
                ]
            )
        );
    }
}
