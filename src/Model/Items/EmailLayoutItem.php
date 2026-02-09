<?php

namespace Toast\Emails\Items;

use Toast\Emails\EmailAdmin;
use Toast\Emails\EmailLayout;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\Versioned\Versioned;
use SilverStripe\ORM\FieldType\DBField;
use Toast\OpenCMSPreview\Fields\OpenCMSPreview;

class EmailLayoutItem extends DataObject
{
    private static $table_name = 'EmailLayoutItem';

    private static $singular_name = 'Item';

    private static $plural_name = 'Items';

    protected static $icon_class = 'font-icon-block-content';

    private static $casting = [
        'Icon' => 'HTMLText'
    ];

    private static $db = [
        'Title' => 'Varchar(255)',
        'SortOrder' => 'Int'
    ];

    // private static $has_one = [
    //     'Parent' => EmailLayout::class
    // ];

    private static $belongs_many_many = [
        'Parents' => EmailLayout::class
    ];

    private static $summary_fields = [
        'IconForCMS' => 'Type',
        'Title' => 'Title',
    ];

    private static $searchable_fields = [
        'Title'
    ];

    private static $extensions = [
        Versioned::class
    ];

    private static $versioned_gridfield_extensions = true;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(['Parents', 'SortOrder']);

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title', 'Title')
                ->setDescription('This is for internal use only and will not be displayed in the email.'),
        ]);

        if ($previewLink = $this->getPreviewLink()) {
            $fields->addFieldsToTab('Root.Main', [
                OpenCMSPreview::create($previewLink)
            ]);
        }


        return $fields;
    }

    public function getIconForCMS()
    {
        return DBField::create_field('HTMLText', '
            <div class="toast-block-icon" style="text-align: center; margin: 0; padding: 10px; max-width: 70px;">
                <span class="toast-block-icon__media ' . static::$icon_class . '" style="position: relative; font-size: 40px; line-height: 0;"></span>
            </div>
            <span class="toast-block-title" style="display: block; font-size: 10px; font-weight: bold; line-height: 10px; text-transform: uppercase; text-align: left; margin: 0; padding: 0;">' . $this->i18n_singular_name() . '</span>
        ');
    }

    public function forTemplate(): string
    {
        return $this->renderWith([$this->ClassName, 'Toast\Emails\Items\TextItem']);
    }

    public function getPreviewLink()
    {
        $parents = EmailLayout::get()->filterAny([
            'HeaderItems.ID' => $this->ID,
            'FooterItems.ID' => $this->ID
        ]);

        if($parents && $parents->count()){
            $parent = $parents->first();
            return $parent->getPreviewLink() . '#' . $this->getItemID();
        }


        // // Get the current controller
        // $controller = Controller::curr();

        // // Initialise the parent variable
        // $parent = null;

        // if ($controller instanceof EmailAdmin) {
        //     // Find the parent EmailLayout
        //     if ($parent = $controller->getCurrentEmailLayout()) {
        //         return $parent->getPreviewLink();
        //     }
        // }

        // return null;
    }

    public function getItemID()
    {
        // Return the last part of the class name + the ID
        return preg_replace('/.*\\\/', '', get_class($this)) . '_' . $this->ID;
    }


    // protected function onAfterWrite()
    // {
    //     parent::onAfterWrite();

    //     // Publish the item after it is reordered
    //     if ($this->isChanged('SortOrder')) {
    //         $this->publishSingle();
    //     }
    // }


}
