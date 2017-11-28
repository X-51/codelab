function checkIfPalindrome(word) {
    var arr = word.split("")
    // Input value should be string
    // It is not validated and/or converted not to make code messy
    // In real world situation you will have to take that into account
    var obj = Object.assign({},arr);
    var arrReversed = arr.reverse();
    var objReversed = Object.assign({},arrReversed);

    for(let i = 0; i < arr.length; i++) {
        if (obj[i]!==objReversed[i]) {
            console.log('Not palindrome');
            break;
        } else if (i===arr.length-1) {
            console.log('Palindrome')
        }
    }
}

checkIfPalindrome('AbbA'); //Palindrome