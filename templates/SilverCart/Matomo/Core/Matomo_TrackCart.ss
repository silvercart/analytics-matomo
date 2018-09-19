<% if $Cart.ShoppingCartPositions.exists %>
    <% loop $Cart.ShoppingCartPositions %>
_paq.push(['addEcommerceItem',
    "{$Product.ProductNumberShop}",
    "{$Title}",
    "{$Product.ProductGroup.MatomoBreadcrumbTitle}",
    {$getPrice(true).Amount},
    {$Quantity}
]);
    <% end_loop %>
_paq.push(['trackEcommerceCartUpdate', {$Cart.AmountTotal.Amount}]);
<% end_if %>