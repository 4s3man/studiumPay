<form class="studiumPay jumbotron" id="studiumPay_form" method="post" >
  <div class="row">
    <div class="col-6">
      <?php foreach ($this->variables['courses'] as $name => $cost): ?>
        <label for="<?php echo $name; ?>">
          <?php echo $name; ?>
        <input type="int" min="0" required name="<?php echo $name; ?>" value="0">
        </label>
      <?php endforeach; ?>
    </div>
    <div class="col-6">
      email
      <input type="text" style="width:250px" required name="p24_email" value="no-reply@przelewy24.pl" />
      imie i nazwisko
      <input type="text" style="width:250px" required name="p24_client" value="Jan Kowalski" />
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
  <input name="submit_send" value="send" type="submit" />
</form>
