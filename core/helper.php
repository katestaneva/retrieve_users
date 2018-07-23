<?php
/* 
 * File: core/helper.php
 * 
 * PHP: v5.6
 * 
 * Description: helper class aggregares static methods solving 
 * various routine tesks
 * 
 * Author: Ekaterina Staneva
 * 
 * Git:  https://github.com/katestaneva/users_RESTA_API.git
 */

class Helper{
     /*  custom data sanitisation pipeline */
    public static function sanitize($input) {
        if (is_array($input)) {
            foreach($input as $var=>$val) {
                $output[$var] = sanitize($val);
            }
        }else{
            //manual regex strip tags in case build-in misses some
            $output  =  self::cleanInput($input);
            
            //build-in stript tags in case cleanInput misses some
            $output = htmlspecialchars(strip_tags($input));
        }
        
        return $output;
    }
    
    private static function cleanInput($input) {
        $search = array(
          '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
          '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
          '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
          '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );

        $output = preg_replace($search, '', $input);
        return $output;
     }
     
     public static function GenerateToken(){
         
     }
}

