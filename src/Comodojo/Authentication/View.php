<?php namespace Comodojo\Authentication;

use \Comodojo\Components\PackageViewTrait;
use \Comodojo\User\Iterator as UserIterator;
use \Comodojo\User\View as UserView;
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

class View extends Model {

    use PackageViewTrait;

    public function __get($name) {

        if ( array_key_exists($name, $this->data) ) {

            if ( $name == 'parameters') return json_decode($this->data[$name], true);

            return $this->data[$name];

        }

        $class = getClass($this);

        throw new Exception("Invalid property $name for $class");

    }

    public function __isset($name) {

        return isset($this->data[$name]);

    }

    public function getUsers() {

        $filter = array("authentication","=",$this->id);

        return UserIterator::loadBy($this->configuration(), $filter, $this->database(), false);

    }

    public function getProvider(UserView $user) {

        $className = $this->class;

        return new $className($this->configuration(), $user, $this->parameters, $this->database());

    }

}
