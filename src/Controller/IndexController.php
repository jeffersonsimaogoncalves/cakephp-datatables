<?php
/**
 * Created by PhpStorm.
 * User: Jefferson Simão Gonçalves
 * Email: gerson.simao.92@gmail.com
 * Date: 12/07/2018
 * Time: 22:10
 */

namespace DataTables\Controller;

use Cake\Controller\Controller;

class IndexController extends Controller
{
    public function initialize()
    {
        $this->loadComponent('Cookie', [
            'expires' => '+3 month',
        ]);
    }

    public function start()
    {
        $table = $this->request->getData('table');
        $page = (int)$this->request->getData('page');
        $this->Cookie->write($table . '_dStart', $page);
    }

    public function length()
    {
        $table = $this->request->getData('table');
        $length = (int)$this->request->getData('length');
        $this->Cookie->write($table . '_dLength', $length);
    }
}