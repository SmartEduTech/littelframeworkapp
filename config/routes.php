<?php

global $_Routes;
$_Routes=array(
  "index"=>array(
                      "Module"=>"defaultmodule"
                      ,"Controller"=>"index"
                      ,"Action"=>"index"
                      ,"Roles"=>array()
  ), 
  
  "menuadmin"=>array(
                      "Module"=>"defaultmodule"
                      ,"Controller"=>"index"
                      ,"Action"=>"menuadmin"
                      ,"Roles"=>array()
  ),
  
  "login"=>array(
      "Module"=>"defaultmodule"
      ,"Controller"=>"authentification"
      ,"Action"=>"login"
      ,"Roles"=>array()
  ),
    
  
  "authentifier"=>array(
      "Module"=>"defaultmodule"
      ,"Controller"=>"authentification"
      ,"Action"=>"authentifier"
      ,"Roles"=>array( )
  )
,"deconnecter"=>array(
      "Module"=>"defaultmodule"
    ,"Controller"=>"authentification"
    ,"Action"=>"deconnecter"
    ,"Roles"=>array( )
  )

,"acceuil"=>array(
      "Module"=>"default"
  ,"Controller"=>"authentification"
  ,"Action"=>"acceuil"
  ,"Roles"=>array( )
  ) 
  
 ,"adduser"=>array(
  "Module"=>"admin"
  ,"Controller"=>"adminer"
  ,"Action"=>"adduser"
  ,"Roles"=>array("Admin"=>"Admin" )
),

 "saveuser"=>array(
  "Module"=>"admin"
  ,"Controller"=>"adminer"
  ,"Action"=>"saveuser"
  ,"Roles"=>array("Admin"=>"Admin" )
),
 "statistiqueglobal"=>array(
  "Module"=>"admin"
  ,"Controller"=>"adminer"
  ,"Action"=>"statistiqueglobal"
  ,"Roles"=>array("Admin"=>"Admin" )
),

     "gestionuser"=>array(
  "Module"=>"admin"
  ,"Controller"=>"adminer"
  ,"Action"=>"gestionuser"
  ,"Roles"=>array("Admin"=>"Admin" )
),  
     
);
