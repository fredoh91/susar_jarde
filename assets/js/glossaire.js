const affJsonForm = document.getElementById('aff-json');
const resuJson = document.getElementById('resu-json');
const TableGlossaire = document.getElementById('TableGlossaire');
const adrServeur = window.location.host;

affJsonForm.addEventListener('submit', recupjson)

function recupjson(evt) {
    const RechIndic = document.getElementById('RechIndic').value;

    evt.preventDefault();

    fetch(`http://${adrServeur}/susar_jarde/public/index.php/retour_json/${RechIndic}`)
    // fetch(`http://172.16.71.227/susar_jarde/public/index.php/retour_json/${RechIndic}`)
    // fetch(`http://localhost/susar_jarde/public/index.php/retour_json/${RechIndic}`)
        .then(data => data.json())
        .then(jsonData => {
            // console.log('jsonData : ',jsonData);
            // console.log('jsonData.length : ',jsonData.length);
            if (jsonData.length === 0) {
                console.log('pas de résultats');
                TableGlossaire.innerHTML = 'pas de résultats';
            } else {
                // resuJson.innerHTML = `<pre><code>${JSON.stringify(jsonData, null, 4)}</code></pre>`;
                // let tab = `<tr><th>id</th><th>Indication</th><th>pole_court</th></tr>`;
                // let tab = `<tr>
                //             <th>Indication</th>
                //             <th>pole_court</th>
                //             </tr>`;


                let tab = `<thead>
                                <tr>
                                    <th scope="col">Indication</th>
                                    <th scope="col">pole_court</th>
                                </tr>
                            </thead>`;
                tab += `<tbody>`;
                // <tr>
                //   <th scope="row">1</th>
                //   <td>Mark</td>
                //   <td>Otto</td>
                //   <td>@mdo</td>
                // </tr>
                // <tr>
                //   <th scope="row">2</th>
                //   <td>Jacob</td>
                //   <td>Thornton</td>
                //   <td>@fat</td>
                // </tr>
                // <tr>
                //   <th scope="row">3</th>
                //   <td colspan="2">Larry the Bird</td>
                //   <td>@twitter</td>
                // </tr>
                jsonData.forEach((Glossaire) => {
                    tab += `<tr>
                                <td>${Glossaire.itemGlossaire}</td>	
                                <td>${Glossaire.pole_court}</td>		
                            </tr>`;

                }

                );
                tab += `</tbody>`;

                TableGlossaire.innerHTML = tab;

            }

        })
}