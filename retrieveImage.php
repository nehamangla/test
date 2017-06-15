<!DOCTYPE html>
<html>
    <head>
        <style>
            div.gallery {
                margin: 5px;
                border: 1px solid #ccc;
                float: left;
                width: 180px;
            }

            div.gallery:hover {
                border: 1px solid #777;
            }

            div.gallery img {
                width: 100%;
                height: auto;
            }

            div.desc {
                padding: 15px;
                text-align: center;
            }
            .parentGrid{
                width: 100%;
            }
        </style>
    </head>
    <body>
        <?php
        error_reporting(E_ERROR);
        ini_set('display_errors', 1);

        require_once('config/dbConnect.php');
        include('config/config.php');
        include 'functions.php';
        $data = array();

//session start to run the program individually
//$_POST['response'] = "Which city do you want to go?";
        if ($_POST['response']) {
            $f = fopen("response.txt", 'w');
            fwrite($f, $_POST['response']);
        }

        $resp = file_get_contents("response.txt");

        if ($resp) {
            $ret_data_qry = "select * from image_text_data where text like '%$resp%' and status=1";
            $ret_data = mysql_query($ret_data_qry);

            while ($row = mysql_fetch_assoc($ret_data)) {
                $data[] = $row;
                $slag = explode('#', $row['slag']);
                $slag = remove_blank_element($slag);
            }

            if (!empty($data)) {
                echo '<div class="parentGrid">';
                foreach ($data as $value) {
                    $image = IMAGE_PATH . $value['image'];
                    if (file_exists($image)) {
                        ?>
                        <div class="gallery">
                            <a target="_blank" href="<?php echo $image; ?>">
                                <img src="<?php echo $image; ?>" alt="<?php echo $image; ?>" width="300" height="200">
                            </a>
                            <?php if($value['description']) {?>
                            <div class="desc"><?php echo $value['description']; ?></div>
                    <?php } ?>
                        </div>
                <?php
            }
        }
        echo '</div>';
    }
}
?>
    </body>
</html>
