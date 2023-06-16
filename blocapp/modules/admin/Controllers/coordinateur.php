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
class coordinateur extends Controller
{
	
	public function participation(){


		 $Vue=new View();


		if($_SESSION['ROLE']=="Coordinateur"){
			$Vue->setlayout("simplelayouttuteur");
		}else {
			$Vue->setlayout("simplelayout");
		}
		 
		  
		  
		 $id=$this->_getRequest("id","");
		  
		$sql="SELECT *,participation.idparticipation as idparticipation FROM participation 
					LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
					LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
					JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
					JOIN unite  ON unite.idunite=participationecue.idunite 
					JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
					JOIN formations  ON formations.idformations=niveauformation.idformations
					JOIN semestres ON semestres.idsemestres=unite.idsemestres
					WHERE idmanifestation=2 AND participation.idparticipation=$id ORDER By formations.idformations desc";
					
		 $matiereRecs=dbadapter::SelectSQL($sql);
		 $formationeadRecs=dbadapter::SelectSQL("SELECT * FROM participationead WHERE idparticipation=$id ORDER BY eaddate DESC");
		 $Vue->formationead=$formationeadRecs;		


		 $projetRecs=dbadapter::SelectSQL("SELECT * FROM participationprojet WHERE idparticipation=$id  ORDER BY projetdate DESC");
		 $Vue->projet=$projetRecs;	

		 
			   $viewListe=[];			   
			   //echo "<pre>"; print_r( $matiereRecs);echo "</pre>";
			   foreach($matiereRecs as $e){
				   if(!isset( $viewListe['participation'][$e['idformations']]['info'])){
					   $viewListe['participation'][$e['idformations']]['info']=array(
						'label'=>$e['Label']
						,'abrev'=>$e['abrev']
					   );
					      
				   }
				    
				   
				    if(!isset( $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['info'])){
					   $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['info']=array(
						'label'=>$e['levelformation']
					   );
					     $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['count']=0;
				   }
				   $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['count']++;
				   if(!isset( $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info'])){
					   $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info']=array(
						'label'=>$e['idsemestres']
					   ); 
				   } 
				   if(!isset( $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info'])){
					   $viewListe['participation'][$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info']=array(
						'label'=>$e['labelfr']
					   );
					     
				   } 
				    if(!isset( $viewListe['info'])){
					   $viewListe['info']=array( 
						'typecandidat'=>$e['typecandidat']
						, 'id'=>$e['idparticipation']
						,'nom'=>$e['nom']
						,'prenom'=>$e['prenom']
						,'email'=>$e['email']
						,'grade'=>$e['codegrade']
						,'specialite'=>$e['specialite']
						,'univ'=>$e['nomuniv']
						,'etab'=>$e['nometab']
						,'entreprise'=>$e['entreprise'] 
						,'secteur'=>$e['secteurpro'] 
						,'pathouvre'=>$e['pathouvre']  
						,'expuvt'=>$e['expuvt']
					   );
					      
				   } 
				   
			   }
										
									 		   
                $Vue->liste=  $viewListe ;
                
            
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
	}
	
	public function mesproposition(){
		$mesformation= $_SESSION['mesformation'];
		 $Vue=new View();
		 $Vue->setlayout("simplelayouttuteur");
		 foreach($mesformation as $k=>$f){
			 $Listeformation[]=$f['formation'];
		 }
		 
		 $sql="SELECT * FROM participation 
					LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
					LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
					JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
					JOIN unite  ON unite.idunite=participationecue.idunite 
					JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
					JOIN formations  ON formations.idformations=niveauformation.idformations
					JOIN semestres ON semestres.idsemestres=unite.idsemestres
					WHERE idmanifestation=2 AND  formations.idformations IN (".implode(",",$Listeformation).") ORDER By formations.idformations desc";
					
		 $matiereRecs=dbadapter::SelectSQL($sql);
												   
			   $viewListe=[];			   
			   //echo "<pre>"; print_r( $matiereRecs);echo "</pre>";
			   foreach($matiereRecs as $e){
				   if(!isset( $viewListe[$e['idformations']]['info'])){
					   $viewListe[$e['idformations']]['info']=array(
						'label'=>$e['Label']
						,'abrev'=>$e['abrev']
					   );
					     $viewListe[$e['idformations']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['count']++;
				   
				    if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['info']=array(
						'label'=>$e['levelformation']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['count']++;
				   if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info']=array(
						'label'=>$e['idsemestres']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['count']++;
				   
				   
				   if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info']=array(
						'label'=>$e['labelfr']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['count']++;
				   
				   
				    if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['info']=array(
						
						'typecandidat'=>$e['typecandidat']
						, 'id'=>$e['idparticipation']
						,'nom'=>$e['nom']
						,'prenom'=>$e['prenom']
						,'email'=>$e['email']
						,'grade'=>$e['codegrade']
						,'specialite'=>$e['specialite']
						,'univ'=>$e['nometab']
						,'etab'=>$e['nomuniv']
						,'entreprise'=>$e['entreprise'] 
						,'pathouvre'=>$e['pathouvre'] 
						
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']++;
				   
				   
			   }
										
									 		   
                $Vue->liste=  $viewListe ;
                
            
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
	}
	
	
	public function editionevaluation(){
		 $Vue=new View();


		if($_SESSION['ROLE']=="Coordinateur"){
			$Vue->setlayout("simplelayouttuteur");
		}else {
			$Vue->setlayout("simplelayout");
		}
		$formation=$this->_getRequest("idf",""); 
		if(!empty($formation)){
			$Vue->idformations= $formation ;
			$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM evaluationtuteur WHERE idformations='".$formation."'"); 
			if($evaluationtuteurRecs){
				$Vue->critaire=json_decode($evaluationtuteurRecs[0]['metatdata'],true);
				$Vue->idevaluationtuteur=$evaluationtuteurRecs[0]['idevaluationtuteur'];
				$Vue->scorecalcule=$evaluationtuteurRecs[0]['scorecalcule'];
				$Vue->idformations= $evaluationtuteurRecs[0]['idformations'] ;
			}
			
		}
		 $Vue->generate();
	}
	
	public function savecritaire(){
		
		 try{ 

			 
			$formation=$this->_getRequest("formation",""); 
			$formule=$this->_getRequest("formule",""); 	
			
			
			$CritaireNewRec = new \stdClass(); 
 			
			$CritaireNewRec->idformations =$formation;

			$CritaireNewRec->scorecalcule = $this->_getRequest("formule"); 
			$lesCritaire=$this->_getRequest("varEval"); 
			$lesLabel=$this->_getRequest("labelEval"); 
	 
			$Critaire=[];
			foreach($lesCritaire as $k => $f){
				 $Critaire[$f]=$lesLabel[$k];
							 
			}
			$CritaireNewRec->metatdata=json_encode($Critaire);
			
			$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM evaluationtuteur WHERE idformations='".$formation."'"); 
			
			if($evaluationtuteurRecs){
				$Where= new \stdClass();
				$Where->idevaluationtuteur=$evaluationtuteurRecs[0]['idevaluationtuteur']; 
				$id=dbadapter::update("evaluationtuteur",$CritaireNewRec,$Where);
			 
				 
			}else{
				 dbadapter::Insert("evaluationtuteur",$CritaireNewRec);
			}
			  
			
			echo json_encode(array("status"=>"success","message"=>"Evaluationtuteur à été bien enregistrer")); 

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            

        }
	}
	
	public function listecritaire(){
		
	}
	
	
	public function evaluation(){
		 $Vue=new View();
 $mesformation=null;
		if($_SESSION['ROLE']=="Coordinateur"){
			$Vue->setlayout("simplelayouttuteur");
			$mesformation=$_SESSION['mesformation'][0];
		}else {
			$Vue->setlayout("simplelayout");
		}
		 
          
		 $formation=$this->_getRequest("formation","");
		 $niveau=$this->_getRequest("niveau","");
		 $semestre = $this->_getRequest("semestre");
		 $codeuniv = $this->_getRequest("univ","");
		 $codeetab = $this->_getRequest("etab","");
		 $codegrade = $this->_getRequest("grade","");
		 $unite = $this->_getRequest("unite","");
		 $secteurjob = $this->_getRequest("secteurjob","");
		 $univprive = $this->_getRequest("univprive","");
		 $Where ="";
		 
		 
		 if(!empty($unite) && !empty($formation)){
			$sqlEval="SELECT * FROM evaluationtuteur where idformations='$formation'";
			$EvalRecs=dbadapter::SelectSQL($sqlEval); 
			if($EvalRecs)	{
				$EvalRecs=$EvalRecs[0];
				$critaire=!empty($EvalRecs['metatdata']) ? json_decode($EvalRecs['metatdata'],true)  : [];
				$Vue->evalformule  =  $EvalRecs['scorecalcule'] ;
				$Vue->idevaluationtuteur  =  $EvalRecs['idevaluationtuteur'] ;
				$Vue->evalcritaire =  $critaire ;
			}  
			 $Vue->annulerchargement=false;
		 }else{
			 $Vue->evalformule  =  ""; 
			 $Vue->annulerchargement=true;
		 }
		 
			if(!empty($unite)){
				$Where.=" AND participationecue.idunite='$unite'";  
				$sqlEvalUnite="SELECT * FROM resultevaltuteur where idunite='$unite'";
				$Vue->unite=$unite;
			}
			
			if(!empty($semestre)){
				$Where.=" AND unite.idsemestres='$semestre'";
			}
			
			if(!empty($formation)){
				$Where.=" AND formations.idformations='$formation'";  
			}elseif($mesformation){ 
				$Where.=" AND formations.idformations IN (".implode(",",$mesformation).")";  
			}
			
			if(!empty($codegrade)){
				$Where.=" AND codegrade='$codegrade'";
			}
			
			if(!empty($codeuniv)){
				$Where.=" AND participation.codeuniv='$codeuniv'";
			}
			
			if(!empty($codeetab)){
				$Where.=" AND participation.codeetab='$codeetab'";
			}
			
			if(!empty($secteurjob)){
				$Where.=" AND secteurpro='$secteurjob'";
			}
			
			
			if(!empty($univprive)){
				$Where.=" AND typecandidat='$univprive'";
			}
			
 	
			
		$sql="SELECT * FROM participation 
					LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
					LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
					LEFT JOIN resultevaltuteur ON resultevaltuteur.idparticipation=participation.idparticipation 
					JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
					JOIN unite  ON unite.idunite=participationecue.idunite  
					JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
					JOIN formations  ON formations.idformations=niveauformation.idformations
					JOIN semestres ON semestres.idsemestres=unite.idsemestres
					WHERE idmanifestation=2 $Where   ORDER By resultevaltuteur.rondres, resultevaltuteur.score ASC
		  "; 
		//$OrderBy="formations.idformations desc";
		
           $matiereRecs=dbadapter::SelectSQL($sql);
												   
			   $viewListe=[];			   
			   //echo "<pre>"; print_r( $matiereRecs);echo "</pre>";
			   foreach($matiereRecs as $e){
				   if(!isset( $viewListe[$e['idformations']]['info'])){
					   $viewListe[$e['idformations']]['info']=array(
						'label'=>$e['Label']
						,'abrev'=>$e['abrev']
					   );
					     $viewListe[$e['idformations']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['count']++;
				   
				    if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['info']=array(
						'label'=>$e['levelformation']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['count']++;
				   if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info']=array(
						'label'=>$e['idsemestres']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['count']++;
				   
				   
				   if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info']=array(
						'label'=>$e['labelfr']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['count']++;
				   
				   
				    if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['info']=array(
						
						'typecandidat'=>$e['typecandidat']
						,'id'=>$e['idparticipation']
						,'nom'=>$e['nom']
						,'prenom'=>$e['prenom']
						,'email'=>$e['email']
						,'grade'=>$e['codegrade']
						,'specialite'=>$e['specialite']
						,'univ'=>$e['nometab']
						,'etab'=>$e['nomuniv']
						,'entreprise'=>$e['entreprise'] 
						,'pathouvre'=>$e['pathouvre'] 
						,'score'=>$e['score'] 
						,'result'=>$e['result'] 
						,'evaluateur'=>$e['result']   
						
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']++;
				   
				   
			   }
							 		 		   
                $Vue->liste=  $viewListe ;
                 
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
		
		
		 $Vue->generate();
	}
	
	public function saveevaluation(){ 
		
		try{  
			$idp=$this->_getRequest("idp",""); 
			$idu=$this->_getRequest("idu",""); 	
			$idev=$this->_getRequest("idev","");
			$evaluation=$this->_getRequest("evaluation",""); 
			
			$scoreJson=json_decode($evaluation);
			
			
			$CritaireNewRec = new \stdClass(); 
 			
			$CritaireNewRec->idparticipation =$idp; 
			$CritaireNewRec->idunite = $idu; 
			$CritaireNewRec->result = $evaluation; 
			$CritaireNewRec->idevaluationtuteur = $idev; 
			$CritaireNewRec->dateeval=date("Y-m-d h:i:s");
			$CritaireNewRec->score=$this->_getRequest("score","0");;
			$CritaireNewRec->idpersonnes=$_SESSION['idpersonnes'];
			
			
			
			$historiqueeval =array("evaluation"=>$evaluation,"idpersonnes"=>$_SESSION['idpersonnes']);
	 
			 
			 
 			
			$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM resultevaltuteur WHERE idparticipation=$idp AND idunite='$idu'"); 
			
			if($evaluationtuteurRecs){
				$Where= new \stdClass();
				$Where->idresultevaltuteur=$evaluationtuteurRecs[0]['idresultevaltuteur']; 
				$dataJson=json_decode($evaluationtuteurRecs[0]['historiqueeval'],true);
				$dataJson[date("Y-m-d h:i:s")]=$historiqueeval;
				$CritaireNewRec->historiqueeval=json_encode($dataJson);
				
				
				$id=dbadapter::update("resultevaltuteur",$CritaireNewRec,$Where);
			 
				 
			}else{
				$dataJson[date("Y-m-d h:i:s")]=$historiqueeval;
				$CritaireNewRec->historiqueeval=json_encode($dataJson);
				 dbadapter::Insert("resultevaltuteur",$CritaireNewRec);
			}
			  
			
			echo json_encode(array("status"=>"success","message"=>"Evaluation à été bien enregistrer")); 

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            

        }
		
		 
	}
	
	
	
	
	
	public function tristuteur(){
		 $Vue=new View();
		$mesformation=null;
		if($_SESSION['ROLE']=="Coordinateur"){
			$Vue->setlayout("simplelayouttuteur");
			$mesformation=$_SESSION['mesformation'][0];
		}else {
			$Vue->setlayout("simplelayout");
		}
		 
          
		 $formation=$this->_getRequest("formation","");
		 $niveau=$this->_getRequest("niveau","");
		 $semestre = $this->_getRequest("semestre");
		 $codeuniv = $this->_getRequest("univ","");
		 $codeetab = $this->_getRequest("etab","");
		 $codegrade = $this->_getRequest("grade","");
		 $unite = $this->_getRequest("unite","");
		 $secteurjob = $this->_getRequest("secteurjob","");
		 $univprive = $this->_getRequest("univprive","");
		 $Where ="";
		 
		 
		 if(!empty($unite) && !empty($formation)){
			 $Vue->idu=$unite;
			 $Vue->idf=$formation;
			$sqlEval="SELECT * FROM evaluationtuteur where idformations='$formation'";
			$EvalRecs=dbadapter::SelectSQL($sqlEval); 
			if($EvalRecs)	{
				$EvalRecs=$EvalRecs[0];
				$critaire=!empty($EvalRecs['metatdata']) ? json_decode($EvalRecs['metatdata'],true)  : [];
				$Vue->evalformule  =  $EvalRecs['scorecalcule'] ;
				$Vue->idevaluationtuteur  =  $EvalRecs['idevaluationtuteur'] ;
				$Vue->evalcritaire =  $critaire ;
			}  
			 $Vue->annulerchargement=false;
		 }else{
			 $Vue->evalformule  =  ""; 
			 $Vue->annulerchargement=true;
		 }
		 
			if(!empty($unite)){
				$Where.=" AND participationecue.idunite='$unite'";  
				/*$sqlEvalUnite="SELECT * FROM resultevaltuteur where idunite='$unite'";
				$EvalUniteRecs=dbadapter::SelectSQL($sqlEvalUnite);
				$res=[];			
 			
				if($EvalUniteRecs){
					$res[$EvalUniteRecs['idparticipation']]=$EvalUniteRecs;
				}
				$Vue->EvalUniteRecs=$EvalUniteRecs;*/
			}
			
			if(!empty($semestre)){
				$Where.=" AND unite.idsemestres='$semestre'";
			}
			
			if(!empty($formation)){
				$Where.=" AND formations.idformations='$formation'";  
			}elseif($mesformation){ 
				$Where.=" AND formations.idformations IN (".implode(",",$mesformation).")";  
			}
			
			if(!empty($codegrade)){
				$Where.=" AND codegrade='$codegrade'";
			}
			
			if(!empty($codeuniv)){
				$Where.=" AND participation.codeuniv='$codeuniv'";
			}
			
			if(!empty($codeetab)){
				$Where.=" AND participation.codeetab='$codeetab'";
			}
			
			if(!empty($secteurjob)){
				$Where.=" AND secteurpro='$secteurjob'";
			}
			
			
			if(!empty($univprive)){
				$Where.=" AND typecandidat='$univprive'";
			}
			
 	
			
		$sql="SELECT *,participation.idparticipation as idparticipation FROM participation 
					LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
					LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
					LEFT JOIN resultevaltuteur ON resultevaltuteur.idparticipation=participation.idparticipation
					JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
					JOIN unite  ON unite.idunite=participationecue.idunite  
					JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
					JOIN formations  ON formations.idformations=niveauformation.idformations
					JOIN semestres ON semestres.idsemestres=unite.idsemestres
					WHERE idmanifestation=2 $Where    ORDER By  score,rondres DESC
		  "; 
		//$OrderBy="formations.idformations desc";
		
           $matiereRecs=dbadapter::SelectSQL($sql);
												   
			   $viewListe=[];			   
			   //echo "<pre>"; print_r( $matiereRecs);echo "</pre>";
			   foreach($matiereRecs as $e){
				   if(!isset( $viewListe[$e['idformations']]['info'])){
					   $viewListe[$e['idformations']]['info']=array(
						'label'=>$e['Label']
						,'abrev'=>$e['abrev']
					   );
					     $viewListe[$e['idformations']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['count']++;
				   
				    if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['info']=array(
						'label'=>$e['levelformation']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['count']++;
				   if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['info']=array(
						'label'=>$e['idsemestres']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['count']++;
				   
				   
				   if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['info']=array(
						'label'=>$e['labelfr']
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['count']++;
				   
				   
				    if(!isset( $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['info'])){
					   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['info']=array(
						
						'typecandidat'=>$e['typecandidat']
						,'id'=>$e['idparticipation']
						,'nom'=>$e['nom']
						,'prenom'=>$e['prenom']
						,'email'=>$e['email']
						,'grade'=>$e['codegrade']
						,'specialite'=>$e['specialite']
						,'univ'=>$e['nometab']
						,'etab'=>$e['nomuniv']
						,'entreprise'=>$e['entreprise'] 
						,'pathouvre'=>$e['pathouvre'] 
						,'score'=>$e['score'] 
						
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']++; 
				   
			   }
							 		 		   
                $Vue->liste=  $viewListe ;
                 
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
		 
	}
	
	
	public function fixorder(){
		try{  
			$idp=$this->_getRequest("idp",""); 
			$idu=$this->_getRequest("idu",""); 	 
			$listOrder=$this->_getRequest("listOrder",""); 
			
			$LalistOrder=!empty($listOrder) ? json_decode($listOrder,true) : [];
			
			
			dbadapter::beginTransaction();
		  
			foreach($LalistOrder as $k=>$v){
				$CritaireNewRec = new \stdClass(); 
				$dataJson=explode("_",$v);
				if($dataJson[0]=="Rd"){
					$CritaireNewRec->idparticipation =$dataJson[1]; 
					$CritaireNewRec->idunite = $idu;
					$CritaireNewRec->rondres = $k; 					
					$historiqueeval =array("order"=>$k,"idpersonnes"=>$_SESSION['idpersonnes']); 
					$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM resultevaltuteur WHERE idparticipation=".$dataJson[1]." AND idunite='$idu'"); 
					if($evaluationtuteurRecs){
						$Where= new \stdClass();
						$Where->idresultevaltuteur=$evaluationtuteurRecs[0]['idresultevaltuteur']; 
						$dataJsonH=json_decode($evaluationtuteurRecs[0]['historiqueeval'],true);
						$dataJsonH[date("Y-m-d h:i:s")]=$historiqueeval;
						$CritaireNewRec->historiqueeval=json_encode($dataJsonH); 
						$id=dbadapter::update("resultevaltuteur",$CritaireNewRec,$Where); 
					} 
				}
				
			} 
			dbadapter::Commit(); 
			echo json_encode(array("status"=>"success","message"=>"Mise en ordre à été bien enregistrer")); 

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();
			return;

        }
	}
	
	
	public function gestionrefu(){
		 $Vue=new View();
 		 $Vue->disablelayout();
		$idp=$this->_getRequest("idp",""); 
		$idu=$this->_getRequest("idu",""); 	 
		
		$Vue->idp=$idp;
		$Vue->idu=$idu;
		$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM resultevaltuteur WHERE idparticipation=$idp  AND idunite='$idu'");
		if($evaluationtuteurRecs){
			$Vue->dossier=  $evaluationtuteurRecs[0] ;
			$Vue->refusjustif=!empty($evaluationtuteurRecs[0]['refusjustif']) ? json_decode($evaluationtuteurRecs[0]['refusjustif'],true) :[]; 
                 
		
		}
		
			$Vue->titre = "Refus de dossier";
			$Vue->generate();
	    
	}
	
	public function saverefus(){
			try{  
			$idp=$this->_getRequest("idp",""); 
			$idu=$this->_getRequest("idu",""); 	 
			$anul=$this->_getRequest("annuler",""); 
			
			
			
			$CritaireNewRec = new \stdClass(); 
 			
			$CritaireNewRec->idparticipation =$idp; 
			$CritaireNewRec->idunite = $idu;   
			if($anul=="Annuler"){
				$CritaireNewRec->refus =0;  
				$CritaireNewRec->refusjustif =""; 
				$historiqueeval =array("Refus"=>"0","idpersonnes"=>$_SESSION['idpersonnes']);
			}else{
				$CritaireNewRec->refus = 1; 
				$refusmotif=$this->_getRequest("refusmotif","");   
				$refusjustif =$this->_getRequest("motiftext","");   
				 
				$CritaireNewRec->refusjustif =json_encode(array("RefusMotif"=>$refusmotif,"Justif"=>$refusjustif));  
				$historiqueeval =array("Refus"=>"1","RefusMotif"=>$refusmotif,"Justif"=>$refusjustif,"idpersonnes"=>$_SESSION['idpersonnes']);
			}
			 
			
			$CritaireNewRec->dateeval=date("Y-m-d h:i:s");
			$CritaireNewRec->score=0;
			$CritaireNewRec->idpersonnes=$_SESSION['idpersonnes'];
			
			
			
			
	 
			 
			 
 			
			$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM resultevaltuteur WHERE idparticipation=$idp AND idunite='$idu'"); 
			
			if($evaluationtuteurRecs){
				$Where= new \stdClass();
				$Where->idresultevaltuteur=$evaluationtuteurRecs[0]['idresultevaltuteur']; 
				$dataJson=json_decode($evaluationtuteurRecs[0]['historiqueeval'],true);
				$dataJson[date("Y-m-d h:i:s")]=$historiqueeval;
				$CritaireNewRec->historiqueeval=json_encode($dataJson);
				
				
				$id=dbadapter::update("resultevaltuteur",$CritaireNewRec,$Where);
			 
				 
			}else{
				$dataJson[date("Y-m-d h:i:s")]=$historiqueeval;
				$CritaireNewRec->historiqueeval=json_encode($dataJson);
				 dbadapter::Insert("resultevaltuteur",$CritaireNewRec);
			}
			  
			
			echo json_encode(array("status"=>"success","message"=>"Evaluation à été bien enregistrer")); 

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            

        }
	}
	
	
	
	
	
	public function gestionabstenir(){
		 $Vue=new View();
 		 $Vue->disablelayout();
		$idp=$this->_getRequest("idp",""); 
		$idu=$this->_getRequest("idu",""); 	 
		
		$Vue->idp=$idp;
		$Vue->idu=$idu;
		$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM resultevaltuteur WHERE idparticipation=$idp  AND idunite='$idu'");
		if($evaluationtuteurRecs){
			$Vue->dossier=  $evaluationtuteurRecs[0] ;
			$Vue->abstenirjustif=!empty($evaluationtuteurRecs[0]['abstenirjustif']) ? json_decode($evaluationtuteurRecs[0]['abstenirjustif'],true) :[]; 
                 
		
		}
		
			$Vue->titre = "Refus de dossier";
			$Vue->generate();
	    
	}
	
	public function saveabstenir(){
			try{  
			$idp=$this->_getRequest("idp",""); 
			$idu=$this->_getRequest("idu",""); 	 
			$anul=$this->_getRequest("annuler",""); 
			
			
			
			$CritaireNewRec = new \stdClass(); 
 			
			$CritaireNewRec->idparticipation =$idp; 
			$CritaireNewRec->idunite = $idu;   
			if($anul=="Annuler"){
				$CritaireNewRec->abstenir =0;  
				$CritaireNewRec->abstenirjustif =""; 
				$historiqueeval =array("abstenir"=>"0","idpersonnes"=>$_SESSION['idpersonnes']);
			}else{
				$CritaireNewRec->abstenir = 1; 
				$abstenirjustif=$this->_getRequest("AbstenirJustifA","");   
				$Absjustif =$this->_getRequest("motiftextA","");   
				 
				$CritaireNewRec->abstenirjustif =json_encode(array("AbstenirJustif"=>$abstenirjustif,"Justif"=>$Absjustif));  
				$historiqueeval =array("abstenir"=>"1","AbstenirJustif"=>$abstenirjustif,"Justif"=>$Absjustif,"idpersonnes"=>$_SESSION['idpersonnes']);
			}
			 
			
			$CritaireNewRec->dateeval=date("Y-m-d h:i:s");
			$CritaireNewRec->score=0;
			$CritaireNewRec->idpersonnes=$_SESSION['idpersonnes']; 
 			
			$evaluationtuteurRecs=dbadapter::SelectSQL("SELECT * FROM resultevaltuteur WHERE idparticipation=$idp AND idunite='$idu'"); 
			
			if($evaluationtuteurRecs){
				$Where= new \stdClass();
				$Where->idresultevaltuteur=$evaluationtuteurRecs[0]['idresultevaltuteur']; 
				$dataJson=json_decode($evaluationtuteurRecs[0]['historiqueeval'],true);
				$dataJson[date("Y-m-d h:i:s")]=$historiqueeval;
				$CritaireNewRec->historiqueeval=json_encode($dataJson);
				
				
				$id=dbadapter::update("resultevaltuteur",$CritaireNewRec,$Where);
			 
				 
			}else{
				$dataJson[date("Y-m-d h:i:s")]=$historiqueeval;
				$CritaireNewRec->historiqueeval=json_encode($dataJson);
				 dbadapter::Insert("resultevaltuteur",$CritaireNewRec);
			}
			  
			
			echo json_encode(array("status"=>"success","message"=>"Evaluation à été bien enregistrer")); 

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            

        }
	}
 
}