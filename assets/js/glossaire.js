console.log('hello glossaire');

const affJsonForm = document.getElementById('aff-json');
const resuJson = document.getElementById('resu-json');
// console.log ('affJsonForm',affJsonForm)
affJsonForm.addEventListener('submit', recupjson)

function recupjson(evt) {
    // console.log ('test recupjson');
    evt.preventDefault();
    fetch('http://localhost/susar_jarde/public/index.php/retour_json')
        .then(data => data.json())
        .then(jsonData => {
            console.log(jsonData);
            resuJson.innerHTML = `<pre><code>${JSON.stringify(jsonData, null, 4)}</code></pre>`;
        })

}