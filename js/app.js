"use strict";
const api = "api/company/";
let companies = [];

let form = document.querySelector('#form_add');
form.addEventListener('submit', addCompany);

async function getCompany(){
    try {
        let response = await fetch(api);
        if(!response.ok){
            throw new Error("Recurso no existe")
        }
        companies = await response.json();
        showCompany();
    } catch (e) {
        console.log(e);
    }

}


function showCompany(){
    let ul = document.querySelector("#li");
    ul.innerHTML = "";
    for (const company of companies) {
        let html =      `<tr>
                            <td>${company.Tiker}</td>
                            <td>${company.Company}</td>
                            <td>${company.Sector}</td>
                            <td>
						        <a hrfer='#' data-company="${company.id}" type='button' class='btn btn-danger btn-delete'>Borrar</a>
						        <a hrfer='#' type='button' class='btn btn-warning'>modificar</a>
					        </td>
                         </tr>`;

        ul.innerHTML += html;
    }


    const btnsDelete = document.querySelectorAll('.btn-delete');
    for (const btnDelete of btnsDelete){
        btnDelete.addEventListener('click', deleteCompany);
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
        if (!response.ok){
            throw new Error('Recurso no existe');
        }
        
        let newCompany = await response.json();
        companies.push(newCompany);
        showCompany();
        
        form.reset()

    } catch (e) {
        console.log(e)
    }
}



async function  deleteCompany(e){
    e.preventDefault();
    try {
        let id = e.target.dataset.company;
        let response = await fetch(api + id, {method: 'DELETE'});
        if (!response.ok) {
            throw new Error("Recuso no existe");
        }
        companies = companies.filter(company => company.id != id);
        showCompany();
    } catch (e) {
        console.log(e);
    }
}
getCompany();

//minitu 46:33