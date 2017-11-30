function checkArrEquality(array1, array2) {

    function equalToArr2(curr, index) {
        return curr === array2[index];
    }

    var result = array1.every(equalToArr2) && array1.length === array2.length;

    console.log(result);
}

checkArrEquality([1, 2, 3, 4, 5], [1, 2, 3, 4, 5]);