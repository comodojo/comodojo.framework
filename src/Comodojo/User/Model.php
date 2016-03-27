<?php namespace Comodojo\User;

use \Comodojo\Components\ComodojoModel;
use \Comodojo\Dispatcher\Components\Configuration;
use \Comodojo\Database\EnhancedDatabase;
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

class Model extends ComodojoModel {

    use UserTrait;

    public function __construct(
        Configuration $configuration,
        EnhancedDatabase $database = null,
        $values = array()
    ) {

        parent::__construct(
            $configuration,
            self::$element_schema,
            self::$element_attributes,
            $values,
            $database
        );

    }

    protected function pushRole($id) {

        try {

            // $check = $this->database
            //     ->table("users_to_roles")
            //     ->keys(array('user', 'role'))
            //     ->where("user", "=", $this->id)
            //     ->andWhere("role", "=", $id)
            //     ->get();

            $result = $this->database
                ->table("users_to_roles")
                ->keys(array('user', 'role'))
                ->values(array($this->id, $id))
                ->store();

        } catch (DatabaseException $de) {
            throw $de;
        } catch (Exception $e) {
            throw $e;
        }

        return true;

    }

    protected function popRole($id) {

        try {

            $result = $this->database
                ->table("users_to_roles")
                ->where("user", "=", $this->id)
                ->andWhere("role", "=", $id)
                ->delete();

        } catch (DatabaseException $de) {
            throw $de;
        } catch (Exception $e) {
            throw $e;
        }

        return true;

    }

}
