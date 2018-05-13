    
   
    
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
    
    //        change background color of input elelment
        
    function Change_bgcolor(input_name, form_name){
              
                document.getElementById(form_name).elements.namedItem(input_name).style.backgroundColor = "red";
             console.log(document.getElementById(form_name).elements.namedItem(input_name).style.backgroundColor);
            
        }
    