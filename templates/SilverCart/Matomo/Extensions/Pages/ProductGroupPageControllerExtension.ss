<script>
    if (typeof _paq !== "undefined") {
        _paq.push(['setEcommerceView',
            false, //<%-- No product SKU on category page --%>
            false, //<%-- No product title on category page --%>
        <% if $MatomoBreadcrumbTitle == $Title %>
            "{$Title}" //<%-- category title, or array of up to 5 categories --%>
        <% else %>
            ["{$Title}", "{$MatomoBreadcrumbTitle.RAW}"] //<%-- category title, or array of up to 5 categories --%>
        <% end_if %>
        ]);
        _paq.push(['trackPageView']);
    }
</script>