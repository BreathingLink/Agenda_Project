
        <!-- Deboggage -->
        <script>
            var debug = [
<?php
    function setDebug($array, $varName, $indent = '') {
        echo "                '" . $indent . ((gettype($varName) == 'string') ? "\'" . $varName . "\'" : $varName) . ' => array (size=' . count($array) . ")',\n";
        $indent .= '    ';

        foreach ($array as $key => $value) {
            if (gettype($value) == 'array')
                setDebug($value, $key, $indent);
            else
                echo "                '" . $indent . ((gettype($key) == 'string') ? "\'" . $key . "\'" : $key) . ' => ' . gettype($value) . ' '
                    . ((gettype($value) == 'string') ? "\'" . $value . "\' (length=" . strlen($value) . ')' : $value) . "',\n";
        }
    }

    setDebug($_GET, '$_GET');
    setDebug($_POST, '$_POST');
    setDebug($_SESSION, '$_SESSION');
    setDebug($_COOKIE, '$_COOKIE');
?>
                ''
            ];

            debug.forEach(function (value) { console.log(value); });
        </script>
