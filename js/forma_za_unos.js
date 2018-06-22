    
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
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;       
        history.pushState({}, "", "full_search.php?size=" + selected_page_size);
        window.location.reload();
    }
    
    function Change_limit_select(){
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;       
        history.pushState({}, "", "select_table.php?size=" + selected_page_size);
        window.location.reload();
    }
    
    function Change_limit_search(){
        var e = document.getElementById("select_limit");
        var selected_page_size = e.options[e.selectedIndex].value;       
        history.pushState({}, "", "search_list.php?size=" + selected_page_size);
        window.location.reload();
    }
    
    function Delete_row(selected_id){       
        if (confirm("Are you absolutely sure you want to delete?")) {            
            history.pushState({}, "", "select_table.php?delete=" + selected_id);
            document.getElementById("form_filter").submit();
        }
    }
    function Delete_row_search(selected_id){       
        if (confirm("Are you absolutely sure you want to delete?")) {            
            history.pushState({}, "", "search_list.php?delete=" + selected_id);
            document.getElementById("form_filter").submit();
        } 
    }              
    function Delete_row_full(selected_id){       
        if (confirm("Are you absolutely sure you want to delete?")) {            
            history.pushState({}, "", "full_search.php?delete=" + selected_id);
            document.getElementById("forma_unos").submit();
        }
    }
    
    function Update_select(selected_id){
        history.pushState({}, "", "update_form.php?update=" + selected_id);       
    }
    
    function ShowHideSelect(){
        var x = document.getElementById("ShowHideSearch");

        if (x.style.display==="none") {
            x.style.display = "block";
            history.pushState({}, "", "select_table.php?display=" + "block");
        } 
        else {
            x.style.display = "none";
            history.pushState({}, "", "select_table.php?display=" + "none");
        }      
        window.location.reload();
    }
    
    function ShowHideSearch(){
        var x = document.getElementById("ShowHideSearch");

        if (x.style.display==="none") {
            x.style.display = "block";
            history.pushState({}, "", "search_list.php?display=" + "block");
        } 
        else {
            x.style.display = "none";
            history.pushState({}, "", "search_list.php?display=" + "none");
        }      
        window.location.reload();
    }   
    
    