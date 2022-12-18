var music_query = document.getElementById("music_search");
var music_results_container = document.getElementById("music_results_container");
if (music_query)
{
    music_query.addEventListener('input',function(e){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = ()=>
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var check = xmlhttp.responseText;
                console.log(check);
                music_results_container.innerHTML = check;
            }
        };
        xmlhttp.open("POST", "../../handlers/?task=music_query", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send("music_query="+e.target.value);
    });
}