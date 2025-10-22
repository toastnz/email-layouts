<?php

namespace Toast\Emails;

use Toast\Emails\EmailLayout;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class EmailAdmin extends ModelAdmin
{
    private static $managed_models = [
        EmailLayout::class
    ];

    private static $url_segment = 'emails';
    private static $menu_title = 'Emails';
    private static $menu_icon_class = 'font-icon-p-mail';

    // public function setCurrentEmailLayout()
    // {
    //     // Get the ID from the URL parameters
    //     if ($id = $this->getRequest()->param('ID')) {
    //         // Store the ID in the session
    //         $this->getRequest()->getSession()->set('CurrentEmailLayoutID', $id);
    //     }
    // }

    // // Method to get the stored EmailLayout ID from the session
    // public function getCurrentEmailLayout()
    // {
    //     // Get the ID from the session
    //     if ($id = $this->getRequest()->getSession()->get('CurrentEmailLayoutID')) {
    //         return EmailLayout::get()->byID($id);
    //     }

    //     return null;
    // }

    public function PreviewEmail()
    {
        // Prevent CMS styles to interfere with preview
        Requirements::clear();

        $id = (int) $this->getRequest()->getVar('id');

        $EmailTemplate = self::getEmailTemplateById($id);
        $html = $EmailTemplate->renderTemplate(true);

        Requirements::restore();

        return $html;
    }

    protected static function getEmailTemplateById($id)
    {
        return EmailLayout::get()->byID($id);
    }

    public function getEmailTextEditor($name = 'Content', $label = 'Content') {
        $editor = HTMLEditorField::create($name, $label);

        $config = $editor->getEditorConfig();

        // Extract just the elements and colours from the formats
        $formats = $config->getOption('style_formats');
        $filteredFormats = array_filter($formats, function ($format) {
            return in_array($format['title'], ['Elements', 'Colours']);
        });

        // Update the editor config with the filtered formats
        $config->setOption('style_formats', array_values($filteredFormats));

        // Make sure the user can only paste plain text
        $config->setOption('paste_as_text', true);

        // Add some extra css
        $existingContentStyle = $config->getOption('content_style');

        // Define new styles for headings
        $newStyles = '
            .mce-content-body h1 { font-size: 35px; }
            .mce-content-body h2 { font-size: 30px; }
            .mce-content-body h3 { font-size: 26px; }
            .mce-content-body h4 { font-size: 24px; }
            .mce-content-body h5 { font-size: 20px; }
            .mce-content-body h6 { font-size: 14px; }
            .mce-content-body h1 *,
            .mce-content-body h2 *,
            .mce-content-body h3 *,
            .mce-content-body h4 *,
            .mce-content-body h5 *,
            .mce-content-body h6 * { font-size: inherit; }
        ';

        if ($existingContentStyle) {
            $config->setOption('content_style', $existingContentStyle . ' ' . $newStyles);
        } else {
            $config->setOption('content_style', $newStyles);
        }

        $config->setOptions([
            'toolbar1' => 'styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link',
        ]);

        return $editor;
    }

}
