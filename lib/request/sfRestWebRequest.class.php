<?php

class sfRestWebRequest extends sfWebRequest
{
  private static $METHODS = array('', 'NONE', 'GET', '', 'POST', 'PUT', 'DELETE', 'HEAD');

  public function initialize(sfEventDispatcher $dispatcher, $parameters = array(), $attributes = array())
  {
    parent::initialize($dispatcher, $parameters, $attributes);

    $key = sfConfig::get('sf_method_key');

    if($this->getMethod() == self::POST && isset($_POST[$key]))
    {
      $this->setMethod(array_search($_POST[$key], self::$METHODS));
    }

    parent::loadParameters();
  }

  public function loadParameters()
  {

  }

  public function getMethodName()
  {
    return self::$METHODS[$this->getMethod()];
  }
}