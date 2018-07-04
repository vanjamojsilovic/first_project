<?php

session_start();

include_once 'website_layout.html';
 
require('libs/db_methods.php');
$datum_err = $ime_err  = $prezime_err= '';

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if (empty($_POST['ime']) || empty($_POST['prezime']) || empty($_POST['bday'])){
      
        $ime_err = (empty($_POST['ime']) ? 'Required!' : '');
        $prezime_err = (empty($_POST['prezime']) ? 'Required!' : '');
        $datum_err = (empty($_POST['bday'])  ? 'Required!' :  '');        

        if (!empty($_POST['ime']) && isset($_POST["ime"])){            
            $_SESSION['update_data']['ime']=$_POST['ime'];                     
        }
        
        
        if (!empty($_POST['prezime'])&& isset($_POST["prezime"])){           
            $_SESSION['update_data']['prezime']=$_POST['prezime'];
        }
        if (!empty($_POST['srednje_ime']) && isset($_POST["srednje_ime"])){            
            $_SESSION['update_data']['srednje_ime']=$_POST['srednje_ime'];                    
        }
        
        if (!empty($_POST['bday']) && isset($_POST["bday"])){           
            $_SESSION['update_data']['datum_rodjenja']=$_POST['bday'];
        }       
        
        if (!empty($_POST['jmbg'])&& isset($_POST["jmbg"])){
            $_SESSION['update_data']['jmbg']=$_POST['jmbg'];                              
        }
       
        if (!empty($_POST['pol']) && isset($_POST["pol"])){           
            $_SESSION['update_data']['pol']=$_POST['pol'];
        }       
    }       

    // ako je sve uneto kako treba
    else{     
        $ime_zaposleni = test_input($_POST["ime"]);
        $prezime_zaposleni = test_input($_POST["prezime"]);
        $srednje_ime_zaposleni = test_input($_POST["srednje_ime"]);
        $jmbg_zaposleni = test_input($_POST["jmbg"]);       
        $datum_rodjenja_zaposleni = $_POST["bday"];

        if(isset($_POST["pol"])){
              $pol=$_POST["pol"];                      
        }

        $_SESSION['update_data']=array('ime'=>$ime_zaposleni, 
                             'prezime'=>$prezime_zaposleni,
                             'srednje_ime'=>$srednje_ime_zaposleni,
                             'jmbg'=>$jmbg_zaposleni,
                             'datum_rodjenja'=>$datum_rodjenja_zaposleni,
                             'pol'=>$pol);

        if($_SESSION['insert_or_update']=='Update'){
            $variable=new data_management();
            $update_result=$variable->Update_post('zaposleni',$_SESSION['update_data'],$_SESSION['update_selected_id']);       

            if ($update_result === TRUE) {
                  header('Location: ponovo.php');
                  echo "Successfully!<br>" ;
            } 
            else{
                echo "ERROR!<br>" ;
            }                           
        }
        elseif($_SESSION['insert_or_update']=='Insert'){
            $variable=new data_management();
            $insert_result=$variable->insert_data('zaposleni', $_SESSION['update_data']);

            if ($insert_result === TRUE) {
                header('Location: ponovo.php');
                echo "Successfully!<br>" ;
            } 
            else {
                echo "ERROR!<br>" ;
            }   
        }
    }   
}
else{//on the beginning
    $ime = '';
    $prezime = '';    
    $srednje_ime='';
    $jmbg='';
    $datum_rodjenja='';
    if (isset($_GET['insert_update'])){
        $_SESSION['insert_or_update']=$_GET['insert_update'];
        if($_GET['insert_update']=='Insert'){
            $_SESSION['update_data']['ime']='';
            $_SESSION['update_data']['prezime']='';
            $_SESSION['update_data']['srednje_ime']='';
            $_SESSION['update_data']['jmbg']='';
            $_SESSION['update_data']['datum_rodjenja']='';
            $_SESSION['gender_male']='';
            $_SESSION['gender_female']='';
        }    
        else{           
            if (isset($_GET['update'])){         
                $employees_data = new data_management();        
                $_SESSION['update_data'] = $employees_data->Update_select($_GET['update']);//writing values into update form                             

                $_SESSION['update_selected_id']=$_GET['update'];              
            }

        $_SESSION['gender_male']=Checked_male($_SESSION['update_data']['pol']);
        $_SESSION['gender_female']=Checked_female($_SESSION['update_data']['pol']);
        }
    }
}
echo '<div class="column middle">';
include_once 'update_form.html';

echo '</div>';

include_once 'right_side.html';
