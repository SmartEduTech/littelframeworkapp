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
class adminer extends Controller
{
	
	public function statistiqueglobal(){
		
		
		$Vue=new View();
		 $Vue->setlayout("simplelayout");  
            
		
		
		$sql="SELECT universite.nomuniv as label,count(idparticipation) as nbrpartice FROM participation 
					INNER JOIN universite    ON universite.codeuniv=participation.codeuniv
					INNER JOIN etablissement  ON etablissement.codeetab=participation.codeetab
  					group by participation.codeuniv ";
			$byUniv=$DemandeRecs=dbadapter::SelectSQL($sql);
			
			$Vue->byUniv=$byUniv;
			 
		$sql="SELECT etablissement.nometab as label,count(idparticipation) as nbrpartice FROM participation 
					INNER JOIN universite    ON universite.codeuniv=participation.codeuniv
					INNER JOIN etablissement  ON etablissement.codeetab=participation.codeetab
  					WHERE idmanifestation=2 group by participation.codeetab";
		$byEtab=$DemandeRecs=dbadapter::SelectSQL($sql);
		$Vue->byEtab=$byEtab;
				
		$sql="SELECT *,count(idparticipation) as nbrpartice FROM participation  
  					WHERE idmanifestation=2 group by typecandidat";			
		$byType=$DemandeRecs=dbadapter::SelectSQL($sql);
		
		$sql="SELECT typecandidat,count(idparticipation) as nbrpartice FROM participation  
  					WHERE idmanifestation=2 group by typecandidat";			
		$byType=$DemandeRecs=dbadapter::SelectSQL($sql);
		
		$Vue->byType=$byType;

 		
		$sql="SELECT formations.Label as label,count(participationecue.idparticipation) as nbrpartice FROM participation  
  			 		JOIN participationecue ON participationecue.idparticipation=participation.idparticipation
					JOIN unite  ON unite.idunite=participationecue.idunite 					
					JOIN niveauformation ON niveauformation.idniveauformation=unite.idniveauformation
					JOIN formations  ON formations.idformations=niveauformation.idformations 
					 GROUP By formations.idformations";			
		$byformation=$DemandeRecs=dbadapter::SelectSQL($sql);
		
		$Vue->byFormation=$byformation;

$sql="SELECT  count(participationecue.idparticipation) as nbrpartice FROM participationecue";			
		$byformation=$DemandeRecs=dbadapter::SelectSQL($sql);
		
		$Vue->byParticipeECUE=$byformation;


		$Vue->titre = "Lister_Titre_matiere";
		$Vue->generate();
	}
	
	
	public function saveuser(){
		
		
		
		 try{ 

			$email=$this->_getRequest("email",""); 
			$formation=$this->_getRequest("formation",""); 
			$unite=$this->_getRequest("unite",""); 	
			
			
			$InscritParticipationNewRec = new \stdClass(); 
 			
			$InscritParticipationNewRec->nom = $this->_getRequest("nom");
			$InscritParticipationNewRec->prenom = $this->_getRequest("prenom");
			$InscritParticipationNewRec->email = $this->_getRequest("email"); 
			$InscritParticipationNewRec->tel = $this->_getRequest("tel");  
			$InscritParticipationNewRec->idroles='Coordinateur';
			$lesFormations=$this->_getRequest("formation"); 
				 
			$ListeLesFormations=[];
			foreach($lesFormations as $k => $f){
				 $ListeLesFormations[]=array('formation'=>$f);
							 
			}
			$InscritParticipationNewRec->acces=json_encode($ListeLesFormations);
			
			$DemandeRecs=dbadapter::SelectSQL("SELECT * FROM personnes WHERE email='".$email."' AND idroles='Coordinateur'"); 
			
			if($DemandeRecs){
				$Where= new \stdClass();
				$Where->idpersonnes=$DemandeRecs[0]['idpersonnes']; 
				$id=dbadapter::update("personnes",$InscritParticipationNewRec,$Where);
			 
				 
			}else{
				 dbadapter::Insert("personnes",$InscritParticipationNewRec);
			}
			  
			
			echo json_encode(array("status"=>"success","message"=>"Utilisateur à été bien enregistrer")); 

        }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
            

        }
		
		
		 
	}
	
	public function adduser(){
		 $Vue=new View();
		 $Vue->setlayout("simplelayout");  
            
		$Vue->titre = "Lister_Titre_matiere";
		$Vue->generate();
		
	}
	
	public function invitationmotdepass(){
		try{
		$id=$this->_getRequest("id","");  
		
		
		$DemandeRecs=dbadapter::SelectSQL("SELECT * FROM personnes WHERE idpersonnes='".$id."'");
		if($DemandeRecs){
			$code_noncrypt =$DemandeRecs[0]['idpersonnes'];
			$email =$DemandeRecs[0]['email'];
			$code=Utils::encrypt2($code_noncrypt);
			$info=array(
			"nom"=>$DemandeRecs[0]['nom']
			,"prenom"=>$DemandeRecs[0]['prenom']
			);
			$this->sendmail($email,$code,$info);
			 
		
		 
		 echo json_encode(array("status"=>"success","message"=>"Mail envoyer."));
		  
		
		} 
		 }catch (Exception $e){
            echo json_encode(array("status"=>"erreur","message"=>$e->getMessage()));
              

        }
	}
	public function sendmail($email,$code,$infor){
		 
		$to  = $email;
 
		$sub="UVT, Service pédagogie : initialiser votre mot de passe";
		$nom= $infor["nom"];
		$prenom= $infor["prenom"];
		$mailContent = file_get_contents('./template/changepassword.phtml', true);
		
		$mailContent=str_ireplace(array('{{nom}}','{{prenom}}','{{code}}'),array($nom,$prenom,$code),$mailContent);
		$msg=$mailContent;
 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=utf-8' . "\r\n";

		// Additional headers
		$headers .= 'From: <pedagogie@uvt.tn>' . "\r\n";


		mail($to,$sub,$msg,$headers);
	}
	public function gestionuser(){
		 $Vue=new View();
        $Vue->setlayout("simplelayout"); 
                $matiereRecs=dbadapter::SelectSQL("SELECT * FROM personnes WHERE idroles='Coordinateur'");
                $Vue->liste= $matiereRecs ? $matiereRecs : array();
                $Header=array(
                       // 'idparticipation'=>\Smartedutech\Littlemvc\Langue::getString("Col_idparticipation")
                        'idpersonnes'=>\Smartedutech\Littlemvc\Langue::getString("ID")
                        ,'cin'=>\Smartedutech\Littlemvc\Langue::getString("cin")
                        ,'nom'=>\Smartedutech\Littlemvc\Langue::getString("nom")
                        ,'prenom'=>\Smartedutech\Littlemvc\Langue::getString("prenom")
                        ,'email'=>\Smartedutech\Littlemvc\Langue::getString("Col_email")
                        ,'tel'=>\Smartedutech\Littlemvc\Langue::getString("Col_tel") 
                        ,'acces'=>\Smartedutech\Littlemvc\Langue::getString("Accés") 
                                
                );
       $Vue->LinkedId=array('{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'),
        '{ids}'=>array('Table'=>'{TableRef}','Label'=>'1'));
            $Vue->Header =$Header;
                $Vue->titre = "Lister_Titre_matiere";
                $Vue->generate();
	} 
	 
}