<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <!--[if gte mso 15]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{$Subject}</title>

        <style type="text/css">
            body, #bodyTable, #bodyCell {
                height: 100%;
                margin: 0;
                padding: 0;
                width: 100%;
                color: black;
                font-family: Helvetica, Arial, sans-serif;
            }

            #bodyCell {
                border-top: 0;
                padding: 10px;
            }

            .templateContainer {
                border: 0;
                max-width: 600px !important;
                color: black;
                background-color: white;
            }

            .text-left {
                text-align: left;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .text-justify {
                text-align: justify;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: Helvetica, Arial, sans-serif;
                font-style: normal;
                letter-spacing: normal;
                font-weight: 400;
                text-align: left;
                margin: 0 0 20px;
                margin: 0 0 .7em;
                line-height: 1.4;
                padding: 0;
                color: inherit;
            }

            h1 {
                font-size: 32px;
            }

            h2 {
                font-size: 26px;
            }

            h3 {
                font-size: 24px;
            }

            h4 {
                font-size: 22px;
            }

            h5 {
                font-size: 20px;
            }

            h6 {
                font-size: 18px;
            }

            p {
                margin: 0 0 10px;
                margin: 0 0 1em;
                padding: 0;
            }

            strong, b {
                font-weight: bold;
            }

            li {
                margin-bottom: 10px;
            }

            table {
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }

            img, a img {
                border: 0;
                height: auto;
                outline: none;
                text-decoration: none;
                -ms-interpolation-mode: bicubic;
            }

            .PreviewText {
                display: none !important;
            }

            #outlook a {
                padding: 0;
            }

            .ReadMsgBody, .ExternalClass {
                width: 100%;
            }

            .ExternalClass p, .ExternalClass td, .ExternalClass div, .ExternalClass span, .ExternalClass font {
                line-height: 100%;
            }

            p, a, li, td, blockquote {
                color: inherit;
                mso-line-height-rule: exactly;
                line-height: 1.6;
            }

            a[href^=tel], a[href^=sms] {
                color: inherit;
                cursor: default;
                text-decoration: none;
            }

            p, a, li, td, body, table, blockquote {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }

            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }

            table[align=left] {
                float: left;
            }

            table[align=right] {
                float: right;
            }

            a.Button {
                display: block;
            }

            :last-child {
                margin-bottom: 0;
            }

            .Image, .RetinaImage {
                vertical-align: bottom;
            }

            .TextContent {
                word-break: break-word;
            }

            .TextContent img {
                height: auto !important;
            }

            .DividerBlock {
                table-layout: fixed !important;
            }

            #templatePreheader {
                border-top: 0;
                border-bottom: 0;
                padding-top: 9px;
                padding-bottom: 9px;
                color: black;
                background-color: white;
            }

            #templatePreheader .TextContent, #templatePreheader .TextContent p {
                font-family: Helvetica, Arial, sans-serif;
                font-size: 12px;
                line-height: 150%;
                text-align: left;
            }

            #templatePreheader .TextContent a, #templatePreheader .TextContent p a {
                color: inherit;
                font-weight: normal;
                text-decoration: underline;
            }

            #templateFooter {
                border-top: 0;
                border-bottom: 0;
                padding-top: 9px;
                padding-bottom: 9px;
                color: black;
                background-color: white;
            }

            #templateFooter .TextContent, #templateFooter .TextContent p {
                color: inherit;
                font-family: Helvetica, Arial, sans-serif;
                font-size: 12px;
                line-height: 150%;
                text-align: center;
            }

            #templateFooter .TextContent a, #templateFooter .TextContent p a {
                color: inherit;
                font-weight: normal;
                text-decoration: underline;
            }

            @media only screen and (min-width: 768px) {
                .templateContainer {
                    width: 600px !important;
                }

                body, table, td, p, a, li, blockquote {
                    -webkit-text-size-adjust: none !important;
                }

                body {
                    width: 100% !important;
                    min-width: 100% !important;
                }

                .Image {
                    width: 100% !important;
                }

                .TextContent--main {
                    padding-top: 50px !important;
                    padding-left: 30px !important;
                    padding-right: 30px !important;
                    padding-bottom: 50px !important;
                }
            }

            {$ExtraCSS}
        </style>

        <% include Toast\Emails\Includes\HeadCodeInclude %>
    </head>

    <body>
        <% if $Summary %>
            <!--[if !gte mso 9]><!----><span class="PreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">{$Summary}</span><!--<![endif]-->
        <% end_if %>

        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <!-- BEGIN TEMPLATE // -->
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                        <tr>
                        <td align="center" valign="top" width="600" style="width:600px;">
                        <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">

                            <%-- TODO: Maybe we dont need this? --%>
                            <%-- <tr>
                                <td valign="top" id="templatePreheader">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="TextBlock" style="min-width:100%;">
                                        <tbody class="TextBlockOuter">
                                            <tr>
                                                <td valign="top" class="TextBlockInner" style="padding-top:9px;">
                                                    <!--[if mso]>
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    <td valign="top" width="600" style="width:600px;">
                                                    <![endif]-->
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="TextContentContainer">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" class="TextContent" style="padding: 0px 18px 9px; text-align: center;">
                                                                    <a href="*|ARCHIVE|*" target="_blank">View this email in your browser</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if mso]>
                                                    </td>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr> --%>

                            <% loop $HeaderItems.Sort('SortOrder') %>
                                $ForTemplate
                            <% end_loop %>

                            <%-- For Email rendering --%>
                            <% if $EmailContent || $Fields %>
                               <% include Toast\Emails\Items\DataItem Content=$EmailContent %>
                            <% else %>
                                <% include Toast\Emails\Items\DataItem PreviewContent='Your custom email content will render here.' %>
                            <% end_if %>

                            <% loop $FooterItems.Sort('SortOrder') %>
                                $ForTemplate
                            <% end_loop %>

                            <%-- EMAIL FOOTER / COPYRIGHT --%>
                            <tr>
                                <td valign="top" id="templateFooter">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="TextBlock" style="min-width:100%;">
                                        <tbody class="TextBlockOuter">
                                            <tr>
                                                <td valign="top" class="TextBlockInner" style="padding-top:9px;">
                                                    <!--[if mso]>
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    <td valign="top" width="600" style="width:600px;">
                                                    <![endif]-->
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="TextContentContainer">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" class="TextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                    <% with $SiteConfig %>
                                                                        <p>
                                                                            <strong>{$Title}</strong>
                                                                            <br>

                                                                            <% if $CompanyAddress %>
                                                                                {$CompanyAddress}
                                                                                <br>
                                                                            <% end_if %>

                                                                            <% if $CompanyPhone %>
                                                                                Phone: {$CompanyPhone}
                                                                                <br>
                                                                            <% end_if %>

                                                                            <% if $CompanyMobile %>
                                                                                Mobile: {$CompanyMobile}
                                                                                <br>
                                                                            <% end_if %>

                                                                            <% if $CompanyEmail %>
                                                                                Email: <a href="mailto:{$CompanyEmail}">{$CompanyEmail}</a>
                                                                                <br>
                                                                            <% end_if %>
                                                                        </p>

                                                                        <p>Copyright © {$Now.Year} {$Title}</p>
                                                                    <% end_with %>

                                                                    <br>

                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if mso]>
                                                    </td>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
