<?php

namespace App\Billing;

class Stripe
{

  protected $key;

  public function __construct($key)
  {
    dd($key);
    $this->key = $key;
  }
}
