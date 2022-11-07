"use strict";
const api = "http://localhost/web2/TpFinal/Tp_webdos_fina/api/company";

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
        ul.innerHTML += `<li>${company.Tiker}</li>`;
    }
}

getCompany();