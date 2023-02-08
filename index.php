<?php 
require_once "inc/functions.php";
$info = '';
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';
if('delete' == $task){
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if($id>0){
        deleteStudent($id);
        header('location: /index.php?task=report');
    }
}
if('seed' == $task){
    seed();
    $info = 'Seeding is complete';
}

$fnamae = '';
$lname = '';
$roll = '';
if(isset($_POST['submit'])){
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    if($id){
        //Update the existing student
        if($fname !='' && $lname !='' && $roll !=''){
            $result = updateStudent($id, $fname, $lname, $roll);
            if($result){
                header('location: /index.php?task=report');
            }else{
                $error = 1;
            }
        }
    }else{
        //Add a new student
        if($fname !='' && $lname !='' && $roll !=''){
            $result = addStudent($fname, $lname, $roll);
            if($result){
                header('location: /index.php?task=report');
            }else{
                $error = 1;
            }
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="css/milligram.css" type="text/css" />
    <link rel="stylesheet" href="css/normalize.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
    <!-- Header Area Start -->
    <header class="header_area"> 
        <div class="contianer"> 
         <marquee>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum accusantium adipisci tempore qui mollitia dolorum impedit consequatur, architecto libero ullam! Ea cupiditate aut ipsum dicta, magnam dolor provident quidem corporis.</marquee>
        </div>
    </header>
    <!-- Header Area Stop -->

    <!-- CRUD Area Start -->
    <section class="crud_project"> 
        <div class="container"> 
            <div class="row"> 
                <div class="column column-60 column-offset-20"> 
                    <h2> Project - CRUD</h2>
                    <p>A Sample Project to perform CRUD Operations Using plain files and PHP </p>
                    <?php include_once('inc/templates/nav.php'); ?>
                    <hr />
                    <?php 
                        if($info != ''){
                            echo "<p> {$info} </p>";
                        }
                    ?>
                </div>
            </div>

        <?php if('1' == $error): ?> <!-- Error Code -->
            <div class="row"> 
                <div class="column column-60 column-offset-20"> 
                    <blockquote> 
                        Duplicate Roll Number
                    </blockquote>
                </div>
            </div>
        <?php endif; ?>   <!-- Error Code -->

        <?php if('report' == $task): ?> <!-- Report Generate Code -->
            <div class="row"> 
                <div class="column column-60 column-offset-20"> 
                    <?php generateReport(); ?>
                </div>
            </div>
        <?php endif; ?>   <!-- Report Generate Code -->

        <?php if('add' == $task): ?> <!-- Add Student Form Code -->
            <div class="row"> 
                <div class="column column-60 column-offset-20"> 
                    <form action="/index.php?task=add" method="POST">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>" />
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>" />
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" value="<?php echo $roll; ?>" /> <br><br>	
                        <button type="submit" class="button-primary" name="submit">Save</button>
                    </form>
                </div>
            </div>
        <?php endif; ?><!-- Add Student Form Code -->
        
        <?php 
            if('edit' == $task): 
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
            $student = getStudent($id);
            if($student) :
        ?> <!-- Edit Student Form Code -->
            <div class="row"> 
                <div class="column column-60 column-offset-20"> 
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>" />
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $student['lname'];; ?>" />
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>" />
                        <button type="submit" class="button-primary" name="submit">Update</button>
                    </form>
                </div>
            </div>
        <?php 
            endif; 
            endif;
        ?><!-- Edit Student Form Code -->

        </div>
    </section>
    <!-- CRUD Area Stop -->

    <!-- Footer Area Stop -->
    <footer class="copyright_area"> 
        <div class="container"> 
            <p>Copyright &copy; <a href="https://www.facebook.com/w3sarwar">Golam Sarwar</a> | Reserved All Content 2023</p>
        </div>
    </footer>
    <!-- Footer Area Stop -->

    <!-- JavaScript file include -->
    <script src="assets/js/main.js"></script>
</body>
</html>