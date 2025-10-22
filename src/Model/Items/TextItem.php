<?php

namespace Toast\Emails\Items;

use Toast\Emails\EmailAdmin;
use Toast\Emails\Items\EmailLayoutItem;

class TextItem extends EmailLayoutItem
{
    private static $table_name = 'Emails_TextItem';

    private static $singular_name = 'Text';

    private static $plural_name = 'Text';

    protected static $icon_class = 'font-icon-block-blog-post';

    private static $db = [
        'Content' => 'HTMLText'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName([
                'Content',
            ]);

            // Get the email admin
            $emailAdmin = EmailAdmin::singleton();

            $fields->addFieldsToTab('Root.Main', [
                $emailAdmin->getEmailTextEditor('Content', 'Content'),
            ]);
        });

        return parent::getCMSFields();
    }
}
