function changeSort(time){
    const sort = document.getElementById('sort-select').value;
    window.location.replace('/index.php?sort=' + sort + '&time=' + time);
}

function changeSearchSort(time, term, page){
    const sort = document.getElementById('sort-select').value;
    window.location.replace('/search.php?sort=' + sort + '&time=' + time + '&searchterm=' + term + '&page=' + page);
}

var labels = document.getElementsByClassName('items-list-right');

for (var i = 0, len = labels.length; i < len; i++) {
    
    if(labels[i].innerHTML == '<b>Lost</b>'){
        labels[i].style.color = 'red';
    }
    else if(labels[i].innerHTML == '<b>Found</b>'){
        labels[i].style.color = 'green';
    }

}

function checkSame(){
    var first = document.getElementById('type_password').value;
    var second = document.getElementById('retype_password').value;

    if(first === second){
        document.forms[0].submit();
    }
    else{
        alert('Passwords must match');
        return false;
    }
}