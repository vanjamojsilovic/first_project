<?php
session_start();
include_once 'website_layout.html';

require('libs/db_methods.php');
$datum_err = $ime_err  = $prezime_err= '';




// cuvanje prethodno unetih vrednosti cak i kad nisu sve unete

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
                

    $dan= (!empty($_POST['bday'])? '' :0);
   $mesec= (!empty($_POST['bday'])?'':0);
   $godina= (!empty($_POST['bday'])?'':0);
    
   
//     if (empty($_POST['ime']) || empty($_POST['prezime'])){
//        $ime_err = (empty($_POST['ime']) ? 'Required!' : '');
//        $prezime_err = (empty($_POST['prezime']) ? 'Required!' : '');
//        $datum_err = (empty($_POST['bday'])  ? 'Required!' :  '');
        

// dodeljivanje null vrednosti
        $globalArray = array (
                                'ime' => $_POST['ime'],
                                'prezime' => $_POST['prezime'],
                                'dan_rodjenja' => $dan,
                                'mesec_rodjenja' => $mesec,
                                'godina_rodjenja' => $godina
                                );
        $_SESSION['data_array'] = $globalArray;
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

       



//        if ($_SERVER["REQUEST_METHOD"] == "POST") {
//          $ime_zaposleni =test_input($_POST["ime"]);
//          $prezime_zaposleni= test_input($_POST["prezime"]);
//          $srednje_ime_zaposleni= test_input($_POST["srednje_ime"]);
//          $jmbg_zaposleni= test_input($_POST["jmbg"]);
//          $datum_rodjenja_zaposleni=$_POST["bday"];
//          if($_POST["pol"]=="muski")
//              {$pol="m";}
//              else
//              {$pol="z";};
         }

         $_SESSION['data_array'] =array('ime'=>$ime_zaposleni, 
                                    'prezime'=>$prezime_zaposleni,
                                    'srednje_ime'=>$srednje_ime_zaposleni,
                                    'jmbg'=>$jmbg_zaposleni,
                                    'datum_rodjenja'=>$datum_rodjenja_zaposleni,
                                    'pol'=>$pol);
                                
        $variable=new data_management();
        $employees_list =$variable->search_data('zaposleni', $_SESSION['data_array'],$_SESSION['employees_filter_list_page'],10);

        // Create connection
       
        
        if ($employees_list === TRUE) {
            include_once 'small_search.html';

        } else {
            echo "Error: " ;
        }

     
        // posle unosenja vrednosti u bazu, dodeljujemo prazne stringove
        // da bi smo imali novi unos - reset
//   
        
    
    }

if (isset($_SESSION['data_array']) && !empty($_SESSION['data_array'])){
                extract($_SESSION['data_array']);

            }
            else{
                // kada se prvi put otvara strana
                $ime = '';
                $prezime = '';
                $dan_rodjenja = '';
                $mesec_rodjenja = '';
                $godina_rodjenja = '';
            }

include_once 'full_search.html';


include_once 'small_search.html';

echo "</div>";

include_once 'right_side.html';