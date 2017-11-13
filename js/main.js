function changeSort(){
    const sort = document.getElementById('sort-select').value;
    window.location.replace("/index.php?sort=" + sort);
}