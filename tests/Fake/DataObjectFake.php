<?php

namespace SilverStripe\CMSEvents\Tests\Fake;

use SilverStripe\Assets\File;
use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\Member;

/**
 * @property string $MyField
 * @property int $MyInt
 * @method Member Author()
 * @method ManyManyList<File> Files()
 */
class DataObjectFake extends DataObject implements TestOnly
{
    private static string $table_name = 'CMSEvents_DataObjectFake';

    private static array $db = [
        'MyField' => 'Varchar',
        'MyInt' => 'Int'
    ];

    private static array $has_one = [
        'Author' => Member::class
    ];

    private static array $many_many = [
        'Files' => File::class
    ];

    private static array $searchable_fields = [
        'MyField',
        'MyInt',
    ];

    private static string $default_sort = '"CMSEvents_DataObjectFake"."MyField" ASC';

    public mixed $customSetterFieldResult;

    public mixed $customSetterMethodResult;

    public function getCustomGetter(): string
    {
        return 'customGetterValue';
    }

    public function customMethod(): string
    {
        return 'customMethodValue';
    }

    public function setCustomSetterField($val): void
    {
        $this->customSetterFieldResult = $val;
    }

    public function customSetterMethod($val): void
    {
        $this->customSetterMethodResult = $val;
    }

    public function canCreate($member = null, $context = []): mixed
    {
        return true;
    }

    public function canEdit($member = null): mixed
    {
        return true;
    }

    public function canView($member = null): mixed
    {
        return true;
    }

    public function canDelete($member = null): mixed
    {
        return true;
    }
}
