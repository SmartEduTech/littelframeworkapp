<?php
namespace blocapp\modules\admin\Forms;
 

use Smartedutech\Littlemvc\Form\Form; 
use Smartedutech\Littlemvc\dbadapter; 

class formformations extends Form
{

    public function __construct($nameform, \Smartedutech\Littlemvc\Form\Elements $ElementForm = null, \Smartedutech\Littlemvc\Form\FormStructer $FormData = Null)
    {
        parent::__construct($nameform, $ElementForm, $FormData);
        $this->setDecorator_Template();
        $this->FormAttrib->setTitle("formations");
          $this->FormAttrib->setId("formations");

        $this->addElement("titreformations",array(
    "type"=>"text"
    ,"options"=>array(
        "other"=>array(
        "rows"=>3
        ,"cols"=>50
        ,"required"=>""
        ,"title"=>"titreformations"
        )
    )
    ,"name"=>"titreformations"
    ,"label"=>"titreformations"
));
$this->addElement("abrevformation",array(
    "type"=>"textarea"
    ,"options"=>array(
        "other"=>array(
        "rows"=>3
        ,"cols"=>50
        ,"required"=>""
        ,"title"=>"abrevformation"
        )
    )
    ,"name"=>"abrevformation"
    ,"label"=>"abrevformation"
));

$optionsidtypeformation=$this->Selecttypeformation();
$this->addElement("idtypeformation",array(
            "type"=>"select"
            ,"list"=>$optionsidtypeformation
            ,"options"=>array(
            "other"=>array(
                "placeholder"=>"idtypeformation"
                ,"required"=>""
                ,"title"=>"idtypeformation"
         )
        )
,"name"=>"idtypeformation"
,"label"=>"idtypeformation"
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
    
public function Selecttypeformation(){
    $options[""]="Selectionner";
    $Rectypeformation=dbadapter::SelectSQL("SELECT * FROM typeformation");
    foreach ($Rectypeformation as $r){
        $options[$r['idtypeformation']]=$r[1];

    }
    return $options;
}

}
