<?php
namespace blocapp\modules\admin\Forms;
 

use Smartedutech\Littlemvc\Form\Form; 
use Smartedutech\Littlemvc\dbadapter; 

class formroles extends Form
{

    public function __construct($nameform, \Smartedutech\Littlemvc\Form\Elements $ElementForm = null, \Smartedutech\Littlemvc\Form\FormStructer $FormData = Null)
    {
        parent::__construct($nameform, $ElementForm, $FormData);
        $this->setDecorator_Template();
        $this->FormAttrib->setTitle("roles");
          $this->FormAttrib->setId("roles");

        $this->addElement("idroles",array(
            "type"=>"text"
            ,"options"=>array(
            "other"=>array(
            "min"=>0
            ,"max"=>"45"
            ,"placeholder"=>"idroles"
            ,"required"=>"required"
            ,"title"=>"idroles"
        )
    )
    ,"name"=>"idroles"
    ,"label"=>"idroles"
 ));


$this->addElement("labelrole",array(
            "type"=>"text"
            ,"options"=>array(
            "other"=>array(
            "min"=>0
            ,"max"=>"255"
            ,"placeholder"=>"labelrole"
            ,"required"=>""
            ,"title"=>"labelrole"
        )
    )
    ,"name"=>"labelrole"
    ,"label"=>"labelrole"
 ));


$this->addElement("descroles",array(
    "type"=>"textarea"
    ,"options"=>array(
        "other"=>array(
        "rows"=>3
        ,"cols"=>50
        ,"required"=>""
        ,"title"=>"descroles"
        )
    )
    ,"name"=>"descroles"
    ,"label"=>"descroles"
));

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
