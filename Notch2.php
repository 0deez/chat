<?php
 
session_start();
 
if(isset($_GET['logout'])){    
     
    //Simple exit message
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
    file_put_contents("log2.html", $logout_message, FILE_APPEND | LOCK_EX);
     
    session_destroy();
    header("Location: Notch2.php"); //Redirect the user
}
 
 // or "!" or "," or "<" or "." or ">" or "/" or "?" or ";" or ":" or "'" or '"' or "[" or "{" or "]" or "}" or "|" or "=" or "+" or "-" or "_" or "1" or "2" or "@" or "3" or "#" or "4" or "$" or "5" or "%" or "6" or "^" or "7" or "&" or "8" or "*" or "9" or "(" or "0" or ")"

if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
 
function loginForm(){
    echo
    '<div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="Notch2.php" method="post">
      <label for="name">Name &mdash;</label>
      <input type="text" name="name" id="name" />
      <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
  </div>';
}
 
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
 
        <title>Group Chater Thingy room2</title>
        <meta name="description" content="Chat Application" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
    <?php
    if(!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            </div>
 
            <div id="chatbox">
            <?php
            if(file_exists("log2.html") && filesize("log2.html") > 0){
                $contents = file_get_contents("log2.html");          
                echo $contents;
            }
            ?>
            </div>
 
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post2.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });
 
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
 
                    $.ajax({
                        url: "log2.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }   
                        }
                    });
                }
 
                setInterval (loadLog, 0500);
 
                $("#exit").click(function () {
                  var exit = confirm("Are you sure you want to end the session?");
                  if (exit == true) {
                  window.location = "Notch2.php?logout=true";
                  }
                });
            });
        </script>
      <h2>Next Session 2:00 Friday March 20  2021</h2>
      <h3>You are on server Notch2</h3>

    <button type="button" onclick="clearchat()" id="clearchat">Clear Chat</button>

    <script>
    function clearchat() {
        $.ajax({
            url:"script.php",    //the page containing php script
            type: "post",    //request type,
            success:function(result){
              console.log("Cleared Chat");
            }
        });
    }
  </script>

    </body>
</html>
<?php
}
?>