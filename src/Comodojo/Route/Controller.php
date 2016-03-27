<?php namespace Comodojo\Route;

use \Comodojo\Components\ControllerPersistenceTrait;
use \Comodojo\Components\PackageControllerTrait;
use \Comodojo\Application\Controller as ApplicationController;
use \Exception;

/**
 * @package     Comodojo Framework
 * @author      Marco Giovinazzi <marco.giovinazzi@comodojo.org>
 * @author      Marco Castiello <marco.castiello@gmail.com>
 * @license     GPL-3.0+
 *
 * LICENSE:
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class Controller extends View {

    use ControllerPersistenceTrait;
    use PackageControllerTrait;

    public function __set($name, $value) {

        $className = get_class($this);

        if ( array_key_exists($name, $this->data) === false ) throw new Exception("Invalid property $name for $className");

        if ( $name == 'parameters') $this->data[$name] = serialize($value);

        else $this->data[$name] = $value;

    }

    public function getApplication() {

        $application = new ApplicationController($this->configuration(), $this->database());

        return $application->load($this->application);

    }

}
