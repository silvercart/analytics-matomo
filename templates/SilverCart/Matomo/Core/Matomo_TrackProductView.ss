<% if $Product %>
    <% with $Product %>
_paq.push(['setEcommerceView',
    "{$ProductNumberShop}",
    "{$Title}",
    "{$ProductGroup.MatomoBreadcrumbTitle.RAW}",
    {$Price.Amount}
]);
    <% end_with %>
<% end_if %>