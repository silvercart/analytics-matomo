<% if $Cart.ShoppingCartPositions.exists %>
    <% loop $Cart.ShoppingCartPositions %>
_paq.push(['addEcommerceItem',
    "{$Product.ProductNumberShop}",
    "{$Title}",
<% if $Product.ProductGroup.MatomoBreadcrumbTitle == $Product.ProductGroup.Title %>
    "{$Product.ProductGroup.Title}",
<% else %>
    ["{$Product.ProductGroup.Title}", "{$Product.ProductGroup.MatomoBreadcrumbTitle.RAW}"],
<% end_if %>
    {$getPrice(true).Amount},
    {$Quantity}
]);
    <% end_loop %>
_paq.push(['trackEcommerceCartUpdate', {$Cart.AmountTotal.Amount}]);
<% end_if %>