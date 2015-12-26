<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 22.09.15
 * Time: 13:45
 */
namespace Model;
use Model;
include 'Validate.php';


class Planner
{
    protected $date;
    protected $time;
    protected $name;
    protected $is_done;
    protected $is_deleted;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIsDone()
    {
        return $this->is_done;
    }

    /**
     * @param mixed $is_done
     */
    public function setIsDone($is_done)
    {
        $this->is_done = $is_done;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }


    /**
     * Function to get all tasks from DB
     * @return array
     */
    public function getAllTasks()
    {
        $conn = DB::getConnection();
        $query_to_get_all_tasks = 'SELECT * FROM task GROUP BY `date`,`time`';
        $all_tasks = [];
        foreach ($conn->query($query_to_get_all_tasks) as $row) {
            $value = array_push($all_tasks, $row);
        }
        return $all_tasks;
    }

    /**
     * Function to mark one task as deleted (status in DB changed to is_deleted=1)
     * @param $id
     */
    public function deleteOneTask($id)
    {
        $conn = Model\Db::getConnection();
        $query_to_delete_one_task = 'UPDATE `task` SET `is_deleted`=1 WHERE `id`='.$id;
        $stmt=$conn->prepare($query_to_delete_one_task);
        $stmt->execute();
    }

    /**
     * Function to mark task as done (status in DB changed to is_done=1)
     * @param $id
     */
    public function markAsDone($id)
    {
        $conn = Model\Db::getConnection();
        $query_to_mark_task_as_done = 'UPDATE `task` SET `is_done`=1 WHERE `id`='.$id;
        $stmt=$conn->prepare($query_to_mark_task_as_done);
        $stmt->execute();
    }

//    public function editTask($id, $edited_task)
//    {
//        $new_task = Validate::cleanInput($edited_task);
//        if($edited_task!="") { //not to allow to add empty task
//            $conn = Model\Db::getConnection();
//            $query_to_edit_task = 'UPDATE `task` SET `name`='.$edited_task.' WHERE `id`=' . $id;
//            $stmt = $conn->prepare($query_to_edit_task);
//            $stmt->execute();
//        }
//    }


    /**
     * Function to create new task, validate and save it to DB
     * @param $new_task - user input - task
     */
    public function createNewTask($new_task)
    {
        $new_task = Validate::cleanInput($new_task);
        if($new_task!=""){ //not to allow to add empty task
            $conn = Model\Db::getConnection();
            $query_to_create_new_task = 'INSERT INTO `task`(`date`, `name`, `is_done`, `is_deleted`, `time`) VALUES (?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($query_to_create_new_task);
            $stmt->bindParam(1, $date);
            $stmt->bindParam(2, $name);
            $stmt->bindParam(3, $is_done);
            $stmt->bindParam(4, $is_deleted);
            $stmt->bindParam(5, $time);
            $stmt->execute();

            $date = date("Y-m-d");
            $name=$new_task;
            $is_done=0;
            $is_deleted=0;
            $time = date ("H:i:s");
            $stmt->execute();
        }
    }


    /**
     * Function to render view
     */
    public function render()
    {
        include __DIR__ . '/../View/planner.php';
    }
}