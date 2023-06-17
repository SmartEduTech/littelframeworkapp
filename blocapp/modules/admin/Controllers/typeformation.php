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

use blocapp\modules\admin\Forms\formtypeformation;
class typeformation extends Controller
{
            /**
        * edittypeformation
        **/
        public function edittypeformation(){
                $Vue=new View();

                $Vue->disablelayout();
                            $idtypeformation = $this->_getRequest("idtypeformation","" );


                $form = new formtypeformation("typeformation");

                if(!empty($idtypeformation)
){
                    $Vue->mode="Update";
                    $where=$params="";
                            $where.=empty($where) ? "idtypeformation='".$idtypeformation."'" : " AND idtypeformation='".$idtypeformation."'";

                    $Rectypeformation=dbadapter::Select("typeformation",$where);
                    $Rectypeformation_Row= $Rectypeformation ? $Rectypeformation[0] : array();
                    $form->initValues($Rectypeformation_Row);
                                $params.=empty($params) ? "idtypeformation=$idtypeformation&mode=Update" : "&idtypeformation=$idtypeformation&mode=Update" ;


                    $form->setAction("?activity=savetypeformation&mode=Update&".$params);
                }else{
                    $form->setAction("?activity=savetypeformation&mode=New");
                    $Vue->mode="New";
                }
                $Vue->form=$form;
                $Vue->titre = "typeformation_Edit_Titre";
                $Vue->generate();
        }

            /**
            * listetypeformation
            **/
            public function listertypeformation(){
                $Vue=new View();
                $Vue->disablelayout();
                $typeformationRecs=dbadapter::SelectSQL("SELECT * FROM typeformation");
                $Vue->liste= $typeformationRecs ? $typeformationRecs : array();
                $Header=array(
                                "idtypeformation"=>\Smartedutech\Littlemvc\Langue::getString("Col_idtypeformation") 
,
            "titretypeformation"=>\Smartedutech\Littlemvc\Langue::getString("Col_titretypeformation") 

                );
                        $Vue->LinkedId=array();
            $Vue->Header =$Header;
                $Vue->titre = "Lister_Titre_typeformation";
                $Vue->generate();
            }

/**
* edittypeformation
**/
public function consultertypeformation(){
        $Vue=new View();

        $Vue->disablelayout();
                    $idtypeformation = $this->_getRequest("idtypeformation","" );



        if(!empty($idtypeformation)
){
            $Vue->mode="Update";
            $where=$params="";
                    $where.=empty($where) ? "idtypeformation='".$idtypeformation."'" : " AND idtypeformation='".$idtypeformation."'";

            $Rectypeformation=dbadapter::Select("typeformation",$where);
            $Rectypeformation_Row= $Rectypeformation ? $Rectypeformation[0] : array();

            $Vue->liste= $Rectypeformation_Row ? $Rectypeformation_Row : array();
            $datas=array(
                            "idtypeformation"=>\Smartedutech\Littlemvc\Langue::getString("idtypeformation") 
,
            "titretypeformation"=>\Smartedutech\Littlemvc\Langue::getString("titretypeformation") 

            );
                        $Vue->LinkedId=array();
            $Vue->datas= $datas;
        }

        $Vue->titre = "typeformation_Edit_Titre";
        $Vue->generate();
}

public function gestiontypeformation(){
$Vue=new View();
$Vue->setlayout("simplelayout");
$Vue->generate();
}

   /**
   * deletetypeformation
   */
    public function deletetypeformation(){
        try{

            dbadapter::beginTransaction();

            $typeformationWhere = new \stdClass();
                        $typeformationWhere->idtypeformation = $this->_getRequest("idtypeformation") ;


            dbadapter::delete("typeformation",$typeformationWhere);


            dbadapter::Commit();

            echo json_encode(array("status"=>"success","message"=>"typeformation Supprimer"));

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();

        }
    }
    /**
    * savetypeformation
    **/
    public function savetypeformation(){
        try{

            dbadapter::beginTransaction();

            $mode = $this->_getRequest("mode","New");

            $typeformationNewRec = new \stdClass();
                        $typeformationNewRec->idtypeformation = $this->_getRequest("idtypeformation");
            $typeformationNewRec->titretypeformation = $this->_getRequest("titretypeformation");


            if($mode=="New"){
               $id=dbadapter::Insert("typeformation",$typeformationNewRec);
            }elseif($mode="Update"){
                $typeformationWhere = new \stdClass();
                            $typeformationWhere->idtypeformation = $this->_getRequest("idtypeformation") ;


                $id=dbadapter::Update("typeformation",$typeformationNewRec,$typeformationWhere);
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