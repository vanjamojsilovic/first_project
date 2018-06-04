<?php

include_once 'website_layout.html';
 
require('libs/db_methods.php');
$datum_err = $ime_err  = $prezime_err= '';



//sprecava dase bilo sta dogadja dok ne pritisnemo submit

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    


    $dan= (!empty($_POST['bday'])? '' :0);
   $mesec= (!empty($_POST['bday'])?'':0);
   $godina= (!empty($_POST['bday'])?'':0);
    
   
     if (empty($_POST['ime']) || empty($_POST['prezime'])){
        $ime_err = (empty($_POST['ime']) ? 'Required!' : '');
        $prezime_err = (empty($_POST['prezime']) ? 'Required!' : '');
        $datum_err = (empty($_POST['bday'])  ? 'Required!' :  '');
        

// dodeljivanje null vrednosti
        $globalArray = array (
                                'ime' => $_POST['ime'],
                                'prezime' => $_POST['prezime'],
                                'dan_rodjenja' => $dan,
                                'mesec_rodjenja' => $mesec,
                                'godina_rodjenja' => $godina
                                );
        $GLOBALS['form_values'] = $globalArray;
    }
    // ako je sve uneto kako treba
    else
    { 
     
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agencija";

        $ime_zaposleni ="";
        $prezime_zaposleni="";
        $srednje_ime_zaposleni="";
        $jmbg_zaposleni="";
        $godina_rodjenja="";
        $mesec_rodjenja="";
        $dan_rodjenja="";
        $crta="-";
        $datum_rodjenja_zaposleni="";
        $pol="";

       



        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $ime_zaposleni =test_input($_POST["ime"]);
          $prezime_zaposleni= test_input($_POST["prezime"]);
          $srednje_ime_zaposleni= test_input($_POST["srednje_ime"]);
          $jmbg_zaposleni= test_input($_POST["jmbg"]);
//         
          $datum_rodjenja_zaposleni=$_POST["bday"];
          if($_POST["pol"]=="muski")
              {$pol="m";}
              else
              {$pol="z";};
         }

        $insert_data=array('ime'=>$ime_zaposleni, 
                           'prezime'=>$prezime_zaposleni,
                           'srednje_ime'=>$srednje_ime_zaposleni,
                           'jmbg'=>$jmbg_zaposleni,
                           'datum_rodjenja'=>$datum_rodjenja_zaposleni,
                           'pol'=>$pol);
        
        $variable=new data_management();
        $insert_result=$variable->insert_data('zaposleni', $insert_data);

        // Create connection
       

        if ($insert_result === TRUE) {
            header('Location: ponovo.php');

        } else {
            echo "Error: " . $sql . "<br>" ;
        }

     
        // posle unosenja vrednosti u bazu, dodeljujemo prazne stringove
        // da bi smo imali novi unos - reset
//   
        
    
    }
}

// cuvanje prethodno unetih vrednosti cak i kad nisu sve unete
if (isset($GLOBALS['form_values']) && !empty($GLOBALS['form_values'])){
    extract($GLOBALS['form_values']);
    
}
else{
    // kada se prvi put otvara strana
    $ime = '';
    $prezime = '';
    $dan_rodjenja = '';
    $mesec_rodjenja = '';
    $godina_rodjenja = '';
}
echo '<div class="column middle">';
include_once 'forma_za_unos.html';
include_once 'small_serch.html';
echo '</div>';

include_once 'right_side.html';


