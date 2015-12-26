<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 22.09.15
 * Time: 12:14
 */
namespace View;
use Model;
$params= include 'Conf/params.php';

$planner = new \Model\Planner();

?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>Planner</title>
</head>
<body>
<h2>Today is <?php echo $date = date("F d, Y");?></h2>
<div>
    <table class="">
        <tr>
        <col width="100">
        <col width="100">
        <col width="300">
        <col width="50">
        <col width="50">
            <th>Date</th>
        <th>Time</th>
        <th>Task</th>
        </tr>
        <?php
        foreach($planner->getAllTasks() as $row)
        {
            if ($row['is_deleted'] == 0)
            {
              ?>
              <tr>
                  <td><?php echo $row['date'] ?></td>
                  <td><?php echo $row['time'] ?></td>
                  <?php
                  if ($row['is_done'] == 1)
                  {
                      ?>
                      <td class="strike"><img title="Done!" src="<?php echo $params['local_domain'] ?>img/check_mark.png"
                                              height="20" width="20" align="absmiddle"><?php echo " ".$row['name']; ?></td>
                      <td></td> <!--empty cell to display nice-->
                      <?php
                  } else {
                      ?>
                      <td class="task-name"><?php echo $row['name'] ?></td>
                      <td><a title="Mark as done" href="<?php echo $params['local_domain'].'planner/done/' . $row['id'] ?>">Done</a></td>

                      <?php
                  }
                  ?>

                  <td><a title="Delete note" href="<?php echo $params['local_domain'].'planner/delete/' . $row['id'] ?>">Delete</a></td>
              </tr>

              <?php
            }
        }
        ?>
        <form action="<?php echo $params['local_domain'] ?>planner/add/" method="POST">
            <input type="text" title="Add new note" placeholder="Add new note" name="new_user_note">
            <input type="submit" title="Add new note" value="Add" >
        </form>

    </table>
</div>
</body>
</html>



