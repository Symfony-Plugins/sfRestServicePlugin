<?php
/**
 * This file is part of the sfRestServicePlugin
 *
 * @package   sfRestServicePlugin
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id: $
 */

/**
 * TODO: Enter description...
 *
 * @package    sfRestServicePlugin
 * @subpackage routing
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class sfRestRouting extends sfPatternRouting
{
  const DEFAULT_METHOD  = 'GET';

  /**
   * @see sfRouting
   */
  public function loadConfiguration()
  {
    if ($this->options['load_configuration'] && $config = sfContext::getInstance()->getConfigCache()->checkConfig('config/rest_routing.yml', true))
    {
      include($config);
    }

    parent::loadConfiguration();
  }

  /**
   * @see sfRouting
   */
  public function connect($name, $route, $defaults = array(), $requirements = array())
  {
    $key = sfConfig::get('sf_method_key');

    if(substr($route, -1) != '/')
    {
      $route .= '/';
    }
    $route .= ':'.$key;

    if(!isset($requirements[$key]))
    {
      $requirements[$key] = self::DEFAULT_METHOD;
    }

    parent::connect($name, $route, $defaults, $requirements);
  }

  /**
   * @see sfRouting
   */
  public function filterParametersEvent(sfEvent $event, $parameters)
  {
    $event['path_info'] .= '/'.$event->getSubject()->getMethodName();

    $result = parent::filterParametersEvent($event, $parameters);

    unset($result[sfConfig::get('sf_method_key')]);

    return $result;
  }

  /**
   * @see sfRouting
   */
  public function generate($name, $params = array(), $querydiv = '/', $divider = '/', $equals = '/')
  {
    $key = sfConfig::get('sf_method_key');

    if(!isset($params[$key]))
    {
      $params[$key] = $this->getRouteMethod($name);
    }

    $url = parent::generate($name, $params, $querydiv, $divider, $equals);

    return substr($url, 0, -(strlen($params[$key]) + 1));
  }

  /**
   * TODO: Enter description...
   *
   * @param  string $name
   *
   * @return string
   */
  public function getRouteMethod($name)
  {
    $key = sfConfig::get('sf_method_key');

    if($this->hasRouteName($name) && isset($this->routes[$name][4][$key]))
    {
      return $this->routes[$name][4][$key];
    }
    else
    {
      return self::DEFAULT_METHOD;
    }
  }
}

