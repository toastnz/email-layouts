<% if $Content || $PreviewContent %>
    <tr>
        <td valign="top" id="MainEmailContent">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="TextBlock" style="min-width:100%;">
                <tbody class="TextBlockOuter">
                    <tr>
                        <td valign="top" class="TextBlockInner">
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
                                        <td valign="top" class="TextContent TextContent--main" style="padding-top:30px; padding-right:18px; padding-bottom:30px; padding-left:18px;">
                                            <% if $Content %>
                                                {$Content.RAW}
                                            <% else %>
                                                <p style="text-align: center;">{$PreviewContent}</p>
                                            <% end_if %>
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
<% end_if %>

<% if $Fields %>
    <tr>
        <td valign="top" id="AllEmailFields">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="TextBlock" style="min-width:100%;">
                <tbody class="TextBlockOuter">
                    <tr>
                        <td valign="top" class="TextBlockInner">
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
                                        <td valign="top" class="TextContent TextContent--main" style="padding-top:30px; padding-right:18px; padding-bottom:30px; padding-left:18px;">
                                            <dl>
                                                <% loop $Fields %>
                                                    <dt><strong><% if $Title %>{$Title}<% else %>{$Name}<% end_if %></strong></dt>
                                                    <dd style="margin: 4px 0 14px 0">{$FormattedValue}</dd>
                                                <% end_loop %>
                                            </dl>
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
<% end_if %>
