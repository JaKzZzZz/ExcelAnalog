import { state } from "../state.js";


export async function loadTable() {


    const response =
        await fetch("/public/api/table.php");


    const data =
        await response.json();



    state.rows = data.rows;

    state.columns = data.columns;

    state.cells = data.cells ?? {};



    if(Array.isArray(state.cells)) {

        state.cells = {};

    }


}



export async function saveTable() {


    await fetch("/public/api/table.php", {


        method:"POST",


        headers:{
            "Content-Type":"application/json"
        },


        body:JSON.stringify(state)


    });


}