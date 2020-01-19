# Events for Silverstripe CMS

This module allows developers to register event handlers for common CMS actions using the
[`silverstripe/event-dispatcher`](https://github.com/silverstripe/silverstripe-event-dispatcher) API.

## Available events

#### formSubmitted
* **Description**: Any form submitted in the CMS
* **Example**:  save, publish, unpublish, delete
* **Listener**: `SilverStripe\CMSEvents\Listener\Form\Listener`

#### cmsAction
* **Description**: A `CMSMain` controller action
* **Example**:  `savetreenode` (reorder site tree)
* **Listener**: `SilverStripe\CMSEvents\Listener\CMSMain\Listener`

#### gridFieldAction
* **Description**: A standard GridField action invoked via a URL (`GridField_URLHandler`)
* **Example**:  `handleReorder` (reorder items)
* **Listener**: `SilverStripe\CMSEvents\Listener\GridField\Action\Listener`

#### gridFieldAlteration
* **Description**: A GridField action invoked via a URL (`GridField_ActionProvider`)
* **Example**:  `deleterecord`, `archiverecord`
* **Listener**: `SilverStripe\CMSEvents\Listener\GridField\Alteration\Listener`

#### graphqlMutation
* **Description**: A scaffolded GraphQL mutation
* **Example**:  `mutation createMyDataObject(Input: $Input)`
* **Listener**: `SilverStripe\CMSEvents\Listener\GraphQL\Mutation\Listener`

#### graphqlOperation
* **Description**: Any generic GraphQL operation
* **Example**:  `mutation publishAllFiles`, `query allTheThings`
* **Listener**: `SilverStripe\CMSEvents\Listener\GraphQL\Middleware\Listener`


## Registering an event handler

```yaml
SilverStripe\Core\Injector\Injector:
  SilverStripe\EventDispatcher\Dispatch\Dispatcher:
    properties:
      handlers:
        # arbitrary key
        cmsForms:
          on: [ formSubmitted.save ]
          handler: %$MyProject\MySaveHandler
```

For more information on using the event dispatcher, read the [event dispatcher documentation](
https://github.com/silverstripe/silverstripe-event-dispatcher
)


## Requirements

* silverstripe/framework: ^4.5

## Installation

`$ composer require silverstripe/cms-events`


## License
See [License](license.md)

## Bugtracker
Bugs are tracked in the issues section of this repository. Before submitting an issue please read over
existing issues to ensure yours is unique.

If the issue does look like a new bug:

 - Create a new issue
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots
 and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version,
 Operating System, any installed SilverStripe modules.

Please report security issues to the module maintainers directly. Please don't file security issues in the bugtracker.

## Development and contribution
If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.
