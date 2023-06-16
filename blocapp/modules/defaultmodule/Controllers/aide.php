<?php

namespace blocapp\modules\defaultmodule\Controllers;

use Smartedutech\Littlemvc\mvc\Controller;
use Smartedutech\Littlemvc\mvc\View;
use Smartedutech\Littlemvc\dbadapter;
use Smartedutech\Littlemvc\Utils;
 

class aide extends Controller
{
    public function candidature(){
        $Vue=new View();
        $Vue->setlayout("inscription");
        $Vue->titre="";
        $Vue->generate();   
    }
	
	public function listemodule(){
		 $Vue=new View();
        $Vue->setlayout("inscription");
        $Vue->titre="";
        $Vue->generate(); 
	}
	
	public function habilitation(){
		$Vue=new View();
		$Vue->setlayout("inscription");
		$sql="
		
		SELECT `unite`.*
		, `niveauformation`.*
		, `formations`.*
		, `formations`.`idformations`
		, `niveauformation`.`idniveauformation`
		, `formations`.`Label` AS `labelformation`
		, `niveauformation`.`label` AS `labelniveau`
		, `formations`.`abrev` AS `abrevformation`
		, `unite`.`abrev`, `semestres`.* 
		, `semestres`.`label` AS `labelsemestres` 
		FROM `unite` 
		
		INNER JOIN `niveauformation` ON niveauformation.idniveauformation=unite.idniveauformation INNER JOIN `formations` ON formations.idformations=niveauformation.idformations 
		INNER JOIN `semestres` ON semestres.idsemestres=unite.idsemestres 
		  
		";
		 $result=dbadapter::SelectSQL($sql);
		//print_r($result);
		$data=[];
		
		 foreach ($result as $m){
			 
			 if(!isset($data[$m['idformations']]['info'])){
                  $data[$m['idformations']]['info']=array(
                         
						 
							'niveau'=>$m['labelniveau']
							,'formation'=>$m['labelformation']
							,'abrev'=>$m['abrevformation']
						 
                    );
            }
			 
            if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']])){
                  $data[$m['idformations']]['semestre'][$m['idsemestres']]=array(
                        'semestres'=>$m["labelsemestres"]
                        ,'level'=>$m['levelformation']
						,'formation'=>array(
							'niveau'=>$m['labelniveau']
							,'formation'=>$m['labelformation']
							,'abrev'=>$m['abrevformation']
						)
                    );
            }

                if(empty($m['iduepere'])){ 
                    if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['idunite']]['info'])) {
                        $data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['idunite']]['info'] = array(
                            'idunite' => $m['idunite']
                            , 'idue' => $m['iduepere']
                            , 'typemodule' => $m['typemodule']
                            , 'idniveauformation' => $m['idniveauformation']
                            , 'idsemestres' => $m['idsemestres']
                            , 'regime' => $m['regime']
                            , 'nature' => $m['nature_unite']
                            , 'coef' => $m['coef']
                            , 'credit' => $m['credit']
							, 'CodeComp'=>$m['codecomposantemodel'] 
                            , 'codeue' => $m['abrev']
                            , 'titremodule' => $m['labelfr']
							, 'unite_obligatoire'=>$m['unite_obligatoire']
                          
                        );
                    }
                }else{
                    if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['ECUE'][$m['idunite']])) {
						
                        $data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['ECUE'][$m['idunite']] = array(
                             'idunite' => $m['idunite']
                            , 'idue' => $m['iduepere']
                            , 'typemodule' => $m['typemodule']
                            , 'idniveauformation' => $m['idniveauformation']
                            , 'idsemestres' => $m['idsemestres']
                            , 'regime' => $m['regime']
                            , 'nature' => $m['nature_unite']
                            , 'coef' => $m['coef']
                            , 'credit' => $m['credit']
							, 'CodeComp'=>$m['codecomposantemodel'] 
                            , 'codeue' => $m['abrev']
                            , 'titremodule' => $m['labelfr']
							, 'unite_obligatoire'=>$m['unite_obligatoire']
							 
                        );
						
						if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['Rregime'])){
							$data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['Rregime']=0;
						}
						
                    } 
						 
						$data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['Rregime']++;
		 			 
                } 
        }
	//	$Vue->disablelayout();
		$Vue->modules=$data;
		 $Vue->titre="";
        $Vue->generate(); 
	}
	
	
	
	
	public function habilitation2(){
		$Vue=new View();
		$Vue->setlayout("inscription");
		$idformation=$this->_getRequest('idformation',""); 
		$sql="
		
		SELECT `unite`.*
		, `niveauformation`.*
		, `formations`.*
		, `formations`.`idformations`
		, `niveauformation`.`idniveauformation`
		, `formations`.`Label` AS `labelformation`
		, `niveauformation`.`label` AS `labelniveau`
		, `formations`.`abrev` AS `abrevformation`
		, `unite`.`abrev`, `semestres`.* 
		, `semestres`.`label` AS `labelsemestres` 
		FROM `unite` 
		
		INNER JOIN `niveauformation` ON niveauformation.idniveauformation=unite.idniveauformation INNER JOIN `formations` ON formations.idformations=niveauformation.idformations 
		INNER JOIN `semestres` ON semestres.idsemestres=unite.idsemestres 
		WHERE 
		  formations.idformations=$idformation
		";
		 $result=dbadapter::SelectSQL($sql);
		//print_r($result);
		$data=[];
		
		 foreach ($result as $m){
			 
			 if(!isset($data[$m['idformations']]['info'])){
                  $data[$m['idformations']]['info']=array(
                         
						 
							'niveau'=>$m['labelniveau']
							,'formation'=>$m['labelformation']
							,'abrev'=>$m['abrevformation']
						 
                    );
            }
			 
            if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']])){
                  $data[$m['idformations']]['semestre'][$m['idsemestres']]=array(
                        'semestres'=>$m["labelsemestres"]
                        ,'level'=>$m['levelformation']
						,'formation'=>array(
							'niveau'=>$m['labelniveau']
							,'formation'=>$m['labelformation']
							,'abrev'=>$m['abrevformation']
						)
                    );
            }

                if(empty($m['iduepere'])){ 
                    if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['idunite']]['info'])) {
                        $data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['idunite']]['info'] = array(
                            'idunite' => $m['idunite']
                            , 'idue' => $m['iduepere']
                            , 'typemodule' => $m['typemodule']
                            , 'idniveauformation' => $m['idniveauformation']
                            , 'idsemestres' => $m['idsemestres']
                            , 'regime' => $m['regime']
                            , 'nature' => $m['nature_unite']
                            , 'coef' => $m['coef']
                            , 'credit' => $m['credit']
							, 'CodeComp'=>$m['codecomposantemodel'] 
                            , 'codeue' => $m['abrev']
                            , 'titremodule' => $m['labelfr']
							, 'unite_obligatoire'=>$m['unite_obligatoire']
                          
                        );
                    }
                }else{
                    if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['ECUE'][$m['idunite']])) {
						
                        $data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['ECUE'][$m['idunite']] = array(
                             'idunite' => $m['idunite']
                            , 'idue' => $m['iduepere']
                            , 'typemodule' => $m['typemodule']
                            , 'idniveauformation' => $m['idniveauformation']
                            , 'idsemestres' => $m['idsemestres']
                            , 'regime' => $m['regime']
                            , 'nature' => $m['nature_unite']
                            , 'coef' => $m['coef']
                            , 'credit' => $m['credit']
							, 'CodeComp'=>$m['codecomposantemodel'] 
                            , 'codeue' => $m['abrev']
                            , 'titremodule' => $m['labelfr']
							, 'unite_obligatoire'=>$m['unite_obligatoire']
							 
                        );
						
						if(!isset($data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['Rregime'])){
							$data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['Rregime']=0;
						}
						
                    } 
						 
						$data[$m['idformations']]['semestre'][$m['idsemestres']]['UE'][$m['iduepere']]['Rregime']++;
		 			 
                } 
        }
	//	$Vue->disablelayout();
		$Vue->modules=$data;
		 $Vue->titre="";
        $Vue->generate(); 
	}
	
	
	public function charttuteur(){
		$Vue=new View();
		$Vue->setlayout("inscription");
		
		$Vue->generate();
	}
}