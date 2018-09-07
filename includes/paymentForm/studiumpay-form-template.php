<form class="studiumPay jumbotron" id="studiumPay_form" method="post" >

  <div class="studiumPay__item studiumPay__item--checkbox">
  <?php foreach ($this->variables['courses'] as $key => $value): ?>
    <label class="studiumPay__label" for="<?php echo $key; ?>">
      <?php echo $key; ?>
      <input class="studiumPay__checkbox--JS" type="checkbox" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
    </label>
  <?php endforeach; ?>
  </div>

  <div class="studiumPay__item studiumPay__item--cost">
    <label for="cost">
      Ile płacę:
    </label>
    <input id="studiumPay_cost" required regex="\d+" type="int" min="0" max="10000" name="cost" value="0">
    <div  id="studiumPay_display" class="studiumPay_cost_display"></div>
  </div>
  <div class="studiumPay__item studiumPay__item--submit">
    <span>Zamawiam i płacę z <span>
      <input class="studiumPay__submit" id="studiumPay_submit" type="submit" />
  </div>
</form>
