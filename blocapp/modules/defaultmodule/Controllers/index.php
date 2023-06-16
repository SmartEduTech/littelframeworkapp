<?php
/**
 * Created by {GENERATOR}.
 * User: {USER}
 * Date: {DATE}
 * Time: {DATE} {TIME}
 */

namespace blocapp\modules\defaultmodule\Controllers;

use Smartedutech\Littlemvc\mvc\Controller;
use Smartedutech\Littlemvc\mvc\View;
use Smartedutech\Littlemvc\dbadapter;
class index extends Controller
{
            /**
        * editanneescoolaire
        **/
        public function index(){
                $Vue=new View();
                $Vue->titre = "index";
                $Vue->generate();
        }
        


}
