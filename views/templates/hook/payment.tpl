<div id="cardpay_module">
  <div class="row">
    <div class="col-lg-12">
      <h3><img alt="" src="{$module_dir}img/secure-icon.png" class="secure-icon" />{l s='Secure Credit Card Payment' mod='cardpaysolutions'}</h3>
      <hr>
      {if isset($smarty.get.cardpayError)}<p class="alert alert-danger">{$smarty.get.cardpayError|escape:'htmlall':'UTF-8'}</p>{/if}
      <form action="{$module_dir}validation.php" method="post" name="cardpay_form" id="cardpay_form" class="form-horizontal">
        <div class="form-group">
          <div class="col-lg-3 col-lg-offset-3">
            {if $cardpay_vi_enabled}<img src="{$module_dir}img/cc-visa.png"/>{/if}
            {if $cardpay_mc_enabled}<img src="{$module_dir}img/cc-mastercard.png"/>{/if}
            {if $cardpay_ds_enabled}<img src="{$module_dir}img/cc-discover.png"/>{/if}
            {if $cardpay_ax_enabled}<img src="{$module_dir}img/cc-amex.png"/>{/if}
            {if $cardpay_jc_enabled}<img src="{$module_dir}img/cc-jcb.png"/>{/if}
            {if $cardpay_dn_enabled}<img src="{$module_dir}img/cc-diners.png"/>{/if}
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3">{l s='Card Number:' mod='cardpaysolutions'}</label>
          <div class="col-lg-3">
            <input type="text" name="ccnumber" id="ccnumber" autocomplete="off" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3">{l s='Expiration Date:' mod='cardpaysolutions'}</label>
          <div class="col-lg-1" style="padding-right:0;">
            <select id="exp_month" name="exp_month" class="form-control">
              <option value="">--</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
          </div>
          <div class="col-lg-1 exp-separator"> / </div>
          <div class="col-lg-1" style="padding-left:0;">
            <select name="exp_year" class="form-control">
              <option value="">--</option>
            {section name=date_y start=$current_year loop=$current_year+10}
              <option value="{$smarty.section.date_y.index|escape}">20{$smarty.section.date_y.index|escape}</option>
            {/section}
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3">{l s='CVV:' mod='cardpaysolutions'}</label>
          <div class="col-lg-1 ">
            <input type="text" name="cvv" id="cvv" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-3 col-lg-offset-3">
            <input type="submit" id="cardpay_submit" value="{l s='Complete Order' mod='cardpaysolutions'}" class="button btn btn-default" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
