<form class="studiumPay jumbotron" id="studiumPay_form" method="post" >
  fixed
  session_id
  <input type="text" style="width:250px" name="p24_session_id" value="<?php echo md5(session_id().date("YmdHis")); ?>" />
  return url
  <input type="text" style="width:250px" name="p24_url_return" value="<?echo $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=1"?>" />
  status url
  <input type="text" style="width:250px" name="p24_url_status" value="<?echo $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?ok=2"?>" />
  p24_api_version<input type="text" style="width:250px" name="p24_api_version" value="<?php echo P24_VERSION; ?>" />
  <div class="row">
    <div class="col-6">
      p24_name_1*<input type="text" style="width:250px" name="p24_name_1" value="Pizza" />
      p24_description_1*<input type="text" style="width:250px" name="p24_description_1" value="Smaczna, zdrowa..." />
      p24_quantity_1<input type="text" style="width:250px" name="p24_quantity_1" value="2" />
      p24_price_1*<input type="text" style="width:250px" name="p24_price_1" value="1250" />
      p24_number_1*<input type="text" style="width:250px" name="p24_number_1" value="1367" />
      p24_transfer_label*<input type="text" style="width:250px" name="p24_transfer_label" value="MyStore" />
    </div>
    <div class="col-6">
      email
      <input type="text" style="width:250px" name="p24_email" value="no-reply@przelewy24.pl" />
      imie nazwisko
      <input type="text" style="width:250px" name="p24_client" value="Jan Kowalski" />
    </div>
  </div>
  amount
  <input type="text" style="width:250px" name="p24_amount" value="512" />
  description
  <input type="text" style="width:250px" name="p24_description" value="Zam�wienie testowe" />
  p24_country
  <input type="text" style="width:250px" name="p24_country" value="PL" />
  language
  <input type="text" style="width:250px" name="p24_language" value="PL" />
  shipping
  <input type="text" style="width:250px" name="p24_shipping" value="2500" />
  currency
  <input type="text" style="width:250px" name="p24_currency" value="PLN" />
  <input name="submit_test" value="test connection" type="submit" />
  <input name="submit_send" value="send" type="submit" />
</form>
