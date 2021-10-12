<% if $Product %>
    <% with $Product %>
_paq.push(['setEcommerceView',
    "{$ProductNumberShop}",
    "{$Title.ATT}",
    "{$ProductGroup.MatomoBreadcrumbTitle.ATT}",
    {$Price.Amount}
]);
    <% end_with %>
<% end_if %>