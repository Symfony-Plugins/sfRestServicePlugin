<?php
/**
 * This file is part of the sfRestServicePlugin
 *
 * @package    sfRestServicePlugin
 * @subpackage helper
 * @author     Christian Kerl <christian-kerl@web.de>
 * @copyright  Copyright (c) 2008, Christian Kerl
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @version    SVN: $Id: $
 */

if(!(sfContext::getInstance()->getRouting() instanceof sfRestRouting))
{
  throw new sfInitializationException('This Helper can only be used if sfRestRouting is used!');
}

use_helper('Url');

function _custom_method_javascript_function($method)
{
  static $function_template = "
  var f = document.createElement('form');
  var m = document.createElement('input');

  document.body.appendChild(f);

  m.setAttribute('type', 'hidden');
  m.setAttribute('name', '%s');
  m.setAttribute('value', '%s');

  f.method = 'POST';
  f.action = this.href;
  f.appendChild(m);
  f.submit();";

  return sprintf($function_template, sfConfig::get('sf_method_key'), $method);
}

function rest_link_to($name, $internal_uri, $options = array())
{
  if(substr($internal_uri, 0, 1) == '@')
  {
    list($route_name, $params) = sfContext::getInstance()->getController()->convertUrlStringToParameters($internal_uri);
    $method = sfContext::getInstance()->getRouting()->getRouteMethod($route_name);

    $onclick = isset($options['onclick']) ? $options['onclick'] : '';

    unset($options['post']);

    if($method == 'POST')
    {
      $options['post'] = true;
    }
    else if($method != 'GET')
    {
      $options['onclick'] = $onclick._custom_method_javascript_function($method).'return false;';
    }

    return link_to($name, $internal_uri, $options);
  }
}

?>