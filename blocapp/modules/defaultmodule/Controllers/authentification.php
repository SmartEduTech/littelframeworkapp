<?php
namespace blocapp\modules\defaultmodule\Controllers;

use  Smartedutech\Littlemvc\mvc\Controller;
use  Smartedutech\Littlemvc\mvc\View;
use  Smartedutech\Littlemvc\dbadapter;
use  Smartedutech\Littlemvc\Utils; 

class authentification extends Controller
{
  public function Acceuil(){
        $Vue=new View();
        $Vue->titre="E-Lab reservation";

        $Vue->generate();
    }
    public function login(){
        $Vue=new View();
        $Vue->setlayout("auth");
        $Vue->titre="";
        $Vue->generate();
    }
public function logincoordinateur(){
        $Vue=new View();
        $Vue->setlayout("auth");
        $Vue->titre="";
        $Vue->generate();
    }
    public function authentifier(){



       $login= trim($this->_getRequest("login"));
       $MPW= trim($this->_getRequest("password")); 
         $authentification=dbadapter::SelectSQL("SELECT * FROM personnes  WHERE login='$login' AND pwd=md5('$MPW') ");
         //die("SELECT * FROM personnes  WHERE email='$login' AND password=md5('$MPW') ");
        if($authentification && $authentification[0]['idroles']!='Admin'){
            //print_r($authentification);die();
            @ session_start();
            $_SESSION['authentifier']=true;
            $_SESSION['username']=$authentification[0]['nom']." ".$authentification[0]['prenom'];
            $_SESSION['ROLE']="Admin";
            $_SESSION['idpersonnes']=$authentification[0]['idpersonnes'];
            header('Location: index.php?activity=menuadmin');


        }else{

            header('Location: index.php?activity=login');
            } 


    }
	
	 public function authentifiercoordinateur(){



       $login= trim($this->_getRequest("login"));
       $MPW= trim($this->_getRequest("password")); 
         $authentification=dbadapter::SelectSQL("SELECT * FROM personnes  WHERE email='$login' AND password=md5('$MPW') AND idroles='Coordinateur'");
        //  die("SELECT * FROM personnes  WHERE email='$login' AND password=md5('$MPW')  AND idroles='Coordinateur' ");
        if($authentification){
            //print_r($authentification);die();
            @ session_start();
            $_SESSION['authentifier']=true;
            $_SESSION['username']=$authentification[0]['nom']." ".$authentification[0]['prenom'];
            $_SESSION['ROLE']="Coordinateur";
            $_SESSION['idpersonnes']=$authentification[0]['idpersonnes'];
			$_SESSION['mesformation']=json_decode($authentification[0]['acces'],true);
            header('Location: index.php?activity=mesproposition');


        }else{

            header('Location: index.php?activity=coordinateur');
            } 


    }


    public function deconnecter(){
        session_destroy();
        unset($_SESSION);
        header('Location: index.php?activity=login');
    }
	
	
	public function createpasssword(){
		 $Vue=new View();
		 $Vue->setlayout("auth");  
            $code=$this->_getRequest("code",""); 
			$Vue->code = $code;
		$Vue->titre = " ";
		$Vue->generate();
		
	}
	
	public function savepasssword(){
		  
        
	 
		$code=$this->_getRequest("code",""); 
		$password=$this->_getRequest("password","");
		$codeDecrypt=Utils::decrypt2($code);
		 
		$DemandeRecs=dbadapter::SelectSQL("SELECT * FROM personnes WHERE idpersonnes=$codeDecrypt ");
		
		
		if(isset($DemandeRecs[0]['idpersonnes']) && !empty($DemandeRecs[0]['idpersonnes'])){
			$stdClass= new \stdClass();
			$stdClass->password=$password;
			$Where= new \stdClass();
			// echo $DemandeRecs[0]['idpersonnes'];
			$Where->idpersonnes=$DemandeRecs[0]['idpersonnes'];
            dbadapter::UpdatePassWord('personnes',$stdClass,$Where);
		    header('Location: index.php?activity=coordinateur');

		
		}else{
			header("Location: index.php?activity=definir-mot-depasse&code=$code");
		}
	}
}
