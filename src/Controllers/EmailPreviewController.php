<?php

namespace Toast\Emails;

use Toast\Emails\EmailLayout;
use SilverStripe\Control\Controller;
use SilverStripe\Security\Permission;

class EmailPreviewController extends Controller
{
    private static $allowed_actions = [
        'index'
    ];

    public function index($request)
    {
        // Set headers to prevent caching and indexing
        $this->getResponse()->addHeader('Content-Type', 'text/html');
        $this->getResponse()->addHeader('X-Robots-Tag', 'noindex');
        $this->getResponse()->addHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $this->getResponse()->addHeader('Cache-Control', 'post-check=0, pre-check=0', false);
        $this->getResponse()->addHeader('Pragma', 'no-cache');

        // Return a generic 404 if the user doesn't have access to the CMS
        if (!Permission::check('CMS_ACCESS')) return $this->httpError(404, 'Page not found');

        $id = $request->getVar('ID');
        $emailLayout = EmailLayout::get()->byID($id);

        if (!$emailLayout) {
            return $this->httpError(404, 'Email layout not found');
        }

        return $emailLayout->renderWith('Toast\Emails\Email');
    }
}
