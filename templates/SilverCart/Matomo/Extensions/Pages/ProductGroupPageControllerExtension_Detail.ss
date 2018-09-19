<% if $Product %>
    <% with $Product %>
<script>
    if (typeof _paq !== "undefined") {
        _paq.push(['setEcommerceView',
            "{$ProductNumberShop}", //<%-- (required) SKU: Product unique identifier --%>
            "{$Title}", //<%-- (optional) Product name --%>
        <% if $Up.MatomoBreadcrumbTitle == $ProductGroup.Title %>
            "{$ProductGroup.Title}", //<%-- (optional) Product category, or array of up to 5 categories --%>
        <% else %>
            ["{$ProductGroup.Title}", "{$Up.MatomoBreadcrumbTitle.RAW}"], //<%-- (optional) Product category, or array of up to 5 categories --%>
        <% end_if %>
            {$Price.Amount} //<%-- (optional) Product Price as displayed on the page --%>
        ]);
        _paq.push(['trackPageView']);
    }
</script>
    <% end_with %>
<% end_if %>