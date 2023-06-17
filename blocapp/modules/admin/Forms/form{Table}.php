<?php
namespace blocapp\modules\admin\Forms;
 

use Smartedutech\Littlemvc\Form\Form; 
use Smartedutech\Littlemvc\dbadapter; 

class form{Table} extends Form
{

    public function __construct($nameform, \Smartedutech\Littlemvc\Form\Elements $ElementForm = null, \Smartedutech\Littlemvc\Form\FormStructer $FormData = Null)
    {
        parent::__construct($nameform, $ElementForm, $FormData);
        $this->setDecorator_Template();
        $this->FormAttrib->setTitle("{Table}");
          $this->FormAttrib->setId("{Table}");

        

        $this->addElement("submit",array(

                "type"=>"submit"
                ,"options"=>array(
                        "other"=>array(
                            "class"=>"btn btn-success"
                        )
                    )
                ,"name"=>"Enregistrer"
                ,"label"=>"Enregistrer  "
                )
        );
        $this->addElement("reset",array(

                "type"=>"reset"
                ,"options"=>array(
                        "other"=>array(
                            "class"=>"btn btn-danger"
                        )
                    )
                ,"name"=>"Reset"
                ,"label"=>"Reset"
                )
        );
      

    }
    

}
