<form class="studiumPay" id="studiumPay_form" method="post" >

  <?php foreach ($this->courses as $key => $value): ?>
    <label for="<?php echo $key; ?>">
      <?php echo $key; ?>
      <input type="checkbox" name="<?php echo $key; ?>" value="0">
    </label>
  <?php endforeach; ?>

  <div class="">
    <input id="studiumPay_cost" type="int" min="0" max="350" name="cost" value="0">
    <div  id="studiumPay_display" class="studiumPay_cost_display"></div>
  </div>
<input id="studiumPay_submit" type="submit" />
</form>
