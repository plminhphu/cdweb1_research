<?php
include_once 'store.php';
$dir_pattern = "pattern";
$dir_check = @$_GET['path'];
if(@$_GET['path']){
	$dir_check = @$_GET['path'];
}else {
	$dir_check = "check/check1";
}

//Read directory to array
function dirToArray($dir) {
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }
    return $result;
}

//print structure
function review($array) {
    foreach ($array as $key => $value) {
        if (is_array($value) != null) {
            echo '<div class="container-fluid">';
            echo '<p><i class="far fa-folder-open"> - ' . $key . ' </i></p>';
            review($value);
            echo '</div>';
        } else {
            echo '<div class="container-fluid"><p><i class="far fa-file"> - ' . $value . ' </i></p></div>';
        }
    }
}

//check => result
function check($arr1, $arr2) {
	foreach ($arr1 as $key1 => $value1) {
		echo '<div class="container-fluid">';
		if (is_array($value1) != null){
			foreach ($arr2 as $key2 => $value2) {
		        if (is_array($value2) != null) {
		            if ($key1 == $key2) {
		            	echo '<p><i class="far fa-folder-open ok"> - ' . $key1 . ' <i class="far fa-check-circle"></i></i></p>';
		            	check($value1, $value2);
		            } else {
		            	if(in_array($key1, array_keys($value2))){
		            		echo '<p><i class="far fa-folder-open ko"> - ' . $key1 . ' <i class="far fa-question-circle"></i></i></p>';
		            		check($value1, $arr2);
		            	}
		            }
		        }
			}
		} else {
			if(in_array($value1, $arr2)){
				echo '<div class="container-fluid"><p><i class="far fa-file ok"> - ' . $value1 . ' <i class="far fa-check-circle"></i></i></p></div>';
			} else if (in_array($value1, array_intersect_key($arr1, $arr2))){
				echo '<div class="container-fluid"><p><i class="far fa-file ko"> - ' . $value1 . ' <i class="far fa-question-circle"></i></i></p></div>';
			}
		}
		// check($value1, $arr2);
		echo '</div>';	
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="PL Minh Phu - Research - File check">
        <meta name="author" content="PL Minh Phu">
        <meta name="keywords" content="PL Minh Phu - Research - File check">
        <title>Research</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link href="css/font-face.css" rel="stylesheet" media="all">
        <link href="css/theme.css" rel="stylesheet" media="all">
        <style>
            .ok{
                color: green;
            }
            .ko{
                color: red;
            }
        </style>
    </head>
    <body style="font-size: 1.0em;">
        <div class="row" style="background-color: #f8f9fa;">
            <div class="col-md-4">
                <div class="container">
                    <br><hr>
                    <h3>Sample structure</h3>
                    <p>Size: <?php echo ViewByte(GetDirectorySize($dir_pattern)); ?></p>
                    <div class="table-responsive table-data">
                        <table class="table">
                            <tbody>
                                <?php
                                $array_dir_pattern = dirToArray($dir_pattern);
                                echo review($array_dir_pattern);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container">
                    <form class="form-inline" action="#" method="GET">
                        <div class="form-group">
                            <label for="path">Path : </label>
                            <input type="path" class="form-control" id="path" placeholder="Please enter path" name="path" value="<?php echo @$dir_check; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Check</button>
                    </form>
                    <hr>
                    <h3>Check structure</h3>
                    <p>Size: <?php echo ViewByte(GetDirectorySize($dir_check)); ?></p>
                    <div class="table-responsive table-data">
                        <table class="table">
                            <tbody>
                                <?php
                                $array_dir_check = @dirToArray($dir_check);
                                if ($array_dir_check) {
                                    echo review($array_dir_check);
                                } else {
                                    echo "Empty!!";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container">
                    <br><hr>
                    <h3>Result</h3>
                    <p><i class="far fa-check-circle ok"> OK </i> - <i class="far fa-question-circle ko"> NO OK </i></p>
                    <hr>
                    <div class="table-responsive table-data">
                        <table class="table">
                            <tbody>
                                <?php
                                if ($array_dir_check != null) {
                                    echo check($array_dir_pattern, $array_dir_check);
                                } else {
                                    echo "Empty!!";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/main.js"></script>
    </body>
</html>
