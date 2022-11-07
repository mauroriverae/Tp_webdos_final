"use strict";
const API_URL = "http://localhost/TPE2F/api/company";

async function getCompany(){
    try{
        let response = await fetch(API_URL);
        let companies = await response.json();
        console.log(companies);
    } catch(e){
        console.log(e);
    }
}

getCompany();

// 42min y 34s 25/10