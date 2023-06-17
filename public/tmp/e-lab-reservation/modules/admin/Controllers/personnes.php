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

use blocapp\modules\admin\Forms\formpersonnes;
class personnes extends Controller
{
            /**
        * editpersonnes
        **/
        public function editpersonnes(){
                $Vue=new View();

                $Vue->disablelayout();
                            $idpersonnes = $this->_getRequest("idpersonnes","" );


                $form = new formpersonnes("personnes");

                if(!empty($idpersonnes)
){
                    $Vue->mode="Update";
                    $where=$params="";
                            $where.=empty($where) ? "idpersonnes='".$idpersonnes."'" : " AND idpersonnes='".$idpersonnes."'";

                    $Recpersonnes=dbadapter::Select("personnes",$where);
                    $Recpersonnes_Row= $Recpersonnes ? $Recpersonnes[0] : array();
                    $form->initValues($Recpersonnes_Row);
                                $params.=empty($params) ? "idpersonnes=$idpersonnes&mode=Update" : "&idpersonnes=$idpersonnes&mode=Update" ;


                    $form->setAction("?activity=savepersonnes&mode=Update&".$params);
                }else{
                    $form->setAction("?activity=savepersonnes&mode=New");
                    $Vue->mode="New";
                }
                $Vue->form=$form;
                $Vue->titre = "personnes_Edit_Titre";
                $Vue->generate();
        }

            /**
            * listepersonnes
            **/
            public function listerpersonnes(){
                $Vue=new View();
                $Vue->disablelayout();
                $personnesRecs=dbadapter::SelectSQL("SELECT * FROM personnes");
                $Vue->liste= $personnesRecs ? $personnesRecs : array();
                $Header=array(
                                "idpersonnes"=>\Smartedutech\Littlemvc\Langue::getString("Col_idpersonnes") 
,
            "nom"=>\Smartedutech\Littlemvc\Langue::getString("Col_nom") 
,
            "prenom"=>\Smartedutech\Littlemvc\Langue::getString("Col_prenom") 
,
            "login"=>\Smartedutech\Littlemvc\Langue::getString("Col_login") 
,
            "pwd"=>\Smartedutech\Littlemvc\Langue::getString("Col_pwd") 
,
            "roles_idroles"=>\Smartedutech\Littlemvc\Langue::getString("Col_roles_idroles") 

                );
                        $Vue->LinkedId=array(        '{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'));
            $Vue->Header =$Header;
                $Vue->titre = "Lister_Titre_personnes";
                $Vue->generate();
            }

/**
* editpersonnes
**/
public function consulterpersonnes(){
        $Vue=new View();

        $Vue->disablelayout();
                    $idpersonnes = $this->_getRequest("idpersonnes","" );



        if(!empty($idpersonnes)
){
            $Vue->mode="Update";
            $where=$params="";
                    $where.=empty($where) ? "idpersonnes='".$idpersonnes."'" : " AND idpersonnes='".$idpersonnes."'";

            $Recpersonnes=dbadapter::Select("personnes",$where);
            $Recpersonnes_Row= $Recpersonnes ? $Recpersonnes[0] : array();

            $Vue->liste= $Recpersonnes_Row ? $Recpersonnes_Row : array();
            $datas=array(
                            "idpersonnes"=>\Smartedutech\Littlemvc\Langue::getString("idpersonnes") 
,
            "nom"=>\Smartedutech\Littlemvc\Langue::getString("nom") 
,
            "prenom"=>\Smartedutech\Littlemvc\Langue::getString("prenom") 
,
            "login"=>\Smartedutech\Littlemvc\Langue::getString("login") 
,
            "pwd"=>\Smartedutech\Littlemvc\Langue::getString("pwd") 
,
            "roles_idroles"=>\Smartedutech\Littlemvc\Langue::getString("roles_idroles") 

            );
                        $Vue->LinkedId=array(        '{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'));
            $Vue->datas= $datas;
        }

        $Vue->titre = "personnes_Edit_Titre";
        $Vue->generate();
}

public function gestionpersonnes(){
$Vue=new View();
$Vue->setlayout("simplelayout");
$Vue->generate();
}

   /**
   * deletepersonnes
   */
    public function deletepersonnes(){
        try{

            dbadapter::beginTransaction();

            $personnesWhere = new \stdClass();
                        $personnesWhere->idpersonnes = $this->_getRequest("idpersonnes") ;


            dbadapter::delete("personnes",$personnesWhere);


            dbadapter::Commit();

            echo json_encode(array("status"=>"success","message"=>"personnes Supprimer"));

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();

        }
    }
    /**
    * savepersonnes
    **/
    public function savepersonnes(){
        try{

            dbadapter::beginTransaction();

            $mode = $this->_getRequest("mode","New");

            $personnesNewRec = new \stdClass();
                        $personnesNewRec->nom = $this->_getRequest("nom");
            $personnesNewRec->prenom = $this->_getRequest("prenom");
            $personnesNewRec->login = $this->_getRequest("login");
            $personnesNewRec->pwd = $this->_getRequest("pwd");
            $personnesNewRec->roles_idroles = $this->_getRequest("roles_idroles");


            if($mode=="New"){
               $id=dbadapter::Insert("personnes",$personnesNewRec);
            }elseif($mode="Update"){
                $personnesWhere = new \stdClass();
                            $personnesWhere->idpersonnes = $this->_getRequest("idpersonnes") ;


                $id=dbadapter::Update("personnes",$personnesNewRec,$personnesWhere);
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