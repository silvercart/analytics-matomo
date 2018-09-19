<% if $ProductGroup %>
    <% with $ProductGroup %>
_paq.push(['setEcommerceView',
    false, //<%-- No product SKU on category page --%>
    false, //<%-- No product title on category page --%>
    "{$MatomoBreadcrumbTitle.RAW}"
]);
    <% end_with %>
<% end_if %>