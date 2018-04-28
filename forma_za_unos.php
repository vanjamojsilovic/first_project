<?php


 

$datum_err = $ime_err  = $prezime_err= '';



//sprecava dase bilo sta dogadja dok ne pritisnemo submit

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $dan= (!empty($_POST['dan_rodjenja'])?$_POST['dan_rodjenja']:0);
    $mesec= (!empty($_POST['mesec_rodjenja'])?$_POST['mesec_rodjenja']:0);
    $godina= (!empty($_POST['godina_rodjenja'])?$_POST['godina_rodjenja']:0);

    if (empty($_POST['ime']) || empty($_POST['prezime']) || !checkdate($mesec, $dan, $godina)|| empty($dan) || empty($mesec) || empty($godina))
    {
        $ime_err = (empty($_POST['ime']) ? 'Обавезно унети!' : '');
        $prezime_err = (empty($_POST['prezime']) ? 'Обавезно унети!' : '');
        $datum_err = ((empty($dan) || empty($mesec) || empty($godina)) ? 'Обавезно унети!' : (!checkdate($mesec,$dan,$godina) ? 'Neispravan datum' : ''));
        
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
      /*  Action(); 
     echo" <script type='text/javascript'>  
         var a=\"konekcija.php\";
        document.getElementById(\"forma_unos\").action = a;
        document.getElementById(\"forma_unos\").submit();
             </script>";
        */
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

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }



        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $ime_zaposleni =test_input($_POST["ime"]);
          $prezime_zaposleni= test_input($_POST["prezime"]);
          $srednje_ime_zaposleni= test_input($_POST["srednje_ime"]);
          $jmbg_zaposleni= test_input($_POST["jmbg"]);
          $godina_rodjenja=$_POST["godina_rodjenja"];
          $mesec_rodjenja=$_POST["mesec_rodjenja"];
          $dan_rodjenja=$_POST["dan_rodjenja"];
          $datum_rodjenja_zaposleni=$godina_rodjenja.$crta.$mesec_rodjenja.$crta.$dan_rodjenja;
          if($_POST["pol"]=="muski")
              {$pol="m";}
              else
              {$pol="z";};
         }




        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO zaposleni (ime, prezime, srednje_ime, jmbg, datum_rodjenja,pol) "
                . "VALUES ('$ime_zaposleni',"
                . "'$prezime_zaposleni',"
                . "'$srednje_ime_zaposleni',"
                . "'$jmbg_zaposleni',"
                . "'$datum_rodjenja_zaposleni',"
                . "'$pol')";

        if ($conn->query($sql) === TRUE) {
            header('Location: ponovo.php');

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        // posle unosenja vrednosti u bazu, dodeljujemo prazne stringove
        // da bi smo imali novi unos - reset
//    $GLOBALS['form_values'] = array (
//                                'ime' => '',
//                                'prezime' => '',
//                                'dan_rodjenja' => '',
//                                'mesec_rodjenja' => '',
//                                'godina_rodjenja' => ''
//                                ); 
        
    
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

include_once 'forma_za_unos.html';
?>
