<?php

namespace Toast\Extensions;

use Toast\Emails\EmailLayout;
use SilverStripe\View\SSViewer;
use SilverStripe\Core\Extension;
use SilverStripe\Model\ArrayData;
use SilverStripe\ORM\FieldType\DBField;

class UserDefinedFormControllerExtension extends Extension
{

    public function updateEmail(&$email, &$recipient, &$emailData)
    {
        $email->setHTMLTemplate('Toast\Emails\Email');

        if ($recipient->CustomEmailTemplateID) {
            $template = EmailLayout::get()->byID($recipient->CustomEmailTemplateID);
            // Get the default subject
            $subject = $template->Subject;
            $headers = null;
            $footers = null;
            // Render the email content
            $content = '';
            if ($template && $template->exists()) {
                if($headers = $template->HeaderItems()){
                    if($headers && $headers->count()){
                        $headers = $headers->sort('SortOrder', 'ASC');
                    }
                }

                // get body from Recipient
                if($emailBody = $recipient->getEmailBodyContent()){
                    // render the body and check for merge fields
                    $content .= $this->replacePlaceholders($emailBody->getValue(), $emailData);
                }

                // Get the recipient's email subject
                if($recipientSubject = $recipient->EmailSubject){
                    $subject = $recipientSubject;
                }


                if($footers = $template->FooterItems()){
                    if($footers && $footers->count()){
                        // sort in desc order
                        $footers = $footers->sort('SortOrder', 'ASC');
                    }
                }

                $body = SSViewer::execute_template(
                    'Toast\Emails\Email',
                    new ArrayData([
                        'Subject' => $subject,
                        'HeaderItems' => $headers,
                        'EmailContent' => DBField::create_field('HTMLText', $content),
                        'FooterItems' => $footers,
                    ])
                );

                $email->setBody($body);

                $email->setHTMLTemplate('Toast\Emails\BlankEmail');

                // Set the subject
                $email->setSubject($subject);
            }
        }

    }


    /**
     * Replace placeholders in the content with submitted form values
     */
    private function replacePlaceholders($content, $emailData)
    {
        foreach ($emailData['Fields'] as $fieldName => $fieldValue) {
            $content = str_replace('{' . $fieldValue->Name . '}', $fieldValue->Value, $content);
        }

        return $content;
    }


}
