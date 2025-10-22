<?php

namespace Toast\Emails;

use Toast\Emails\EmailAdmin;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Model\ArrayData;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Director;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use Toast\Emails\Items\EmailLayoutItem;
use SilverStripe\Admin\AdminRootController;
use SilverStripe\Forms\GridField\GridField;
use Toast\OpenCMSPreview\Fields\OpenCMSPreview;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridField_ActionMenu;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Versioned\VersionedGridFieldItemRequest;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Admin\Forms\GridFieldDetailFormPreviewExtension;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class EmailLayout extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'Subject' => 'Varchar(255)',
        'Summary' => 'Text'
    ];

    private static $many_many = [
        'HeaderItems' => EmailLayoutItem::class,
        'FooterItems' => EmailLayoutItem::class,
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Subject' => 'Subject',
        'Summary' => 'Summary'
    ];

    private static $table_name = 'EmailLayout';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Remove the items field
        $fields->removeByName([
            'HeaderItems',
            'FooterItems'
        ]);

        if ($this->owner->exists()) {
            $config = GridFieldConfig_RelationEditor::create(50);
            $config = $this->getItemsGridField($config, 'HeaderItems', 'Header Items');

            $config2 = GridFieldConfig_RelationEditor::create(50);
            $config2 = $this->getItemsGridField($config2, 'FooterItems', 'Footer Items');

            $fields->addFieldsToTab('Root.Main', [
                OpenCMSPreview::create($this->getPreviewLink()),
                TextField::create('Title', 'Layout Title')
                    ->setDescription('For your reference only'),
                TextField::create('Subject', 'Email Subject'),
                TextareaField::create('Summary', 'Email Summary')
                    ->setDescription('This will be displayed on some email clients as a preview of the email.'),
                LiteralField::create('EmailItemsMessage', '<div class="message notice"><p>The main email content (set up within form recipients) will be rendered between the Header and Footer items.</p></div>'),
                HeaderField::create('EmailItemsHeader', 'Header'),
                GridField::create(
                    'HeaderItems',
                    'Header Items',
                    $this->HeaderItems(),
                    $config
                ),
                LiteralField::create('EmailItemsGap', '<hr>'),
                HeaderField::create('EmailItemsFooter', 'Footer'),
                GridField::create(
                    'FooterItems',
                    'Footer Items',
                    $this->FooterItems(),
                    $config2
                )
            ]);
        }

        return $fields;
    }

    public function getItemsGridField($config, $name = '', $label = '')
    {

        $config->removeComponentsByType(GridFieldAddNewButton::class)
            ->removeComponentsByType(GridFieldFilterHeader::class)
            ->removeComponentsByType(GridField_ActionMenu::class);

        $config->getComponentByType(GridFieldDetailForm::class)
            ->setItemRequestClass(VersionedGridFieldItemRequest::class);

        $multiClass = new GridFieldAddNewMultiClass();

        $availableItems = Config::inst()->get(EmailAdmin::class, 'available_items');

        $multiClass->setClasses($availableItems);

        $config->addComponent($multiClass);

        $config->addComponent(new GridFieldOrderableRows('SortOrder'));

        // Find all the items
        $items = EmailLayoutItem::get();
        // Get all the layouts
        $layouts = EmailLayout::get();

        // Loop through the layouts
        foreach ($layouts as $layout) {
            // Loop through the items
            foreach ($items as $item) {
                // Check if the item belongs to the layout
                if ($layout->HeaderItems()->find('ID', $item->ID) || $layout->FooterItems()->find('ID', $item->ID)) {
                    // Remove the item from the list
                    $items = $items->exclude('ID', $item->ID);
                }
            }
        }

        // // Set the autocomplete to only search for items with no parent
        $config->getComponentByType(GridFieldAddExistingAutocompleter::class)
            ->setSearchList($items);



        return $config;
    }

    public function getPreviewLink()
    {
        return '/_email-preview?stage=Stage&CMSPreview=1&ID=' . $this->ID;
    }

    // get current item edit link
    public function getItemEditLink()
    {

        $sanitisedModel =  str_replace('\\', '-', self::class);
        $adminSegment = EmailAdmin::config()->url_segment;
        $adminBaseSegment = AdminRootController::config()->url_base;
        // get edit link for the email template
        $src = Director::baseURL() . $adminBaseSegment . '/' . $adminSegment . '/' . $sanitisedModel . '/EditForm/field/' . $sanitisedModel . '/' . 'item/' . $this->ID . '/edit';

        return $src;
    }

    public function getExtraCSS()
    {
        // Set the $css variable to an empty string
        $css = '';

        // Get the file contents of the paths listed in the EmailAdmin yml config
        if ($paths = Config::inst()->get(EmailAdmin::class, 'extra_css')) {
            // Loop through the array of paths
            foreach ($paths as $path) {
                // Get the file contents of the path
                $file = file_get_contents(BASE_PATH . '/' . $path);

                // Append the file contents to the $css variable
                $css .= $file;
            }
        }

        // Return the $css variable
        return $css;
    }

    // public function setCurrentEmailLayout()
    // {
    //     // Get the current controller
    //     $controller = Controller::curr();

    //     if ($controller instanceof EmailAdmin) {
    //         // Set the current email layout on the controller
    //         $controller->setCurrentEmailLayout();
    //     }
    // }
    
    public function getTemplateData($formData = null)
    {
        

        if ($formData) {
             // Convert form data to ArrayList of ArrayData for easy looping in template
            $fields = ArrayList::create();
            foreach ($formData as $name => $value) {
                $fields->push(ArrayData::create([
                    'Title' => $name,
                    'FormattedValue' => $value,
                ]));
            }
        }

        return [
            'Summary' => $this->Summary,
            'HeaderItems' => $this->HeaderItems(),
            'FooterItems' => $this->FooterItems(),
            'Fields' => $fields
        ];
    }

    public function getTemplate()
    {
        return 'Toast/Emails/Email';
    }
}
