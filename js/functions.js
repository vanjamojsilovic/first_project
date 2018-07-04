function ResetFields(formName, elementNameArray, defaultValue){        
        for (i = 0; i < elementNameArray.length; i++) {
            document.getElementById(formName).elements.namedItem(elementNameArray[i]).value = defaultValue;
        }
    }

function loadPage(pagePath){
    window.location.href = pagePath;
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
    
function ResetLabels(formName, elementNameArray, defaultValue){

    for (i = 0; i < elementNameArray.length; i++) {
        document.getElementById(formName).elements.namedItem(elementNameArray[i]).value = defaultValue;
    }
} 

function getFilterListPage(pageValue){
    var e = document.getElementById("select_limit");
    var selected_page_size = e.options[e.selectedIndex].value;
    history.pushState({}, "", "search_list.php?page=" + pageValue + "&size=" + selected_page_size);

}

function Change_limit_search(){
    var e = document.getElementById("select_limit");
    var selected_page_size = e.options[e.selectedIndex].value;       
    history.pushState({}, "", "search_list.php?page=0"+"&size=" + selected_page_size);
    window.location.reload();
}

function Delete_row_search(selected_id){       
    if (confirm("Are you absolutely sure you want to delete?")) {            
        history.pushState({}, "", "search_list.php?delete=" + selected_id);
        document.getElementById("form_filter").submit();
    } 
}         

function Update_select(selected_id){
    history.pushState({}, "", "update_form.php?update=" + selected_id+"&insert_update=" + "Update");       
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

function Vrati(){
    window.location.href = "index.php";
}

function InsertOrUpdate(value){
    history.pushState({}, "", "update_form.php?insert_update=" + value);
    window.location.reload();
}
