<?php

namespace Toast\Extensions;

use Toast\Emails\EmailLayout;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\View\SSViewer;
use SilverStripe\Core\Extension;
use SilverStripe\Model\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\FieldType\DBField;

class UserFormRecipientItemRequestExtension extends Extension
{

    private static $allowed_actions = [
        'previewURL'
    ];

    public function previewURL()
    {
        // Enable theme for preview (may be needed for Shortcodes)
        Config::nest();
        Config::modify()->set(SSViewer::class, 'theme_enabled', true);

        $content = '';
        $headerSections = new ArrayList();
        $footerSections = new ArrayList();
        if($emailTemplate = $this->owner->record->CustomEmailTemplate()){

            if($headerSectionsItems = $emailTemplate->HeaderItems()){
                foreach ($headerSectionsItems->sort('SortOrder DESC') as $section) {
                    // $content .= $section->forTemplate();
                    $headerSections->push($section);
                }
            }

            $content .= $this->owner->record->getEmailBodyContent();

            if($footerSectionsItems = $emailTemplate->FooterItems()){
                foreach ($footerSectionsItems->sort('SortOrder DESC') as $section) {
                    // $content .= $section->forTemplate();
                    $footerSections->push($section);
                }
            }
        }

        // Prevent CMS styles to interfere with preview
        Requirements::clear();

        $content = $this->owner->customise([
            'HeaderItems' => $headerSections,
            'EmailContent' => $content,
            'FooterItems' => $footerSections,
            // 'HideFormData' => (bool) $this->owner->record->HideFormData,
            // 'Fields' => $this->getPreviewFieldData()
        ])->renderWith('Toast\Emails\Email');

        Config::unnest();

        return $content;
    }

}
