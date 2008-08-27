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

$this->getConfigCache()->registerConfigHandler('config/rest_routing.yml', 'sfRestRoutingConfigHandler', array());

sfConfig::set('sf_method_key', '_method');