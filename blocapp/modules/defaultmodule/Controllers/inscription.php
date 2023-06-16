<?php

namespace blocapp\modules\defaultmodule\Controllers;

use Smartedutech\Littlemvc\mvc\Controller;
use Smartedutech\Littlemvc\mvc\View;
use Smartedutech\Littlemvc\dbadapter;
use Smartedutech\Littlemvc\Utils;
use Smartedutech\Littlemvc\recaptcha\ReCaptcha;

class inscription extends Controller
{
    public function candidature(){
        $Vue=new View();
        $Vue->setlayout("inscription");
        $Vue->titre="";
        $Vue->generate();   
    }
	public function modifiercandidature(){
        $Vue=new View();
        $Vue->setlayout("inscription");
	 
		$code=$this->_getRequest("code",""); 
		$codeDecrypt=Utils::decrypt2($code);
		 
		$DemandeRecs=dbadapter::SelectSQL("SELECT * FROM participation WHERE codemodif='$codeDecrypt'");
		
		
		if(isset($DemandeRecs[0]['idparticipation']) && !empty($DemandeRecs[0]['idparticipation'])){
		  $Vue->code=$code;
			$Vue->DemandeRecs=$DemandeRecs[0] ; 

			$ParticipationEAD=dbadapter::SelectSQL("SELECT * FROM participationead WHERE idparticipation=".$DemandeRecs[0]['idparticipation']);
			if($ParticipationEAD){ 
				$Vue->ParticipationEAD=$ParticipationEAD ;  
			}else{
				//ERREUR
				$Vue->ParticipationEAD=[] ;
			}
			
			$Participationecue=dbadapter::SelectSQL("SELECT * FROM participationecue WHERE idparticipation=".$DemandeRecs[0]['idparticipation']);
			if($Participationecue){ 
				$Vue->Participationecue=$Participationecue ;  
			}else{
				//ERREUR
				$Vue->Participationecue=[] ;
			}  
			
			$Participationprojet=dbadapter::SelectSQL("SELECT * FROM participationprojet WHERE idparticipation=".$DemandeRecs[0]['idparticipation']);
			if($Participationprojet){ 
				$Vue->Participationprojet=$Participationprojet ;  
			}else{
				//ERREUR
				$Vue->Participationprojet=[];
			}

			$Vue->isNotInscript=false;
		}else{
			 
			$Vue->isNotInscript=true;
		}
		
 		 
        $Vue->titre="";
        $Vue->generate();   
    }
	
