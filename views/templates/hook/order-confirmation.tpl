{if $cardpay_order.valid == 1}
<p class="alert alert-success">
  {l s='Thank You! Your order is complete.' mod='cardpaysolutions'}
</p>
{else}
<p class="alert alert-danger">
  {l s='Unfortunately, an error occurred during the transaction. Please double-check your credit card details and try again.' mod='cardpaysolutions'}
</p>
{/if}