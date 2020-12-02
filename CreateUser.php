<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User Interface</title>
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        form {border: 3px solid #f1f1f1;}

        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
          }
          
          button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
          }
          
          button:hover {
            opacity: 0.8;
          }
          
          .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
          }
          
          .container {
            padding: 16px;
          }
          
          .topnav {
          overflow: hidden;
          background-color: #333;
        }
        
        .topnav a {
          float: left;
          color: #f2f2f2;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
          font-size: 17px;
        }
        
        .topnav a:hover {
          background-color: #ddd;
          color: black;
        }
        
        .topnav a.active {
          background-color: #4CAF50;
          color: white;
        }
    </style>
</head>
<body>
    <div class="topnav">
        <a href="CreateUser.html">Create User</a>
        <a href="CreatePosts.html">Create Posts</a>
    </div>
    <?php
        $mysqli = new mysqli("mysql.eecs.ku.edu", "linhnguyen", "aadaeR4k", "linhnguyen");
        
        /* Empty user_id */
        $user_id = $_POST['username'];
        if($user_id == '') error("The user left the text field empty");
        else{
            /* Check connection*/
            if ($mysqli->connect_errno) {
                printf("Connect failed: %s\n", $mysqli->connect_error);
                exit();
            }else{
                // Get all users with the same username
                $query = $mysqli -> prepare("SELECT count(*) FROM Users WHERE user_id = ?");
                $query -> bind_param("s", $user_id);
                $query -> execute();
                // Get result to res
                $query -> bind_result($res);
                $query -> fetch();
                $query -> close();
                // Username is taken
                if($res > 0) error("The user already exists");
                // Username is not taken
                else{
                    // Insert username into Users table
                    $query = $mysqli -> prepare("INSERT INTO Users (user_id)  VALUES (?)");
                    $query -> bind_param("s", $user_id);
                    $query -> execute();
                    $query -> close();
                    echo "<h1> User created successfully </h1>";

                }
                $mysqli -> close();
            }
        }
        
        // Error message output function
        function error($msg) {
            ?>
            <form method="GET" action="CreateUser.html"> 
                <div class="container" style="background-color:#f1f1f1">
                    <span>Error: <?=$msg?></span>
                    <button class="cancelbtn" type="submits">Try again!</button>
                </div>  
            </form>
            <?php
        }
    ?> 
    
</body>
</html>
