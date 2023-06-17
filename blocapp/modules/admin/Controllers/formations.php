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

use blocapp\modules\admin\Forms\formformations;
class formations extends Controller
{
            /**
        * editformations
        **/
        public function editformations(){
                $Vue=new View();

                $Vue->disablelayout();
                            $idformations = $this->_getRequest("idformations","" );


                $form = new formformations("formations");

                if(!empty($idformations)
){
                    $Vue->mode="Update";
                    $where=$params="";
                            $where.=empty($where) ? "idformations='".$idformations."'" : " AND idformations='".$idformations."'";

                    $Recformations=dbadapter::Select("formations",$where);
                    $Recformations_Row= $Recformations ? $Recformations[0] : array();
                    $form->initValues($Recformations_Row);
                                $params.=empty($params) ? "idformations=$idformations&mode=Update" : "&idformations=$idformations&mode=Update" ;


                    $form->setAction("?activity=saveformations&mode=Update&".$params);
                }else{
                    $form->setAction("?activity=saveformations&mode=New");
                    $Vue->mode="New";
                }
                $Vue->form=$form;
                $Vue->titre = "formations_Edit_Titre";
                $Vue->generate();
        }

            /**
            * listeformations
            **/
            public function listerformations(){
                $Vue=new View();
                $Vue->disablelayout();
                $formationsRecs=dbadapter::SelectSQL("SELECT * FROM formations");
                $Vue->liste= $formationsRecs ? $formationsRecs : array();
                $Header=array(
                                "idformations"=>\Smartedutech\Littlemvc\Langue::getString("Col_idformations") 
,
            "titreformations"=>\Smartedutech\Littlemvc\Langue::getString("Col_titreformations") 
,
            "abrevformation"=>\Smartedutech\Littlemvc\Langue::getString("Col_abrevformation") 
,
            "idtypeformation"=>\Smartedutech\Littlemvc\Langue::getString("Col_idtypeformation") 

                );
                        $Vue->LinkedId=array(        '{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'));
            $Vue->Header =$Header;
                $Vue->titre = "Lister_Titre_formations";
                $Vue->generate();
            }

/**
* editformations
**/
public function consulterformations(){
        $Vue=new View();

        $Vue->disablelayout();
                    $idformations = $this->_getRequest("idformations","" );



        if(!empty($idformations)
){
            $Vue->mode="Update";
            $where=$params="";
                    $where.=empty($where) ? "idformations='".$idformations."'" : " AND idformations='".$idformations."'";

            $Recformations=dbadapter::Select("formations",$where);
            $Recformations_Row= $Recformations ? $Recformations[0] : array();

            $Vue->liste= $Recformations_Row ? $Recformations_Row : array();
            $datas=array(
                            "idformations"=>\Smartedutech\Littlemvc\Langue::getString("idformations") 
,
            "titreformations"=>\Smartedutech\Littlemvc\Langue::getString("titreformations") 
,
            "abrevformation"=>\Smartedutech\Littlemvc\Langue::getString("abrevformation") 
,
            "idtypeformation"=>\Smartedutech\Littlemvc\Langue::getString("idtypeformation") 

            );
                        $Vue->LinkedId=array(        '{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'));
            $Vue->datas= $datas;
        }

        $Vue->titre = "formations_Edit_Titre";
        $Vue->generate();
}

public function gestionformations(){
$Vue=new View();
$Vue->setlayout("simplelayout");
$Vue->generate();
}

   /**
   * deleteformations
   */
    public function deleteformations(){
        try{

            dbadapter::beginTransaction();

            $formationsWhere = new \stdClass();
                        $formationsWhere->idformations = $this->_getRequest("idformations") ;


            dbadapter::delete("formations",$formationsWhere);


            dbadapter::Commit();

            echo json_encode(array("status"=>"success","message"=>"formations Supprimer"));

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();

        }
    }
    /**
    * saveformations
    **/
    public function saveformations(){
        try{

            dbadapter::beginTransaction();

            $mode = $this->_getRequest("mode","New");

            $formationsNewRec = new \stdClass();
                        $formationsNewRec->titreformations = $this->_getRequest("titreformations");
            $formationsNewRec->abrevformation = $this->_getRequest("abrevformation");
            $formationsNewRec->idtypeformation = $this->_getRequest("idtypeformation");


            if($mode=="New"){
               $id=dbadapter::Insert("formations",$formationsNewRec);
            }elseif($mode="Update"){
                $formationsWhere = new \stdClass();
                            $formationsWhere->idformations = $this->_getRequest("idformations") ;


                $id=dbadapter::Update("formations",$formationsNewRec,$formationsWhere);
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