<?php

namespace Toast\Emails\Items;

use SilverStripe\Assets\Image;
use Sheadawson\Linkable\Models\Link;
use Toast\Emails\Items\EmailLayoutItem;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ImageItem extends EmailLayoutItem
{
    private static $table_name = 'Emails_ImageItem';

    private static $singular_name = 'Image';

    private static $plural_name = 'Image';

    protected static $icon_class = 'font-icon-block-file';

    private static $has_one = [
        'Image' => Image::class,
        'Link'  => Link::class,
    ];

    private static $owns = [
        'Image'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->addFieldsToTab('Root.Main', [
                UploadField::create('Image', 'Image')
                    ->setFolderName('Uploads/Emails')
                    ->setDescription('Image will display at 600px wide')
                    ->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']),
                LinkField::create('LinkID', 'Link'),
            ]);
        });

        return parent::getCMSFields();
    }
}
