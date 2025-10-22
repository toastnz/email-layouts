<tr>
    <td valign="top" id="{$ItemID}">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="ImageBlock" style="min-width:100%;">
            <tbody class="ImageBlockOuter">
                <tr>
                    <td valign="top" style="padding:0px" class="ImageBlockInner">
                        <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="ImageContentContainer" style="min-width:100%;">
                            <tbody>
                                <tr>
                                    <td class="ImageContent" valign="top" style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                        <% if $LinkID %>
                                            <a href="{$Link.LinkURL}" aria-label="Open link for {$Title.ATT}">
                                        <% end_if %>

                                        <% with $Image.ScaleMaxWidth(600) %>
                                            <img align="center" alt="{$Title.ATT}" src="{$AbsoluteURL}" width="{$Width}" height="{$Height}" style="max-width:1200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="Image">
                                        <% end_with %>

                                        <% if $LinkID %>
                                            </a>
                                        <% end_if %>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
