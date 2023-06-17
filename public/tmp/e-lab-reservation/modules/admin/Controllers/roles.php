<?php
/**
 * Created by {GENERATOR}.
 * User: {USER}
 * Date: {DATE}
 * Time: {DATE} {TIME}
 */ 

namespace blocapp\modules\admin\Controllers;

use Smartedutech\Littlemvc\mvc\Controller;
use Smartedutech\Littlemvc\mvc\View;
use Smartedutech\Littlemvc\dbadapter; 
use Smartedutech\Littlemvc\Utils;

use blocapp\modules\admin\Forms\formroles;
class roles extends Controller
{
            /**
        * editroles
        **/
        public function editroles(){
                $Vue=new View();

                $Vue->disablelayout();
                            $idroles = $this->_getRequest("idroles","" );


                $form = new formroles("roles");

                if(!empty($idroles)
){
                    $Vue->mode="Update";
                    $where=$params="";
                            $where.=empty($where) ? "idroles='".$idroles."'" : " AND idroles='".$idroles."'";

                    $Recroles=dbadapter::Select("roles",$where);
                    $Recroles_Row= $Recroles ? $Recroles[0] : array();
                    $form->initValues($Recroles_Row);
                                $params.=empty($params) ? "idroles=$idroles&mode=Update" : "&idroles=$idroles&mode=Update" ;


                    $form->setAction("?activity=saveroles&mode=Update&".$params);
                }else{
                    $form->setAction("?activity=saveroles&mode=New");
                    $Vue->mode="New";
                }
                $Vue->form=$form;
                $Vue->titre = "roles_Edit_Titre";
                $Vue->generate();
        }

            /**
            * listeroles
            **/
            public function listerroles(){
                $Vue=new View();
                $Vue->disablelayout();
                $rolesRecs=dbadapter::SelectSQL("SELECT * FROM roles");
                $Vue->liste= $rolesRecs ? $rolesRecs : array();
                $Header=array(
                                "idroles"=>\Smartedutech\Littlemvc\Langue::getString("Col_idroles") 
,
            "labelrole"=>\Smartedutech\Littlemvc\Langue::getString("Col_labelrole") 
,
            "descroles"=>\Smartedutech\Littlemvc\Langue::getString("Col_descroles") 

                );
                        $Vue->LinkedId=array();
            $Vue->Header =$Header;
                $Vue->titre = "Lister_Titre_roles";
                $Vue->generate();
            }

/**
* editroles
**/
public function consulterroles(){
        $Vue=new View();

        $Vue->disablelayout();
                    $idroles = $this->_getRequest("idroles","" );



        if(!empty($idroles)
){
            $Vue->mode="Update";
            $where=$params="";
                    $where.=empty($where) ? "idroles='".$idroles."'" : " AND idroles='".$idroles."'";

            $Recroles=dbadapter::Select("roles",$where);
            $Recroles_Row= $Recroles ? $Recroles[0] : array();

            $Vue->liste= $Recroles_Row ? $Recroles_Row : array();
            $datas=array(
                            "idroles"=>\Smartedutech\Littlemvc\Langue::getString("idroles") 
,
            "labelrole"=>\Smartedutech\Littlemvc\Langue::getString("labelrole") 
,
            "descroles"=>\Smartedutech\Littlemvc\Langue::getString("descroles") 

            );
                        $Vue->LinkedId=array();
            $Vue->datas= $datas;
        }

        $Vue->titre = "roles_Edit_Titre";
        $Vue->generate();
}

public function gestionroles(){
$Vue=new View();
$Vue->setlayout("simplelayout");
$Vue->generate();
}

   /**
   * deleteroles
   */
    public function deleteroles(){
        try{

            dbadapter::beginTransaction();

            $rolesWhere = new \stdClass();
                        $rolesWhere->idroles = $this->_getRequest("idroles") ;


            dbadapter::delete("roles",$rolesWhere);


            dbadapter::Commit();

            echo json_encode(array("status"=>"success","message"=>"roles Supprimer"));

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();

        }
    }
    /**
    * saveroles
    **/
    public function saveroles(){
        try{

            dbadapter::beginTransaction();

            $mode = $this->_getRequest("mode","New");

            $rolesNewRec = new \stdClass();
                        $rolesNewRec->idroles = $this->_getRequest("idroles");
            $rolesNewRec->labelrole = $this->_getRequest("labelrole");
            $rolesNewRec->descroles = $this->_getRequest("descroles");


            if($mode=="New"){
               $id=dbadapter::Insert("roles",$rolesNewRec);
            }elseif($mode="Update"){
                $rolesWhere = new \stdClass();
                            $rolesWhere->idroles = $this->_getRequest("idroles") ;


                $id=dbadapter::Update("roles",$rolesNewRec,$rolesWhere);
            }


            dbadapter::Commit();
            if($mode=="New"){
               echo json_encode(array("status"=>"success","message"=>"Personne ajouter"));
            }elseif($mode="Update"){
                echo json_encode(array("status"=>"success","message"=>"Personne Mis ajours"));
            }

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();

        }
    }

}