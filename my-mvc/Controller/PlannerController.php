<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 22.09.15
 * Time: 12:12
 */

namespace Controller;
use Model;
use View;


class PlannerController
{
    /** @var array $params */
    protected $params;

    /**
     * Constructor to include $params
     * @param $params - array with parameters
     */
    public function __construct($params)
    {
        $params = include '../Conf/params.php';
    }


    /**
     * Displays view page
     */
    public function view()
    {
        $planner = new Model\Planner();
        $planner->render();
    }

    /**
     * Adds new task, and redirects to display page
     */
    public function add()
    {
        $new_task = $_POST['new_user_note'];
        $planner = new Model\Planner();
        $planner->createNewTask($new_task);
        //$planner->render(); работает, но в заголовке остается бред - done/67,  delete/45,  add/ и т.д.
        header('Location:http://mytest.me/my-mvc/planner/view/');
        //exit;
    }

    /**
     * Deletes task from view page (archives in DB)
     * @param $id - $id of task to delete(archive)
     */
    public function delete($id)
    {
        $id_to_delete = $id;
        $planner = new Model\Planner();
        $planner->deleteOneTask($id_to_delete);
        header('Location:http://mytest.me/my-mvc/planner/view/');
    }

    /**
     * Marks as Done task from view page
     * @param $id - $id of task to mark as Done
     */
    public function done($id)
    {
        $id_to_mark_as_done = $id;
        $planner = new Model\Planner();
        $planner->markAsDone($id_to_mark_as_done);
        header('Location:http://mytest.me/my-mvc/planner/view/');
    }

//    public function edit($id)
//    {
//        $edited_task = $_POST['edit_note'];
//        if(isset($edited_task) && $edited_task!="")
//        {
//            $planner = new Model\Planner();
//            $planner->editTask($id, $edited_task);
//            $this->view();
//        } else {
//            $this->view();
//        }
//
//
//        //header('Location:/day-18/my-mvc/planner/view/');
//    }
}
