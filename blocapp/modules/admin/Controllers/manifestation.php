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
class manifestation extends Controller
{
	
	
	public function statistique(){
		 $Vue=new View();
		 
		 
		 
		 
		 
        $Vue->setlayout("simplelayout"); 
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
			if(!empty($unite)){
				$Where.=" AND participationecue.idunite='$unite'";
			}
			
			if(!empty($semestre)){
				$Where.=" AND unite.idsemestres='$semestre'";
			}
			
			if(!empty($formation)){
				$Where.=" AND formations.idformations='$formation'";
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
					JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
					JOIN unite  ON unite.idunite=participationecue.idunite  
					JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
					JOIN formations  ON formations.idformations=niveauformation.idformations
					JOIN semestres ON semestres.idsemestres=unite.idsemestres
					WHERE idmanifestation=2 $Where ORDER By formations.idformations desc
		                          ";
								  
								  
			 		 	 
	/*	$LinkLeft=  new \stdClass(); 
		$LinkLeft->Left="universite";
		$LinkLeft->On="universite.codeuniv=participation.codeuniv";
		$sqlObjJoin[] =$LinkLeft;
		
		$LinkLeft=  new \stdClass();
		$LinkLeft->Left="etablissement";
		$LinkLeft->On="etablissement.codeetab=participation.codeetab";
		$sqlObjJoin[] =$LinkLeft;
		
		$LinkInner=  new \stdClass();
		$LinkInner->Inner="participationecue";
		$LinkInner->On="participationecue.idparticipation=participation.idparticipation";
		$sqlObjJoin[] =$LinkInner;
		$LinkInner=  new \stdClass();
		$LinkInner->Inner="unite";
		$LinkInner->On="unite.idunite=participationecue.idunite";
		$sqlObjJoin[] =$LinkInner;
		$LinkInner=  new \stdClass();
		$LinkInner->Inner="niveauformation";
		$LinkInner->On="niveauformation.idniveauformation=unite.idniveauformation";
		$sqlObjJoin[] =$LinkInner;
		
		$LinkInner=  new \stdClass();
		$LinkInner->Inner="formations";
		$LinkInner->On="formations.idformations=niveauformation.idformations";
		$sqlObjJoin[] =$LinkInner;
		
		$LinkInner=  new \stdClass();
		$LinkInner->Inner="semestres";
		$LinkInner->On="niveauformation.idniveauformation=unite.idniveauformation";
		$sqlObjJoin[] =$LinkInner;*/
		
		
		
		
		 
 		/*$Cmd=new \stdClass();
		$Cmd->idmanifestation=2; 
		$Where[]=$Cmd;
		
		$AND_Cmd=new \stdClass();
		if(!empty($unite)){
			$AND=new \stdClass();
			$AND->idunite=$unite;
			$AND_Cmd->AND[]=$AND;
		}
		if(!empty($formation)){
			$AND=new \stdClass();
			$AND->idformations=$formation;
			$AND_Cmd->AND[]=$AND;
		}
		if(!empty($idniveauformation)){
			$AND=new \stdClass();
			$AND->idniveauformation=$niveau;
			$AND_Cmd->AND[]=$AND;
		} 
		
		if(!empty($semestre)){
			$AND=new \stdClass();
			$AND->idsemestres=$semestre;
			$AND_Cmd->AND[]=$AND;
		}
		
		if(!empty($secteurjob)){
			$AND=new \stdClass();
			$AND->secteurpro=$secteurjob;
			$AND_Cmd->AND[]=$AND;
		}
		
		if(!empty($univprive)){
			$AND=new \stdClass();
			$AND->typecandidat=$univprive;
			$AND_Cmd->AND[]=$AND;
		}
		
		if(!empty($codegrade)){
			$AND=new \stdClass();
			$AND->codegrade=$codegrade;
			$AND_Cmd->AND[]=$AND;
		}
		
		if(!empty($codeuniv)){
			$AND=new \stdClass();
			$AND->codeuniv=$codeuniv;
			$AND_Cmd->AND[]=$AND;
		}
		
		if(!empty($codeetab)){
			$AND=new \stdClass();
			$AND->codeetab=$codeetab;
			$AND_Cmd->AND[]=$AND;
		}
		if(isset($AND_Cmd->AND)){
			$Where[]=$AND_Cmd;
		}
		 */
		// print_r($Where);
		$OrderBy="formations.idformations desc";
		
		 //$matiereRecs =dbadapter::SelectWithSqlPrepare("participation",$sqlObjJoin,$Where,$OrderBy);
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
						
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']++;
				   
				   
			   }
										
									 		   
                $Vue->liste=  $viewListe ;
                
            
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
	}
	
	
	public function statistiquefusion(){
		 $Vue=new View();
        $Vue->setlayout("simplelayout"); 
                $matiereRecs=dbadapter::SelectSQL("SELECT * FROM participation 
													LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
													LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
													JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
													JOIN unite  ON unite.idunite=participationecue.idunite  
													JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
													JOIN formations  ON formations.idformations=niveauformation.idformations
													JOIN semestres ON semestres.idsemestres=unite.idsemestres
													WHERE idmanifestation=2 ORDER By formations.idformations desc
                                                   ");
												   
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
						
					   );
					     $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']=0;
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']++;
				   
				   
			   }
										
									 		   
                $Vue->liste=  $viewListe ;
                
            
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
	}
	
	
	
	public function sansdepot(){
		 $Vue=new View();
        $Vue->setlayout("simplelayout"); 
                $matiereRecs=dbadapter::SelectSQL("
													SELECT * FROM 
													unite  
													JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
													JOIN formations  ON formations.idformations=niveauformation.idformations 
													JOIN semestres ON semestres.idsemestres=unite.idsemestres
													WHERE 
													iduepere IS NOT NULL AND 
													idunite Not IN
				
													(SELECT unite.idunite FROM participation 
													LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
													LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
													JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
													JOIN unite  ON unite.idunite=participationecue.idunite 
													JOIN formations  ON formations.idformations=participationecue.idformations
													JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
													JOIN semestres ON semestres.idsemestres=unite.idsemestres
													WHERE idmanifestation=2 )
                                                   ");
												   
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
				   
			   }
										
									 		   
                $Vue->liste=  $viewListe ;
                
            
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
	}
	
	public function suividepot(){
		
		 $Vue=new View();
        $Vue->setlayout("simplelayout"); 
                $matiereRecs=dbadapter::SelectSQL("SELECT * FROM 
													unite  
													JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
													JOIN formations  ON formations.idformations=niveauformation.idformations 
													JOIN semestres ON semestres.idsemestres=unite.idsemestres  
													LEFT JOIN participationecue ON unite.idunite=participationecue.idunite
													LEFT JOIN participation ON participation.idparticipation=participationecue.idparticipation 
													LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
													LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab 
													WHERE iduepere IS NOT NULL													
                                                   ");
												   
			   $viewListe=[];			   
			  //  echo "<pre>"; print_r( $matiereRecs);echo "</pre>";
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
				   
				   if(empty($e['typecandidat'])){
					    $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['sanscandidat']=true;
				   }
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
				   
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['sanscandidat']=false;
				   
				   
				   }
				   $viewListe[$e['idformations']]['niveau'][$e['idniveauformation']]['semestre'][$e['idsemestres']]['ecue'][$e['idunite']]['candidat'][$e['idparticipation']]['count']++; 
				   
			   }
										
									 		   
                $Vue->liste=  $viewListe ;
                
            
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
		
		
		
	}
    public function listerparticipants(){
        $Vue=new View();
        $Vue->setlayout("simplelayout"); 
                $matiereRecs=dbadapter::SelectSQL("SELECT * FROM participation 
													LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
													LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
													JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
													JOIN unite  ON unite.idunite=participationecue.idunite 
													JOIN formations  ON formations.idformations=participationecue.idformations
													JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
													JOIN semestres ON semestres.idsemestres=unite.idsemestres
													WHERE idmanifestation=2 ORDER By formations.idformations desc
                                                   ");
                $Vue->liste= $matiereRecs ? $matiereRecs : array();
                $Header=array(
                       // 'idparticipation'=>\Smartedutech\Littlemvc\Langue::getString("Col_idparticipation")
                        'idparticipation'=>\Smartedutech\Littlemvc\Langue::getString("ID")
                        ,'cin'=>\Smartedutech\Littlemvc\Langue::getString("cin")
                        ,'nom'=>\Smartedutech\Littlemvc\Langue::getString("nom")
                        ,'prenom'=>\Smartedutech\Littlemvc\Langue::getString("prenom")
                        ,'email'=>\Smartedutech\Littlemvc\Langue::getString("Col_email")
                        ,'tel'=>\Smartedutech\Littlemvc\Langue::getString("Col_tel") 
                        ,'Label'=>\Smartedutech\Littlemvc\Langue::getString("Col_Formation")
						,'labelfr'=>\Smartedutech\Littlemvc\Langue::getString("Col_ECUE")
                        ,'nomuniv'=>\Smartedutech\Littlemvc\Langue::getString("Col_univ")
                        ,'nometab'=>\Smartedutech\Littlemvc\Langue::getString("Col_etab") 
						,'dateinscript'=>\Smartedutech\Littlemvc\Langue::getString("Col_dateoeuvre") 
						 
                                
                );
                        $Vue->LinkedId=array('{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'),
        '{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'));
            $Vue->Header =$Header;
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
    }

    public function consulterparticipation(){
 
    }

    public function exportxls(){
        $filename=date("Y-m-d")."Tutorat";
        $file_ending='xls';
        header("Content-Type: application/xls; encoding=UTF-8’");    
        header("Content-Disposition: attachment; filename= $filename.$file_ending");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $sep = ";";

        $matiereRecs=dbadapter::SelectSQL("SELECT * FROM participation 
													LEFT JOIN universite    ON universite.codeuniv=participation.codeuniv
													LEFT JOIN etablissement  ON etablissement.codeetab=participation.codeetab
													JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
													JOIN unite  ON unite.idunite=participationecue.idunite 
													JOIN formations  ON formations.idformations=participationecue.idformations
													JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
													JOIN semestres ON semestres.idsemestres=unite.idsemestres
													WHERE idmanifestation=2 ORDER By formations.idformations desc
                                                   ");


         $Header=array(
                       // 'idparticipation'=>\Smartedutech\Littlemvc\Langue::getString("Col_idparticipation")
                        'idparticipation'=>\Smartedutech\Littlemvc\Langue::getString("ID")
                        ,'cin'=>\Smartedutech\Littlemvc\Langue::getString("cin")
                        ,'nom'=>\Smartedutech\Littlemvc\Langue::getString("nom")
                        ,'prenom'=>\Smartedutech\Littlemvc\Langue::getString("prenom")
                        ,'email'=>\Smartedutech\Littlemvc\Langue::getString("Col_email")
                        ,'tel'=>\Smartedutech\Littlemvc\Langue::getString("Col_tel") 
                        ,'Label'=>\Smartedutech\Littlemvc\Langue::getString("Col_Formation")
						,'labelfr'=>\Smartedutech\Littlemvc\Langue::getString("Col_ECUE")
                        ,'nomuniv'=>\Smartedutech\Littlemvc\Langue::getString("Col_univ")
                        ,'nometab'=>\Smartedutech\Littlemvc\Langue::getString("Col_etab") 
						,'dateinscript'=>\Smartedutech\Littlemvc\Langue::getString("Col_dateoeuvre") 
						 
                                
                );

        $liste= $matiereRecs ? $matiereRecs : array();
        $schema_insert = "";
        foreach ($Header as $keyhead => $head){
            $schema_insert .=  \Smartedutech\Littlemvc\Langue::getString($head) .$sep; 
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
        foreach ($liste as $e){
            $schema_insert = "";
            foreach ($Header as $keyhead => $head){
                $schema_insert .=  $e["$keyhead"] .$sep; 
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
			//print chr(255) . chr(254).mb_convert_encoding(trim($schema_insert), 'UTF-16LE', 'UTF-8');
            print "\n";
        }


    }

}