function palindromeFinder(myNumber) {
    myNumber+=0; // get rid of leading zeros
    
    if(myNumber == undefined || myNumber < 0 || Number.isInteger(myNumber) == false) {
        console.log("Invalid data");
        return false;
    }

    var init = myNumber+1;
    
    var initToStr = ""+init;
    //var strLength = initToStr.length;
    
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
               console.log('The closest palindrome greater than given number is '+init)
            }
        }
}

palindromeFinder(8282);