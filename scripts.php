<?php
    //INCLUDE DATABASE FILE
    include('database.php');
    
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))       saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();
    

    function getTasks($status)
    {
        global $conn;
        //CODE HERE
        $req="SELECT tasks.*,priorities.name as priorityN,statuses.name as statusesN,types.name as typesN FROM tasks 
        INNER JOIN priorities ON tasks.priority_id = priorities.id
        INNER JOIN statuses ON tasks.status_id = statuses.id
        INNER JOIN types ON tasks.type_id = types.id;";

        $query=mysqli_query($conn,$req);
        
        while($row=mysqli_fetch_assoc($query)){
        //SQL SELECT
        if($row['statusesN'] == 'To Do'){$icon = "fa-regular fa-circle-question ";$color="danger";};
        if($row['statusesN'] == 'In progress'){$icon = "fas fa-circle-notch fa-spin";$color="warning";};
        if($row['statusesN'] == 'Done'){$icon = "fa-regular fa-circle-check";$color="green";};
        if($row['statusesN'] == $status){
            $id = $row['id'];
            echo '<button id="'.$row['id'].'" title="'.$row['title'].'" time="'.$row['task_datetime'].'" description="'.$row['description'].'" type="'.$row['typesN'].'" Status="'.$row['status_id'].'" priority="'.$row['priority_id'].'"  class="bg-transparent w-100 border-0 border-bottom d-flex text-start pb-3" data-bs-toggle="modal" href="#modal-task" onclick="btn('.$id.')">
            <div class="col-1 fs-3 text-'.$color.' me-10px mt-7px">
                <i class="'.$icon.'"></i>
            </div>
            <div class="col-11">
                <div class="fs-4">'.$row['title'].'</div>
                <div class="">
                    <div class="text-gray">#'.$row['id'].' created in '.$row['task_datetime'].'</div>
                    <div class="fs-5 mb-10px" >'.$row['description'].'</div>
                </div>
                <div class="w-300px">
                    <span class="bg-blue-600 text-white  fs-5 rounded-2 px-15px py-5px">'.$row['priorityN'].'</span>
                    <span class="bg-gray-300 text-black m-2 fs-5 rounded-2 px-15px py-5px">'.$row['typesN'].'</span>
                </div>
            </div>
            </button>';
        }}
    }


    function saveTask()
   {
        //CODE HERE
        global $conn;
        $title=$_POST['title'];
        $type_id=$_POST['task-type'];
        $priority_id=$_POST['priority'];
        $status_id=$_POST['status'];
        $tasks_datetime=$_POST['date'];
        $description=$_POST['description'];

        $req="INSERT INTO `tasks` (`title`,`type_id`,`priority_id`,`status_id`,`task_datetime`,`description`)
        values ('$title','$type_id','$priority_id','$status_id','$tasks_datetime','$description')";

        mysqli_query($conn,$req);

        //SQL INSERT
        $_SESSION['message'] = "Task has been added successfully !";
		header('location: index.php');
    }

    function updateTask()
    {
        //CODE HERE
        //SQL UPDATE
        
        global $conn;
        $id=$_POST['task-id'];
        $title=$_POST['title'];
        $type_id=$_POST['task-type'];
        $priority_id=$_POST['priority'];
        $status_id=$_POST['status'];
        $tasks_datetime=$_POST['date'];
        $description=$_POST['description'];

        $req="UPDATE `tasks` SET `title`='$title',`type_id`='$type_id',`priority_id`='$priority_id',`status_id`='$status_id',`task_datetime`='$tasks_datetime',`description`='$description' WHERE `id`=$id";
        
        mysqli_query($conn,$req);
        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
    }

    function deleteTask()
    {
        //CODE HERE
        global $conn;
        $id=$_POST['task-id'];
        $req="DELETE FROM `tasks` WHERE `id`=$id";
        mysqli_query($conn,$req);
        //SQL DELETE
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
    }

    function Countt($Status){
        global $conn;
        
        $sql = "SELECT *
                FROM tasks
                WHERE status_id =  $Status";

        $req = mysqli_query($conn, $sql);

        $rowcount = mysqli_num_rows($req);

        echo $rowcount;
    }
   

?>