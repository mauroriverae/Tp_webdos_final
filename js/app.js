"use strict";
const api = "http://localhost/web2/TpFinal/Tp_webdos_final/api/company";

let form = document.querySelector('#form_add');
form.addEventListener('submit', addCompany);

async function getCompany(){
    try {
        let response = await fetch(api);
        if (response.ok){
            let companies = await response.json();
            showCompany(companies)
        }else{
            throw new Error("Recurso no existente");
        }
    } catch (e) {
        console.log(e);
    }

}


function showCompany(companies){
    let ul = document.querySelector("#li");
    ul.innerHTML = "";
    for (const company of companies) {
        ul.innerHTML += `<tr>
                            <td>${company.Tiker}</td>
                            <td>${company.Company}</td>
                            <td>${company.Sector}</td>
                            <td>
						        <a type='button' class='btn btn-danger'>Borrar</a>
						        <a data-task${company.id} type='button' class='btn btn-warning btn-delete'>modificar</a>
					        </td>
                         </tr>`;
    }
}


async function addCompany(e){
    e.preventDefault();
    let data = new FormData(form);

    let company = {
        Company: data.get('Company'),
        Sector: data.get('Sector'),
        Tiker: data.get('Tiker'),
    };

    try {
        let response = await fetch(api, {
            method: "POST",
            headers: {'Content-Type' : 'application/json'},
            body: JSON.stringify(company)
        });
        if (!response.ok)
            throw new Error('Recurso no existe');
        getCompany();
        form.reset()

    } catch (e) {
        console.log(e)
    }
}

getCompany();