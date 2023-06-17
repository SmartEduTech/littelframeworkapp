<?php
namespace blocapp\modules\admin\Forms;
 

use Smartedutech\Littlemvc\Form\Form; 
use Smartedutech\Littlemvc\dbadapter; 

class formpersonnes extends Form
{

    public function __construct($nameform, \Smartedutech\Littlemvc\Form\Elements $ElementForm = null, \Smartedutech\Littlemvc\Form\FormStructer $FormData = Null)
    {
        parent::__construct($nameform, $ElementForm, $FormData);
        $this->setDecorator_Template();
        $this->FormAttrib->setTitle("personnes");
          $this->FormAttrib->setId("personnes");

        $this->addElement("nom",array(
            "type"=>"text"
            ,"options"=>array(
            "other"=>array(
            "min"=>0
            ,"max"=>"125"
            ,"placeholder"=>"nom"
            ,"required"=>""
            ,"title"=>"nom"
        )
    )
    ,"name"=>"nom"
    ,"label"=>"nom"
 ));


$this->addElement("prenom",array(
            "type"=>"text"
            ,"options"=>array(
            "other"=>array(
            "min"=>0
            ,"max"=>"125"
            ,"placeholder"=>"prenom"
            ,"required"=>""
            ,"title"=>"prenom"
        )
    )
    ,"name"=>"prenom"
    ,"label"=>"prenom"
 ));


$this->addElement("login",array(
    "type"=>"textarea"
    ,"options"=>array(
        "other"=>array(
        "rows"=>3
        ,"cols"=>50
        ,"required"=>""
        ,"title"=>"login"
        )
    )
    ,"name"=>"login"
    ,"label"=>"login"
));
$this->addElement("pwd",array(
    "type"=>"textarea"
    ,"options"=>array(
        "other"=>array(
        "rows"=>3
        ,"cols"=>50
        ,"required"=>""
        ,"title"=>"pwd"
        )
    )
    ,"name"=>"pwd"
    ,"label"=>"pwd"
));

$optionsroles_idroles=$this->Selectroles();
$this->addElement("roles_idroles",array(
            "type"=>"select"
            ,"list"=>$optionsroles_idroles
            ,"options"=>array(
            "other"=>array(
                "placeholder"=>"roles_idroles"
                ,"required"=>""
                ,"title"=>"roles_idroles"
         )
        )
,"name"=>"roles_idroles"
,"label"=>"roles_idroles"
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
    
public function Selectroles(){
    $options[""]="Selectionner";
    $Recroles=dbadapter::SelectSQL("SELECT * FROM roles");
    foreach ($Recroles as $r){
        $options[$r['idroles']]=$r[1];

    }
    return $options;
}

}
