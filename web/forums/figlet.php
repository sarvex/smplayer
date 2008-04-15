<?php

$figlet_secret = "Type your random text here...";

function generate_figlet_string () {
	$figlet_size = 5;                       # how many caracters do you want the string to be?
	$figlet_file = "./figlet/Figlet.php";   # include the PEAR figlet file
	$figlet_font = "./figlet/standard.flf"; # where is the text definition file

        $characters = array (
                        'a','b','c','d','e','f','g','h','i','j','k',
                        'l','m','n','o','p','q','r','s','t','u','v',
                        'w','x','y','z','0','1','2','3','4','5','6',
                        '7','8','9',
                        );

        shuffle ($characters);

        $random = array_rand ($characters, $figlet_size);
        $array = array (0 => '',
                        1 => '',
                        2 => '',
                );

        foreach ($random as $value) {
                $array[0] .= " " . $characters[$value];
                $array[1] .=       $characters[$value];
        }

        include_once $figlet_file;
        $figlet = new Text_Figlet();
        $figlet->loadFont($figlet_font);

        $array[2] = $figlet->lineEcho($array[0]);

        return $array;
}

function check_figlet () {
        global $figlet_secret;

        if (!isset ($_POST['secret1']) || $_POST['secret1'] == "") {
                $secret1 = null;
        }
        else {
                $secret1 = strtolower ($_POST['secret1']);
        }
        if (!isset ($_POST['secret2']) || $_POST['secret2'] == "") {
                $secret2 = null;
        }
        else {
                $secret2 = $_POST['secret2'];
        }

        if (md5 ($figlet_secret . $secret1) == $secret2) {
                return true;
        }
        else {
                return false;
        }
}

function print_figlet () {
        global $figlet_secret;
        ?>

                       <div class="inform">
                                <fieldset>
                                        <legend>Spam protection</legend>
                                                <div class="infldset">

                                                <?php
                                                        $string = generate_figlet_string ();
                                                        echo "<pre>\n";
                                                        echo $string[2];
                                                        echo "</pre>";
                                                ?>

                                                <p><input type="text" name="secret1" size="30" maxlength="80" />
                                                <input type="hidden" name="secret2" value="<?php echo md5 ($figlet_secret . $string[1]); ?>" /></p>
                                                </div>
                                </fieldset>
                        </div>

        <?php
}

?>
