function palindromeFinder(myNumber) {
    myNumber+=0;
    
    if(myNumber == undefined || myNumber < 0 || Number.isInteger(myNumber) == false) {
        console.log("Invalid data");
        return false;
    }

    var init = myNumber+1;
    
    var initToStr = ""+init;
    var strLength = initToStr.length;
    
    var arr = initToStr.split("");
    var arrLength = arr.length;
    
        for(a=0;a<arrLength;a++) 
        {
            if(arr[a]!==arr[arrLength-1-a]) {
                myNumber+=1;
                palindromeFinder(myNumber);  
                break;                              
            } 
            else if (a+1==arrLength)
            {
               console.log('Your palindrome is '+init)
            }
        }
}

palindromeFinder(655346);