    
   var currentPage = "<?php echo $_SESSION['employees_list_page']; ?>";
    
    function Vrati(){
        window.location.href = "pocetna.php";
    }
    
    function SetLabels(formName, elementNameArray, labelName, trueNote, falseNote){
        var i;
        var conditionTrue = true;
        
        for (i = 0; i < elementNameArray.length; i++) {
            conditionTrue = conditionTrue && document.getElementById(formName).elements.namedItem(elementNameArray[i]).value != "";
        }

        
        if (conditionTrue){
            document.getElementById(labelName).innerHTML = trueNote;
            for (i = 0; i < elementNameArray.length; i++) {
                document.getElementById(formName).elements.namedItem(elementNameArray[i]).style.backgroundColor="";
            }
        }
        else{
            document.getElementById(labelName).innerHTML = falseNote;
                
            for (i = 0; i < elementNameArray.length; i++) {
                console.log(i);
                document.getElementById(formName).elements.namedItem(elementNameArray[i]).style.backgroundColor="red";
            }
        }
    }
    
    function ResetFields(formName, elementNameArray, defaultValue){
        
        for (i = 0; i < elementNameArray.length; i++) {
            document.getElementById(formName).elements.namedItem(elementNameArray[i]).value = defaultValue;
        }
    }
    
    function ResetLabels(formName, elementNameArray, defaultValue){
        
        for (i = 0; i < elementNameArray.length; i++) {
            document.getElementById(formName).elements.namedItem(elementNameArray[i]).value = defaultValue;
        }
    }
    
    function loadPage(pagePath){
        window.location.href = pagePath;
    }
    
    function getListPage(pageValue){
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;
        history.pushState({}, "", "select_table.php?page=" + pageValue + "&size=" + selected_page_size);

    }
    
    function getFilterListPage(pageValue){
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;
        history.pushState({}, "", "search_list.php?page=" + pageValue + "&size=" + selected_page_size);

    }
    
    function getFullFilterListPage(pageValue){
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;
        history.pushState({}, "", "full_search.php?page=" + pageValue + "&size=" + selected_page_size);

    }
    
    function Unos(){
        window.location.href = "forma_za_unos.php";
        }
        
    function Select_table(){
        window.location.href = "select_table.php";   
        }
        
    function Full_search(){
        window.location.href = "full_search.php";
    }
    
    function Change_limit_full(){
        console.log("aaaaa");
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;       
        history.pushState({}, "", "full_search.php?size=30&page=1");
        console.log(selected_page_size);
    }
    
    function Change_limit_select(){
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;       
        history.pushState({}, "", "select_table.php?size=" + selected_page_size);

    }
    
    function Change_limit_search(){
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;       
        history.pushState({}, "", "search_list.php?size=" + selected_page_size);

    }
    
    