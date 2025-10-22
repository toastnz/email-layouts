<?php

namespace Toast\Extensions;

use SilverStripe\Forms\Tab;
use Toast\Emails\EmailAdmin;
use Toast\Emails\EmailLayout;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Director;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Admin\AdminRootController;
use Toast\OpenCMSPreview\Fields\OpenCMSPreview;
use SilverStripe\CMS\Controllers\CMSPageEditController;

class CustomEmailRecipientExtension extends Extension
{
    private static $has_one = [
        'CustomEmailTemplate' => EmailLayout::class,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(['CustomEmailTemplateID','EmailTemplate','EmailPreview', 'EmailBody', 'EmailBodyHtml', 'SendPlain']);
        $templates = EmailLayout::get()->map('ID', 'Title')->toArray();
        $request = Controller::curr()->getRequest();

        $emailAdmin = EmailAdmin::singleton();

        $fields->addFieldsToTab('Root.EmailContent', [
            $emailAdmin->getEmailTextEditor('EmailBodyHtml', 'Email Body'),
        ]);

        $pageEditController = singleton(CMSPageEditController::class);
        $pageEditController->getRequest()->setSession($request->getSession());

        $currentUrl = $request->getURL();
        // If used in a regular page context, will have "/edit" on the end, if used in a trait context
        // it won't. Strip that off in case. It may also have "ItemEditForm" on the end instead if this is
        // an AJAX request, e.g. saving a GridFieldDetailForm
        $remove = ['/edit', '/ItemEditForm'];
        foreach ($remove as $badSuffix) {
            $badSuffixLength = strlen($badSuffix ?? '');
            if (substr($currentUrl ?? '', -$badSuffixLength) === $badSuffix) {
                $currentUrl = substr($currentUrl ?? '', 0, -$badSuffixLength);
            }
        }
        $previewUrl = Controller::join_links($currentUrl, 'previewURL');//$this->owner->CustomEmailTemplate()->getPreviewLink()
        // var_dump(Controller::curr(),$previewUrl);die;
        // add preview in new tab; method in EmailRecipientExtension
        if ($this->owner->ID) {

            if($templates && count($templates)){
                $fields->addFieldsToTab('Root.EmailContent', [
                    DropdownField::create('CustomEmailTemplateID', 'Select Email Template', $templates)
                        ->setEmptyString('-- Select Template --'),
                    HeaderField::create('emailFieldsHeader', 'Form Submission Data:'),
                    LiteralField::create('emailFieldsDescription', '<p class="form__field-description">Copy the form variables listed below, e.g. {EditableTextField_XXXX}, and paste them into your email body above to reference their values from the form submission, for example Thanks for getting in touch, {VariableForName}.</p> <br>'),
                    LiteralField::create('emailFields', $this->availableFields()),
                ]);
            }

            if ($this->owner->CustomEmailTemplateID) {
                $fields->addFieldsToTab('Root.EmailContent', [
                    // Open the preview window
                    OpenCMSPreview::create($previewUrl),
                    // Add email template link to be editable in cms in new tab
                    LiteralField::create('editEmailLink','<a target="_blank" href="'. $this->owner->CustomEmailTemplate()->getItemEditLink() .'" class="btn btn-primary" id="edit-email">Edit Email Template</a>')
                ]);
            }
        }
    }



    // protected function previewTab()
    // {
    //     $tab = new Tab('Preview');

    //     // Preview iframe
    //     $sanitisedModel =  str_replace('\\', '-', EmailLayout::class);
    //     $adminSegment = EmailAdmin::config()->url_segment;
    //     $adminBaseSegment = AdminRootController::config()->url_base;
    //     // $iframeSrc = Director::baseURL() . $adminBaseSegment . '/' . $adminSegment . '/' . $sanitisedModel . '/PreviewEmail/?id=' . $this->owner->ID;
    //     $iframeSrc = $this->owner->EmailTemplate()->getPreviewLink();
    //     $iframe = new LiteralField('iframe', '<iframe src="' . $iframeSrc . '" style="width:800px;background:#fff;border:1px solid #ccc;min-height:800px;vertical-align:top"></iframe>');
    //     $tab->push($iframe);

    //     // Merge var helper
    //     // $vars = $this->collectMergeVars();
    //     // $syntax = self::config()->mail_merge_syntax;
    //     // if (empty($vars)) {
    //     //     $varsHelperContent = "You can use $syntax notation to use mail merge variable for the recipients";
    //     // } else {
    //     //     $varsHelperContent = "The following mail merge variables are used : " . implode(", ", $vars);
    //     // }
    //     // $varsHelper = new LiteralField("varsHelpers", '<div><br/><br/>' . $varsHelperContent . '</div>');
    //     // $tab->push($varsHelper);

    //     return $tab;
    // }

    private function availableFields()
    {
        if ($this->owner->FormID) {
            $fields = $this->owner->Form()->Fields();
            $fieldList = [];

            foreach ($fields as $field) {
                // Exclude the form step fields
                if ($field->ClassName === 'SilverStripe\UserForms\Model\EditableFormField\EditableFormStep') continue;

                // Add the field to the list
                $title = $field->Title ? $field->Title : 'Unnamed Field' . $field->Type;
                $fieldList[] = '<tr><th style="padding: 5px 10px 5px 0px; user-select: none;">' . $title . ':</th><td style="padding: 5px 10px;">{' . $field->Name . '}</td></tr>';
            }

            return '<div class="message">
                <table>
                    <tbody>
                        ' . implode('', $fieldList) . '
                    </tbody>
                </table>
            </div>';
        }
    }

    protected function onBeforeWrite()
    {
        if($this->owner->ID){

            if($this->owner->EmailTemplate){
                $this->owner->EmailTemplate = '';
            }
        }
    }
}
