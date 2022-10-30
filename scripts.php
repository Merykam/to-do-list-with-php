<?php
    //INCLUDE DATABASE FILE
    include('database.php');
    
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();
    

    function getTasks($tstatus)
    
    {
        global $conn;
        // include('database.php');
        //CODE HERE
        $req ="select * from tasks";
        $query=mysqli_query($conn,$req);
        while($row=mysqli_fetch_assoc($query)){
        //SQL SELECT
        if($tstatus == 1){$icon = "fa-regular fa-circle-question ";$color="danger";};
        if($tstatus == 2){$icon = "fas fa-circle-notch fa-spin";$color="warning";};
        if($tstatus == 3){$icon = "fa-regular fa-circle-check";$color="green";};
        if($row['status_id'] == $tstatus){ 
            $priority = $row['priority_id']==1  ? "Low" :($row['priority_id']==2 ? "Medium" :(($row['priority_id']==3)? "High" :"Critical")); 
            $type = $row['type_id']==1 ? "Feature" : "Bug";
            $id = $row['id'];
            echo '<button id="'.$id.'" title="'.$row['title'].'" time="'.$row['tasks_datetime'].'" description="'.$row['description'].'" Status="'.$row['status_id'].'" priority="'.$row['priority_id'].'"  class="bg-transparent w-100 border-0 border-bottom d-flex text-start pb-3" data-bs-toggle="modal" href="#modal-task" onclick="btn('.$id.')">
            <div class="col-1 fs-3 text-'.$color.' me-10px">
                <i class="'.$icon.'"></i>
            </div>
            <div class="col-11">
                <div class="fs-4">'.$row['title'].'</div>
                <div class="">
                    <div class="text-gray">#'.$row['id'].' created in '.$row['tasks_datetime'].'</div>
                    <div class="fs-5 mb-10px" title="'.$row['description'].'">'.$row['description'].'</div>
                </div>
                <div class="w-300px">
                    <span class="bg-blue-600 text-white  fs-5 rounded-2 px-15px py-5px " status="'.$row['status_id'].'" id="priority'.$id.'" data="'.$row['priority_id'].'" >'.$priority.'</span>
                    <span class="bg-gray-300 text-black m-2 fs-5 rounded-2 px-15px py-5px" id="type'.$id.'" data="'.$row['type_id'].'">'.$type.'</span>
                </div>
            </div>
            </button>';
        }}
    }


    function saveTask()
    {
        
        include('database.php');
        //CODE HERE
        global $conn;
        $title=$_POST['title'];
        $type_id=$_POST['task-type'];
        $priority_id=$_POST['priority'];
        $status_id=$_POST['status'];
        $tasks_datetime=$_POST['date'];
        $description=$_POST['description'];

        $sql="INSERT INTO `tasks` (`title`,`type_id`,`priority_id`,`status_id`,`tasks_datetime`,`description`)
        values ('$title','$type_id','$priority_id','$status_id','$tasks_datetime','$description')";

       

        $result=mysqli_query($conn,$sql);

        //SQL INSERT
        $_SESSION['message'] = "Task has been added successfully !";
		header('location: index.php');
    }

    function updateTask()
    {
        //CODE HERE
        //SQL UPDATE
        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
    }

    function deleteTask()
    {
        //CODE HERE
        global $conn;
        $id=$_POST['task-id'];
        $req="DELETE FROM `tasks` WHERE `id`=$id";
        $res=mysqli_query($conn,$req);
        //SQL DELETE
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
    }
   

?>