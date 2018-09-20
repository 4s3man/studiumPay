<?php

class Studiumpay_Exception extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction() {
        echo "A custom function for this type of exception\n";
    }
}

if (class_exists('Studiumpay_Repository')) {
  return;
}

class Studiumpay_Repository{

  public function saveOrder($data){
    global $wpdb;

    $this->removeNotValidated(1,2);

    $wpdb->query('START TRANSACTION');
    try{
      if(($purchaser_id = $this->getEmail($data['p24_email']))){
        $this->insertOrder($data, $purchaser_id);
      } else {
        $purchaser_id = $this->insertPurchaser($data);
        $this->insertOrder($data, $purchaser_id);
      }
      $wpdb->query('COMMIT');
    } catch (Studiumpay_Exception $e){
      $wpdb->query('ROLLBACK');
      echo $e;
    }
    exit('repository');
  }

  private function insertPurchaser($data){
    global $wpdb;
    $ok = $wpdb->insert('wp_studiumpay_purchaser', [
      'name' => $data['client_name'],
      'surname' => $data['client_surname'],
      'email' => $data['p24_email'],
      'language' => $data['p24_language'],
    ]);
    if (!$ok) throw new Studiumpay_Exception('nie wiem');

    return $wpdb->insert_id;
  }

  private function insertOrder($data, $purchaser_id){
    global $wpdb;
    $ok = $wpdb->insert('wp_studiumpay_order', [
      'purchaser_id' => $purchaser_id,
      'amount' => $data['p24_amount'],
    ]);
    $order_id = $wpdb->insert_id;

    if (!$ok) throw new Studiumpay_Exception('nie wiem');

    foreach ($data['productId_quantity'] as $product_id => $quantity) {
      $ok = $wpdb->insert('wp_studiumpay_detail', [
        'event_id' => $product_id,
        'order_id' => $order_id,
        'quantity' => $quantity,
      ]);

      if (!$ok) throw new Studiumpay_Exception('nie wiem');
    }

    return $order_id;
  }

  private function removeNotValidated($order_id, $purchaser_id = null){
    global $wpdb;
    $eventName = 'delete_not_validated_' . $order_id . '_' . $purchaser_id;
    //todo zmienić query żeby usuwało to z tymi id co nie jest zwalidowane po 1 dniu i usuwało event usuwający
    $query = sprintf('CREATE EVENT %s
      ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 DAY
      ON COMPLETION PRESERVE

    DO BEGIN
          DELETE messages WHERE date < DATE_SUB(NOW(), INTERVAL 7 DAY);
    END;
    ', $eventName);

    var_dump($query);
    exit('event tests');
  }

  private function getEmail($email){
    global $wpdb;
    $query = $wpdb->prepare('SELECT email from wp_studiumpay_purchaser where email = %s', $email);
    $result = $wpdb->get_var($query);
    return $result;
  }
}
