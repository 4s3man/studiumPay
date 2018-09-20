<form class="studiumPay jumbotron" id="studiumPay_form" method="post" >
  <div class="row">
    <div class="col-6">
      <?php foreach ($this->variables['products'] as $row): ?>
        <label for="<?php echo 'productId_' . $row['id']; ?>">
          <?php echo $row['post_name']; ?>
        <input class='studiumPay_intInput' type="int" min="0" required name="<?php echo 'productId_' . $row['id']; ?>" value="0">
        </label>
      <?php endforeach; ?>
    </div>
    <div class="col-6">
      email
      <input type="email" style="width:250px" required name="p24_email" value="no-reply@przelewy24.pl" />
      imie
      <input type="text" style="width:250px" required name="client_name" value="Jan" />
      nazwisko
      <input type="text" style="width:250px" required name="client_surname" value="Kowalski" />
    </div>
  </div>
  amount
  <input type="text" id="studiumPay_cost" style="width:250px" required name="p24_amount" value="512" />
  <div id='studiumPay_display'>

  </div>
  <!-- description
  <input type="text" style="width:250px" name="p24_description" value="Zam�wienie testowe" /> -->
  language
  <select required name="p24_language">
    <options source="languages" />
  </select>
  u can save my data
  <input type="checkbox" name="data_save_agreement" value="1">
  accept regimen
  <input type="checkbox" required name="regimen_agreement" value="1">
  <input name="submit_send" value="send" type="submit" />
</form>
