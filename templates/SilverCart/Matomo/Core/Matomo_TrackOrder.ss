<% if $Order.OrderPositions.exists %>
    <% loop $Order.OrderPositions %>
_paq.push(['addEcommerceItem',
    "{$ProductNumber}",
    "{$Title}",
    "{$Product.ProductGroup.MatomoBreadcrumbTitle}",
    {$Price.Amount},
    {$Quantity}
]);
    <% end_loop %>
_paq.push(['trackEcommerceOrder',
    "{$Order.OrderNumber}",
    {$Order.AmountTotal.Amount},
    {$Order.TaxableAmountGrossWithoutFees.Amount.Amount},
    {$Order.TaxTotalAmount},
    {$Order.HandlingCost.Amount},
    false <%-- (optional) Discount offered (set to false for unspecified parameter) --%>
]);
<% end_if %>