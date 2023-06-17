<?php
namespace blocapp\modules\admin\Forms;
 

use Smartedutech\Littlemvc\Form\Form; 
use Smartedutech\Littlemvc\dbadapter; 

class formtypeformation extends Form
{

    public function __construct($nameform, \Smartedutech\Littlemvc\Form\Elements $ElementForm = null, \Smartedutech\Littlemvc\Form\FormStructer $FormData = Null)
    {
        parent::__construct($nameform, $ElementForm, $FormData);
        $this->setDecorator_Template();
        $this->FormAttrib->setTitle("typeformation");
          $this->FormAttrib->setId("typeformation");

        $this->addElement("idtypeformation",array(
            "type"=>"text"
            ,"options"=>array(
            "other"=>array(
            "min"=>0
            ,"max"=>"45"
            ,"placeholder"=>"idtypeformation"
            ,"required"=>"required"
            ,"title"=>"idtypeformation"
        )
    )
    ,"name"=>"idtypeformation"
    ,"label"=>"idtypeformation"
 ));


$this->addElement("titretypeformation",array(
            "type"=>"text"
            ,"options"=>array(
            "other"=>array(
            "min"=>0
            ,"max"=>"255"
            ,"placeholder"=>"titretypeformation"
            ,"required"=>""
            ,"title"=>"titretypeformation"
        )
    )
    ,"name"=>"titretypeformation"
    ,"label"=>"titretypeformation"
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
