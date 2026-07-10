import { state } from "../state.js";

import {
    getCellValue,
    setCellValue
} from "./cell.js";


import {
    getColumnName
} from "./columnName.js";


import {
    addResizeHandle
} from "../resize/resizeHandle.js";


import {
    saveTableDelayed
} from "../api/api.js";



const tableBody =
    document.getElementById("table-body");



export function renderTable(){


    tableBody.innerHTML="";


    let lastCell=null;



    for(let row=0; row<=state.rows; row++){


        const tr =
            document.createElement("tr");



        for(let col=0; col<=state.columns; col++){


            const cell =
                document.createElement("td");



            cell.classList.add("cell");



            if(row===0 || col===0){

                cell.classList.add(
                    "header-cell"
                );

                cell.contentEditable=false;


            }
            else{

                cell.contentEditable=true;

            }



            cell.textContent =
                getDisplayValue(row,col);



            cell.addEventListener(
            "input",
            ()=>{


                setCellValue(
                    row,
                    col,
                    cell.textContent
                );


                saveTableDelayed();


            });



            tr.appendChild(cell);


            lastCell=cell;

        }


        tableBody.appendChild(tr);

    }



    addResizeHandle(lastCell);

}




function getDisplayValue(row,col){


    if(row===0 && col===0)
        return "";



    if(row===0)
        return getColumnName(col-1);



    if(col===0)
        return row;



    return getCellValue(row,col);

}