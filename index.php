<?php

// for debugging
$env = 'prod';
if ($_SERVER['HTTP_HOST'] == 'localhost')
    $env = 'dev';

if ($env === 'dev'){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// read settings file
$read = '';
$file = fopen('./private/config/config.json', 'r');
while($line = fgets($file)){
    $read .= $line;
}
fclose($file);

$settings = json_decode($read, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($settings["websiteTitle"])) echo $settings["websiteTitle"]; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./public/styles/base.css">
    <link rel="stylesheet" href="./public/styles/main.css">
</head>
<body>

    <div id="navbar">
        <div class="nav-sect">
            <div id="profile-pic-div">
                <img src="./public/images/IMG_20190410_073717.jpg">
            </div>
            <h2 class="h1-big"><?php if (isset($settings["profileName"])) echo $settings["profileName"]; ?></h2>
        </div>

        <button id="btn-menu"><i class="fa fa-bars" style="font-size:26px; color: black;" onclick="toggleMenu()"></i></button>

        <div class="nav-sect" id="col-nav">
            <button class="btn-primary" onclick="messageMe()"><i class="fa fa-envelope" style="font-size:26px"></i>Message me</button>
            <button class="btn-primary" onclick="visit('<?php if(isset($settings["cvLink"])) echo $settings["cvLink"]; ?>')"><i class="fa fa-download" style="font-size:26px"></i>Download CV</button>
        </div>
    </div>

    <div id="intro">
        <div>
            <div class="intro-sect">
                <h1 style="padding-bottom: 0; margin-bottom: 0;"><?php if (isset($settings["jobTitle"])) echo $settings["jobTitle"]; ?></h1>
                <p style="margin-top: 0; padding-top: 0;"><?php if (isset($settings["jobSubtitle"])) echo $settings["jobSubtitle"]; ?></p>
            </div>
            <div class="intro-sect">
                <?php 
                
                if (isset($settings["socialLinks"])) {
                    for ($i = 0; $i < count($settings["socialLinks"]); $i++){
                        echo '<button class="btn-neutral" onclick="visit(' . $settings["socialLinks"][$i]["link"] . ')"><i class="fa fa-' . $settings["socialLinks"][$i]["type"] . '"></i>' . $settings["socialLinks"][$i]["name"] . '</button>';
                    }
                }

                ?>
                
            </div>
        </div>
    </div>

    <div id="messageBox">
        <form id="contactMeForm" method="POST" action="contact_me.php">
            <div id="formClose" onclick="closeMessageBox()"><i class="fa fa-close"></i></div>
            <h2>Message Me</h2>
            
            <label>Email</label>
            <input id="inputEmail" name="inputEmail" placeholder="Enter email here" required>
            
            <label>Name</label>
            <input id="inputName" name="inputName" placeholder="Enter name here" required>
        
            <label>Message</label>
            <textarea id="inputMessage" name="inputMessage" rows="3" placeholder="" required></textarea>
            
            <button class="btn-possitive" type="submit" id="formSubmit" >Send</button>
        </form>
    </div>

    <?php

        if (isset($settings["notes"])){
            echo '<div id="messages">';
            for ($i = 0; $i < count($settings["notes"]); $i++){
                echo '<div class="note">' . nl2br($settings["notes"][$i]) . '</div>';
            }
            echo '</div>';
        }

    ?>
    
    <?php
        if (isset($settings["projects"])){
            echo '<div id="projects">
            <h1 class="h1-big" style="margin: auto">Portfolio</h1>';

            for ($i = 0; $i < count($settings["projects"]); $i++){
                echo '
                <div class="project">
                    <div class="proj-img-div">
                        <img src="./public/images/' . $settings["projects"][$i]["imagePath"] . '">
                    </div>
                    <div class="proj-sect">
                        <h2>' . $settings["projects"][$i]["projectTitle"] . '</h2>
                        <p class="proj-description">' . nl2br($settings["projects"][$i]["projectDescription"]) . '</p>
                        <div class="proj-stack">';

                        for ($j = 0; $j < count($settings["projects"][$i]["projectStack"]); $j++){
                            echo '
                            <div class="proj-tool">
                                <span class="tool-name">' . $settings["projects"][$i]["projectStack"][$j]["name"] . '</span>
                                <span class="tool-version">' . $settings["projects"][$i]["projectStack"][$j]["version"] . '</span>
                            </div>';
                        }
                        echo '</div>
                    </div>
                </div>';
            }

            echo '</div>';
        }
    ?>

    <div id="scrollToTop" onclick="gotoTop()">
        <i class="fa fa-arrow-circle-up"></i>
    </div>

    <script src="./public/scripts/main.js"></script>

    <?php 
        if (isset($_GET["message"])){
            echo '<script>alert("' . $_GET["message"] . '")</script>';
        }
    ?>

    <div id="footer">
        <p>Copyright &copy; 2020 Steven Mokoena</p>
        <p>website source code is licensed under the MIT license. Read it <a href="./license.txt" target="_blank">here</a>.
            This does not necessarily include other contents on this site
            such as content featured on external links, pictures, logo's, projects or other tools.
        </p>
    </div>

</body>
</html>