<?php namespace Comodojo\Applications;

use \Comodojo\Database\EnhancedDatabase;
use \Comodojo\Base\Element;
use \Comodojo\Roles\Roles;
use \Comodojo\Routes\Routes;
use \Comodojo\Exception\DatabaseException;
use \Exception;

/**
 *
 *
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

class Application extends Element {

    protected $description = "";

    public function getDescription() {

        return $this->description;

    }

    public function setDescription($description) {

        $this->description = $description;

        return $this;

    }

    public function getRoles() {

        try {

            $roles = new Roles($this->database);

            $result = $roles->loadByApplication($this->id);

        } catch (DatabaseException $de) {

            throw $de;

        }

        return $result;

    }

    public function getRoutes() {

        try {

            $routes = new Routes($this->database);

            $result = $routes->loadByApplication($this->id);

        } catch (DatabaseException $de) {

            throw $de;

        }

        return $result;

    }

    public static function load(EnhancedDatabase $database, $id) {

        try {

            $result = Model::load($database, $id);

        } catch (DatabaseException $de) {

            throw $de;

        }

        if ($result->getLength() > 0) {

            $data = $result->getData();

            $data = array_values($data[0]);

            $app = new Application($database);

            $app->setData($data);

        } else {

            throw new Exception("Unable to load application");

        }

        return $app;

    }

    protected function getData() {

        return array(
            $this->id,
            $this->name,
            $this->description,
            $this->package
        );

    }

    protected function setData($data) {

        $this->id = intval($data[0]);
        $this->name = $data[1];
        $this->description = $data[2];
        $this->package = $data[3];

        return $this;

    }

    protected function create() {

        try {

            $result = Model::create($this->database, $this->name, $this->description, $this->package);

        } catch (DatabaseException $de) {

            throw $de;

        }

        $this->id = $result->getInsertId();

        return $this;

    }

    protected function update() {

        try {

            $result = Model::update($this->database, $this->id, $this->name, $this->description, $this->package);

        } catch (DatabaseException $de) {

            throw $de;

        }

        return $this;

    }

    public function delete() {

        try {

            $result = Model::delete($this->database, $this->id);

        } catch (DatabaseException $de) {

            throw $de;

        }

        $this->setData(array(0, "", "", ""));

        return $this;

    }

}