	    public function savemodifinscription(){
         
    	 $sitekey="6LdwdIogAAAAAMhaanpwG6Kxlo_gj_sDMcvTkNg3";
		 $serverkey="6LdwdIogAAAAAGwte2nGFeRFdjckM03Q-uuxmyOO";

         $reCaptcha = new ReCaptcha($serverkey);
			   if ($_POST["g-recaptcha-response"]) {
					$resp = $reCaptcha->verifyResponse(
						$_SERVER["REMOTE_ADDR"],
						$_POST["g-recaptcha-response"]
					);
					if(!$resp){
						die("erreur_captcha");
					}
				}else{
					die("erreur_captcha");
				}
        try{


			$email=$this->_getRequest("email",""); 
			$formation=$this->_getRequest("formation",""); 
			$unite=$this->_getRequest("unite",""); 	
			$code=$this->_getRequest("code",""); 
			$codeDecrypt=Utils::decrypt2($code);
			$DemandeRecs=dbadapter::SelectSQL("SELECT * FROM participation WHERE codemodif='$codeDecrypt'");
			 dbadapter::beginTransaction();
			if($DemandeRecs){  
				   $target_dir = "upload/";
            // Get file path
            $extension = isset($_FILES['dossiercandidat']) ? pathinfo($_FILES['dossiercandidat']['name'], PATHINFO_EXTENSION) :"";
			
			$InscritParticipationNewRec = new \stdClass(); 
			$montravail=$this->_getRequest("signepersonnel",""); 
			
			$InscritParticipationNewRec->nom = $this->_getRequest("nom");
			$InscritParticipationNewRec->prenom = $this->_getRequest("prenom");
			$InscritParticipationNewRec->email = $this->_getRequest("email");
			$InscritParticipationNewRec->cin = $this->_getRequest("cin3");
			$InscritParticipationNewRec->tel = $this->_getRequest("tel");  
			$InscritParticipationNewRec->codeuniv = $this->_getRequest("univ");
			$InscritParticipationNewRec->codeetab = $this->_getRequest("etab");  
			$donneemail=array(
			"nom"=>$this->_getRequest("nom")
			,"prenom"=>$this->_getRequest("prenom")
			
			);
			  
			$InscritParticipationNewRec->expuvt= $this->_getRequest("expuvt");
			 
			
			$typecandidat=$this->_getRequest("univprive");
			$InscritParticipationNewRec->typecandidat = $typecandidat;
			$InscritParticipationNewRec->entreprise = $this->_getRequest("entreprise");
			$InscritParticipationNewRec->postepro = $this->_getRequest("postefonction");
			$InscritParticipationNewRec->secteurpro = $typecandidat=="professionnel" ? $this->_getRequest("secteurjob"):"";
			$InscritParticipationNewRec->codegrade = $this->_getRequest("grade");
			$InscritParticipationNewRec->specialite = $this->_getRequest("specialite");
			$InscritParticipationNewRec->diplome = $this->_getRequest("diplome"); 
			 
 			$InscritParticipationNewRec->uvtpublication= !empty($autorisation) ? 1 : 0;
			$InscritParticipationNewRec->idmanifestation = 2;
			$InscritParticipationNewRec->dateinscript = date("Y-m-d H:i:s");

			$cin=$this->_getRequest("cin3");  
			$filename=$cin."-".time().".". $extension; 
			$target_file = $target_dir .$filename;        
			 
             
			if (isset($_FILES["dossiercandidat"]["tmp_name"] ) && !empty($_FILES["dossiercandidat"]["tmp_name"]) && move_uploaded_file($_FILES["dossiercandidat"]["tmp_name"], $target_file)) {
				
                     $originefilename=$_FILES['dossiercandidat']['name'];
 					
					$InscritParticipationNewRec->pathouvre	= $filename;	 
					//$InscritParticipationNewRec->orgouvre	= $originefilename;
					 
					 
                }/* else {
                    $resMessage = array(
                        "status" => "Erreur",
                        "message" => "Erreur de chargement de fichier "
                    );
					
                     dbadapter::Rolback();
                    return;
                } */
			
			
//echo "<pre>";print_r($InscritParticipationNewRec);echo "</pre>";
$Where= new \stdClass();
$Where->idparticipation=$DemandeRecs[0]['idparticipation'];
//$code_noncrypt =$id; 
 //  $code=Utils::encrypt2($code_noncrypt);
   $InscritParticipationNewRec->codemodif="";
			$id=dbadapter::update("participation",$InscritParticipationNewRec,$Where);
			
			$lesFormations=$this->_getRequest("formation");
			$lesEcues=$this->_getRequest("unite");
			 
			$InscritParticipationECUE = new \stdClass();
			dbadapter::delete("participationecue",$Where);
			foreach($lesFormations as $k => $f){
				
				$InscritParticipationECUE->idparticipation=$Where->idparticipation;
				$InscritParticipationECUE->idunite = $lesEcues[$k]; 
				$InscritParticipationECUE->idformations = $f; 
				 dbadapter::Insert("participationecue",$InscritParticipationECUE);
				$donneemail["ecue"][$InscritParticipationECUE->idunite]=$InscritParticipationECUE->idformations;				 
			}
			
			
			$lesFADFormation=$this->_getRequest("eadformation");
			$lesEADformationdate=$this->_getRequest("eadformationdate");
			
			$InscritParticipationEAD = new \stdClass(); 
			dbadapter::delete("participationead",$Where);
			foreach($lesFADFormation as $k => $ead){
				
				$InscritParticipationEAD->idparticipation=$Where->idparticipation;
				$InscritParticipationEAD->ead = $ead; 
				if(!empty($lesEADformationdate[$k])){
					$InscritParticipationEAD->eaddate = date("Y-m-d",strtotime($lesEADformationdate[$k]));
				} 
				 dbadapter::Insert("participationead",$InscritParticipationEAD); 
			}
			
			$lesEADprojet=$this->_getRequest("eadprojet");
			$lesEADProjetdate=$this->_getRequest("eadProjetdate");
			
			
			
			$InscritParticipationProjet = new \stdClass(); 
			dbadapter::delete("participationprojet",$Where);
			foreach($lesEADprojet as $k => $ead){
				
				$InscritParticipationProjet->idparticipation=$Where->idparticipation;
				$InscritParticipationProjet->projet = $ead; 
				if(!empty($lesEADProjetdate[$k])){
					$InscritParticipationProjet->projetdate = date("Y-m-d",strtotime($lesEADProjetdate[$k]));
				} 
				 dbadapter::Insert("participationprojet",$InscritParticipationProjet); 
			}
			//print_r($InscritParticipationNewRec);
			//dbadapter::Commit(); 
			 
					
                  dbadapter::Commit(); 
				   
				    //send mail with code de modification
				   
				   $to=$this->_getRequest("email");
				   //$this->sendmailBienVenu($to,$code,$donneemail);
				   
				  echo json_encode(array("status"=>"success","message"=>"Votre Candidature à été bien enregistrée. Si vous voulez modifier votre candidature, <a href='https://www.uvt.rnu.tn/candidature-tutorat/?activity=demande-modif-ma-candidature'>cliquer ici</a>."));
				  /* echo json_encode(array("status"=>"success","message"=>"Votre Candidature à été bien enregistrée. Si vous voulez modifier votre candidature, <a href='http://www.uvt.rnu.tn/candidature-tutorat/?activity=modif-ma-candidature&code=$code'>cliquer ici</a>."));*/
			}
        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();
			return;
        }
    }
	
	
	
	
	public function demandemodification(){
        $Vue=new View();
		
		//génération de code
		
        $Vue->setlayout("inscription");
        $Vue->titre="";
        $Vue->generate();   
    }
	public function accorddemandemodif(){
		try{
		$email=$this->_getRequest("email","");  
		
		
		$DemandeRecs=dbadapter::SelectSQL("SELECT * FROM participation WHERE email='".$email."'");
		if($DemandeRecs){
			$code_noncrypt =$DemandeRecs[0]['idparticipation'];
			$code=Utils::encrypt2($code_noncrypt);
			$info=array(
			"nom"=>$DemandeRecs[0]['nom']
			,"prenom"=>$DemandeRecs[0]['prenom']
			);
			$this->sendmail($email,$code,$info);
			$Where= new \stdClass();
			$UInscritParticipationNewRec=new \stdClass();
			$Where->idparticipation=$DemandeRecs[0]['idparticipation'];
			$UInscritParticipationNewRec->codemodif=$code_noncrypt;
		
			$id=dbadapter::Update("participation",$UInscritParticipationNewRec,$Where);
		
		 
		 echo json_encode(array("status"=>"success","message"=>"Vous recevrez un mail pour la modification de votre candidature, le lien à recevoir ne peut être utilisé qu'une seule fois."));
		
			 
		
		//echo $code;
		
		
		}else{
					 echo json_encode(array("status"=>"warning","message"=>"Vous n'avez pas encore déposé une candidature de tutorat. <a href='https://www.uvt.rnu.tn/candidature-tutorat'>Déposer votre candidature ici</a>"));

		}
		 }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
             

        }
		
	}
	
	
    public function saveinscription(){
         
    	 $sitekey="6LdwdIogAAAAAMhaanpwG6Kxlo_gj_sDMcvTkNg3";
		 $serverkey="6LdwdIogAAAAAGwte2nGFeRFdjckM03Q-uuxmyOO";

         $reCaptcha = new ReCaptcha($serverkey);
			   if ($_POST["g-recaptcha-response"]) {
					$resp = $reCaptcha->verifyResponse(
						$_SERVER["REMOTE_ADDR"],
						$_POST["g-recaptcha-response"]
					);
					if(!$resp){
						die("erreur_captcha");
					}
				}else{
					die("erreur_captcha");
				}
        try{


			$email=$this->_getRequest("email",""); 
			$formation=$this->_getRequest("formation",""); 
			$unite=$this->_getRequest("unite",""); 	
			$DemandeRecs=dbadapter::SelectSQL("SELECT * FROM participation WHERE email='".$email."'");
			if($DemandeRecs){
				echo json_encode(array("status"=>"warning","message"=>"Vous avez déjà déposé une candidature de tutorat dans ce module, vous pouvez modifier vos données sur demande on suivant les inscrution déjà mentionné en haut"));
				return;
			}

             dbadapter::beginTransaction();
 

            $target_dir = "upload/";
            // Get file path
            $extension = pathinfo($_FILES['dossiercandidat']['name'], PATHINFO_EXTENSION);
			
			$InscritParticipationNewRec = new \stdClass(); 
			$montravail=$this->_getRequest("signepersonnel",""); 
			
			$InscritParticipationNewRec->nom = $this->_getRequest("nom");
			$InscritParticipationNewRec->prenom = $this->_getRequest("prenom");
			$InscritParticipationNewRec->email = $this->_getRequest("email");
			$InscritParticipationNewRec->cin = $this->_getRequest("cin3");
			$InscritParticipationNewRec->tel = $this->_getRequest("tel");  
			$InscritParticipationNewRec->codeuniv = $this->_getRequest("univ");
			$InscritParticipationNewRec->codeetab = $this->_getRequest("etab");  
			$donneemail=array(
			"nom"=>$this->_getRequest("nom")
			,"prenom"=>$this->_getRequest("prenom")
			
			);
			  
			$InscritParticipationNewRec->expuvt= $this->_getRequest("expuvt");
			 
			
			$typecandidat=$this->_getRequest("univprive");
			$InscritParticipationNewRec->typecandidat = $typecandidat;
			$InscritParticipationNewRec->entreprise = $this->_getRequest("entreprise");
			$InscritParticipationNewRec->postepro = $this->_getRequest("postefonction");
			$InscritParticipationNewRec->secteurpro = $typecandidat=="professionnel" ? $this->_getRequest("secteurjob"):"";
			$InscritParticipationNewRec->codegrade = $this->_getRequest("grade");
			$InscritParticipationNewRec->specialite = $this->_getRequest("specialite");
			$InscritParticipationNewRec->diplome = $this->_getRequest("diplome"); 
			 
 			$InscritParticipationNewRec->uvtpublication= !empty($autorisation) ? 1 : 0;
			$InscritParticipationNewRec->idmanifestation = 2;
			$InscritParticipationNewRec->dateinscript = date("Y-m-d H:i:s");

$cin=$this->_getRequest("cin3");  
			$filename=$cin."-".time().".". $extension; 
			$target_file = $target_dir .$filename;        
			$originefilename=$_FILES['dossiercandidat']['name']; 
             
			if (move_uploaded_file($_FILES["dossiercandidat"]["tmp_name"], $target_file)) {
				
                     
 					
					$InscritParticipationNewRec->pathouvre	= $filename;	 
					//$InscritParticipationNewRec->orgouvre	= $originefilename;
					 
					 
                } else {
                    $resMessage = array(
                        "status" => "Erreur",
                        "message" => "Erreur de chargement de fichier "
                    );
					
                     dbadapter::Rolback();
                    return;
                } 
			
			
//echo "<pre>";print_r($InscritParticipationNewRec);echo "</pre>";
			
			$id=dbadapter::Insert("participation",$InscritParticipationNewRec);
			
			$lesFormations=$this->_getRequest("formation");
			$lesEcues=$this->_getRequest("unite");
			 
			$InscritParticipationECUE = new \stdClass();
			foreach($lesFormations as $k => $f){
				$InscritParticipationECUE->idparticipation=$id;
				$InscritParticipationECUE->idunite = $lesEcues[$k]; 
				$InscritParticipationECUE->idformations = $f; 
				 dbadapter::Insert("participationecue",$InscritParticipationECUE);
				$donneemail["ecue"][$InscritParticipationECUE->idunite]=$InscritParticipationECUE->idformations;				 
			}
			
			
			$lesFADFormation=$this->_getRequest("eadformation");
			$lesEADformationdate=$this->_getRequest("eadformationdate");
			
			$InscritParticipationEAD = new \stdClass(); 
			foreach($lesFADFormation as $k => $ead){
				$InscritParticipationEAD->idparticipation=$id;
				$InscritParticipationEAD->ead = $ead; 
				if(!empty($lesEADformationdate[$k])){
					$InscritParticipationEAD->eaddate = date("Y-m-d",strtotime($lesEADformationdate[$k]));
				} 
				 dbadapter::Insert("participationead",$InscritParticipationEAD); 
			}
			
			$lesEADprojet=$this->_getRequest("eadprojet");
			$lesEADProjetdate=$this->_getRequest("eadProjetdate");
			
			
			
			$InscritParticipationProjet = new \stdClass(); 
			foreach($lesEADprojet as $k => $ead){
				$InscritParticipationProjet->idparticipation=$id;
				$InscritParticipationProjet->projet = $ead; 
				if(!empty($lesEADProjetdate[$k])){
					$InscritParticipationProjet->projetdate = date("Y-m-d",strtotime($lesEADProjetdate[$k]));
				} 
				 dbadapter::Insert("participationprojet",$InscritParticipationProjet); 
			}
			//print_r($InscritParticipationNewRec);
			//dbadapter::Commit(); 
			 
					
                  dbadapter::Commit(); 
				   
				    //send mail with code de modification
				   $code_noncrypt =$id ;
				   $code=Utils::encrypt2($code_noncrypt);
				   $to=$this->_getRequest("email");
				   $this->sendmailBienVenu($to,$code,$donneemail);
				   
				   echo json_encode(array("status"=>"success","message"=>"Votre Candidature à été bien enregistrée. Si vous voulez modifier votre candidature, <a href='http://www.uvt.rnu.tn/candidature-tutorat/?activity=modif-ma-candidature&code=$code'>cliquer ici</a>."));
            

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            dbadapter::Rolback();

        }
    }
    public function getuniversity(){
        
        $univRecs=dbadapter::SelectSQL("SELECT * FROM universite");

        $OptionUniv="<option value=''>Université...</option>";
		  foreach($univRecs as $univ) {
			 $OptionUniv.="<option value='".$univ['codeuniv']."' title='".$univ['nomuniv']."'>".$univ['codeuniv']." : ".$univ['nomuniv']."</option>";
		  }
		  echo $OptionUniv;
    }

    public function getetablissement(){
        $univ= $this->_getRequest("univ","");
			 
			if(!empty($univ)){
				$selestreallEtab= $univRecs=dbadapter::SelectSQL("SELECT * FROM etablissement WHERE codeuniv='$univ'"); 
			}else{
				$selestreallEtab=dbadapter::SelectSQL("SELECT * FROM etablissement");
			}
	
	 $OptionEtab="<option value=''>Etablissement...</option>";
	  foreach($selestreallEtab as $etab) {
		 $OptionEtab.="<option value='".$etab['codeetab']."' title='".$etab["nometab"]."'>".$etab['codeetab']." : ".$etab["nometab"]."</option>";
	  }
	  echo $OptionEtab;
    }
	
	public function getformation(){
		$mesformation=null;
		if($_SESSION && isset($_SESSION['ROLE']) && !empty($_SESSION['ROLE'])
			&& $_SESSION['ROLE']=="Coordinateur"
		
		){
			$mesformation=$_SESSION['mesformation'][0];
			$FormationRecs=dbadapter::SelectSQL("SELECT * FROM formations WHERE idformations IN (".implode(",",$mesformation).")");
		}else{
			$FormationRecs=dbadapter::SelectSQL("SELECT * FROM formations"); 
		}
			
	 
        

        $OptionFormation="<option value=''>Formation...</option>";
		  foreach($FormationRecs as $Formation) {
			 $OptionFormation.="<option value='".$Formation['idformations']."' title='".$Formation['abrev']."'>".$Formation['abrev']." : ".$Formation['Label']."</option>";
		  }
		  echo $OptionFormation;
    }
	
	public function getgrade(){
		 $typegrade= $this->_getRequest("typegrade","univ");
        if($typegrade=="pro"){
			$GradeRecs=dbadapter::SelectSQL("SELECT * FROM tuteurslistegrade WHERE corps='Professionnel' ORDER BY corps");
		}else{
			$GradeRecs=dbadapter::SelectSQL("SELECT * FROM tuteurslistegrade WHERE corps<>'Professionnel' ORDER BY corps");
		}
        

        $GradeFormation="<option value=''>Grade...</option>";
		$curentGrade="";
		  foreach($GradeRecs as $grade) {
			  if($grade['corps']!=$curentGrade && $curentGrade!=""){
				  $GradeFormation.="</optgroup>";
			  }
			  
			  if($grade['corps']!=$curentGrade || $curentGrade==""){
				  $GradeFormation.="<optgroup label='".$grade['corps']."'>";
			  }
			 $GradeFormation.="<option value='".$grade['codegrade']."' title='".$grade['nomgrade']."'>".$grade['nomgrade']."</option>";
			 
			 $curentGrade=$grade['corps'];
		  }
		  echo $GradeFormation;
    }
	
	public function getsemestre(){
		 $idlevelformation= $this->_getRequest("level","");
        if(!empty($idlevelformation)){
			$SemestreRecs=dbadapter::SelectSQL("SELECT * FROM semestres WHERE idlevelformation=$idlevelformation ORDER BY idsemestres");
		}else{
			$SemestreRecs=dbadapter::SelectSQL("SELECT * FROM semestres    ORDER BY idsemestres");
		}
        

        $SemestreSelect="<option value=''>Semestre...</option>"; 
	    foreach($SemestreRecs as $sem) {  
			 $SemestreSelect.="<option value='".$sem['idsemestres']."' title='".$sem['label']."'>".$sem['label']."</option>"; 
	    }
	  echo $SemestreSelect;
    }
	
	 public function getunite(){
        $idformation= $this->_getRequest("idformation","");
		$idsemestres= $this->_getRequest("semestre","");	 
			if(!empty($idformation)){
				
				if(!empty($idsemestres)){
					$selestreallUnite= $univRecs=dbadapter::SelectSQL("
						SELECT *,CONCAT('Niveau ',label,' Semestre : ',idsemestres ) AS NivSen 
						FROM 
							unite 
							INNER JOIN niveauformation ON  niveauformation.idniveauformation=unite.idniveauformation 
						WHERE 
							(iduepere IS NOT NULL OR iduepere <>'') 
							AND  idformations='$idformation'
							AND	 idsemestres='$idsemestres' 	
							ORDER BY NivSen"
							); 
				}else{
					$selestreallUnite= $univRecs=dbadapter::SelectSQL("
						SELECT *,CONCAT('Niveau ',label,' Semestre : ',idsemestres ) AS NivSen 
						FROM 
							unite 
							INNER JOIN niveauformation ON  niveauformation.idniveauformation=unite.idniveauformation 
						WHERE 
							(iduepere IS NOT NULL OR iduepere <>'') 
							AND  idformations='$idformation'
							ORDER BY NivSen"
							); 
				}
			} else{
				if(!empty($idsemestres)){
					$selestreallUnite=dbadapter::SelectSQL("SELECT *,CONCAT('Niveau ',label,' Semestre : ',idsemestres ) FROM unite 
					JOIN niveauformation ON  niveauformation.idniveauformation=unite.idniveauformation 
					WHERE idsemestres='$idsemestres' ");
				}else{
						$selestreallUnite=dbadapter::SelectSQL("SELECT *,CONCAT('Niveau ',label,' Semestre : ',idsemestres ) FROM unite 
					JOIN niveauformation ON  niveauformation.idniveauformation=unite.idniveauformation ");
				}
			} 
 
			 $OptionUnite="<option value=''>Unité...</option>";
			 $newsemestre = '';
			 
			  foreach($selestreallUnite as $unite) {
				   if($unite['NivSen']!=$newsemestre && $newsemestre!=""){
						  $OptionUnite.="</optgroup>";
					  }
					  if($unite['NivSen']!=$newsemestre || $newsemestre==""){
						  $OptionUnite.="<optgroup label='".$unite['NivSen']."'>";
					  }
				 $OptionUnite.="<option value='".$unite['idunite']."' title='".$unite["labelfr"]."'>".$unite['abrev']." : ".$unite["labelfr"]."</option>";
				 
				  $newsemestre=$unite['NivSen'];
			  }
			  echo $OptionUnite;
    }
	
	public function sendmail($email,$code,$infor){
		 
		$to  = $email;
 
		$sub="UVT, Service pédagogie : Modifier ma candidature au tutorat";
		$nom= $infor["nom"];
		$prenom= $infor["prenom"];
		$mailContent = file_get_contents('./template/modifier.phtml', true);
		
		$mailContent=str_ireplace(array('{{nom}}','{{prenom}}','{{code}}'),array($nom,$prenom,$code),$mailContent);
		$msg=$mailContent;
 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=utf-8' . "\r\n";

		// Additional headers
		$headers .= 'From: <pedagogie@uvt.tn>' . "\r\n";


		mail($to,$sub,$msg,$headers);
	}
	
	
	
	public function sendmailBienVenu($email,$code,$infor){
		 
		$to  = $email;
		$sub="UVT-Service pédagogique : Candidature au tutorat est bien enregistrée";
		$nom= $infor["nom"];
		$prenom= $infor["prenom"];
		$mailContent = file_get_contents('./template/bienvenu.phtml', true);
		
		$mailContent=str_ireplace(array('{{nom}}','{{prenom}}','{{code}}'),array($nom,$prenom,$code),$mailContent);
		$msg=$mailContent;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'From: <pedagogie@uvt.tn>' . "\r\n";


		mail($to,$sub,$msg,$headers);
	}
	
	
	public function inscriptionbienenregistrer(){
		
	}
}